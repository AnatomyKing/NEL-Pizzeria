using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.IO;
using System.Linq;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Input;
using Microsoft.EntityFrameworkCore;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;

namespace NELpizza.ViewModels.Views
{
    internal class BezorgerViewModel : ObservableObject
    {
        private readonly AppDbContext _context;
        private readonly LiveUpdateService _liveUpdateService;

        // Collections for each section
        public ObservableCollection<Bestelling> ReadyForPickupOrders { get; set; } = new();
        public ObservableCollection<Bestelling> OnderwegOrders { get; set; } = new();
        public ObservableCollection<Bestelling> BezorgdOrders { get; set; } = new();

        // Commands
        public ICommand MoveToOnderwegCommand { get; }
        public ICommand MarkAsBezorgdCommand { get; }
        public ICommand CompleteOrderCommand { get; }

        public BezorgerViewModel()
        {
            _context = new AppDbContext();

            // Commands
            MoveToOnderwegCommand = new RelayCommand(MoveToOnderweg);
            MarkAsBezorgdCommand = new RelayCommand(MarkAsBezorgd);
            CompleteOrderCommand = new RelayCommand(CompleteOrder);

            // Example: Live update every 5 seconds
            _liveUpdateService = new LiveUpdateService(LoadOrders, TimeSpan.FromSeconds(5));
            _liveUpdateService.Start();

            // Initial load
            LoadOrders().ConfigureAwait(false);
        }

        private async Task LoadOrders()
        {
            try
            {
                // Create a fresh context each time to ensure we see external changes (e.g. from Laravel).
                using var freshContext = new AppDbContext();

                // Use AsNoTracking() so EF doesn't track these entities (no stale local caching).
                var orders = await freshContext.Bestellings
                    .AsNoTracking()
                    .Include(b => b.Klant)
                    .Include(b => b.Bestelregels).ThenInclude(br => br.Pizza)
                    .Include(b => b.Bestelregels).ThenInclude(br => br.BestelregelIngredients)
                        .ThenInclude(bi => bi.Ingredient)
                    .ToListAsync();

                // Update collections on the UI thread
                Application.Current.Dispatcher.Invoke(() =>
                {
                    ReadyForPickupOrders.Clear();
                    OnderwegOrders.Clear();
                    BezorgdOrders.Clear();

                    // Sort them into the correct collection by status
                    foreach (var order in orders)
                    {
                        switch (order.Status)
                        {
                            case "uitoven":
                                ReadyForPickupOrders.Add(order);
                                break;
                            case "onderweg":
                                OnderwegOrders.Add(order);
                                break;
                            case "bezorgd":
                                BezorgdOrders.Add(order);
                                break;
                        }
                    }

                    OnPropertyChanged(nameof(ReadyForPickupOrders));
                    OnPropertyChanged(nameof(OnderwegOrders));
                    OnPropertyChanged(nameof(BezorgdOrders));
                });
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Error loading orders for Bezorger: {ex.Message}");
            }
        }

        /// <summary>
        /// Move an order from "uitoven" -> "onderweg".
        /// </summary>
        private async void MoveToOnderweg(object? param)
        {
            if (param is Bestelling order)
            {
                try
                {
                    order.Status = BestelStatus.onderweg.ToString();
                    _context.Bestellings.Update(order);
                    await _context.SaveChangesAsync();
                    await LoadOrders();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error moving order to 'onderweg': {ex.Message}");
                }
            }
        }

        /// <summary>
        /// Move an order from "onderweg" -> "bezorgd".
        /// </summary>
        private async void MarkAsBezorgd(object? param)
        {
            if (param is Bestelling order)
            {
                try
                {
                    order.Status = BestelStatus.bezorgd.ToString();
                    _context.Bestellings.Update(order);
                    await _context.SaveChangesAsync();
                    await LoadOrders();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error marking order as 'bezorgd': {ex.Message}");
                }
            }
        }

        /// <summary>
        /// Completely remove the order from the DB (and its child data),
        /// but leave the Klant if it is associated with a User.
        /// </summary>
        private async void CompleteOrder(object? param)
        {
            if (param is Bestelling order)
            {
                try
                {
                    // Reload the order from DB with all related entities
                    var fullOrder = await _context.Bestellings
                        .Include(o => o.Klant)
                        .ThenInclude(k => k.KlantUsers)
                        .Include(o => o.Bestelregels)
                            .ThenInclude(br => br.BestelregelIngredients)
                        .FirstOrDefaultAsync(o => o.Id == order.Id);

                    if (fullOrder == null)
                    {
                        Console.WriteLine("Order not found for complete action.");
                        return;
                    }

                    // Remove all child data: BestelregelIngredients, Bestelregels
                    var allIngredients = fullOrder.Bestelregels
                        .SelectMany(br => br.BestelregelIngredients)
                        .ToList();
                    _context.RemoveRange(allIngredients);

                    _context.RemoveRange(fullOrder.Bestelregels);

                    // Remove the order itself
                    _context.Bestellings.Remove(fullOrder);

                    // Optionally remove the Klant if not tied to any user
                    var klant = fullOrder.Klant;
                    if (klant != null)
                    {
                        // If no KlantUsers exist, we can safely remove
                        if (!klant.KlantUsers.Any())
                        {
                            _context.Klants.Remove(klant);
                        }
                    }

                    await _context.SaveChangesAsync();
                    await LoadOrders();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error completing order (removing from DB): {ex.Message}");
                }
            }
        }
    }
}