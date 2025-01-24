using System;
using System.Collections.Concurrent;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Linq;
using System.Runtime.CompilerServices;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Input;
using System.Windows.Threading;
using Microsoft.EntityFrameworkCore;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;



namespace NELpizza.ViewModels.Views
{
    internal class BakkerViewModel : ObservableObject
    {
        private readonly AppDbContext _context;
        private readonly LiveUpdateService _liveUpdateService;

        public ObservableCollection<Bestelling> IncomingOrders { get; set; } = new();
        public ObservableCollection<Bestelling> PreparingOrders { get; set; } = new();
        public ObservableCollection<Bestelling> FurnaceOrders { get; set; } = new();

        // Cancelled orders for the right drawer
        public ObservableCollection<Bestelling> CancelledOrders { get; set; } = new();

        private bool _isRightDrawerOpen;
        public bool IsRightDrawerOpen
        {
            get => _isRightDrawerOpen;
            set => SetProperty(ref _isRightDrawerOpen, value);
        }

        private Bestelling? _selectedOrder;
        public Bestelling? SelectedOrder
        {
            get => _selectedOrder;
            set => SetProperty(ref _selectedOrder, value);
        }

        // Commands
        public ICommand ProcessOrderCommand { get; }
        public ICommand MoveToFurnaceCommand { get; }
        public ICommand FinishCookingCommand { get; }
        public ICommand DeleteCancelledOrderCommand { get; }

        public BakkerViewModel()
        {
            _context = new AppDbContext();

            // Commands
            ProcessOrderCommand = new RelayCommand(ProcessOrder);
            MoveToFurnaceCommand = new RelayCommand(MoveToFurnace);
            FinishCookingCommand = new RelayCommand(FinishCooking);
            DeleteCancelledOrderCommand = new RelayCommand(DeleteCancelledOrder);

            // Live update every 5 seconds
            _liveUpdateService = new LiveUpdateService(LoadOrders, TimeSpan.FromSeconds(5));
            _liveUpdateService.Start();

            // Initial load
            LoadOrders().ConfigureAwait(false);
        }

        protected bool SetProperty<T>(ref T storage, T value, [CallerMemberName] string? propertyName = null)
        {
            if (EqualityComparer<T>.Default.Equals(storage, value))
                return false;

            storage = value;
            OnPropertyChanged(propertyName);
            return true;
        }

        private async Task LoadOrders()
        {
            try
            {
                var orders = await _context.Bestellings
                    .Include(b => b.Klant)
                    .Include(b => b.Bestelregels).ThenInclude(br => br.Pizza)
                    .Include(b => b.Bestelregels).ThenInclude(br => br.BestelregelIngredients)
                        .ThenInclude(bi => bi.Ingredient)
                    .ToListAsync();

                Application.Current.Dispatcher.Invoke(() =>
                {
                    IncomingOrders.Clear();
                    PreparingOrders.Clear();
                    FurnaceOrders.Clear();
                    CancelledOrders.Clear();

                    foreach (var order in orders)
                    {
                        switch (order.Status)
                        {
                            case "besteld":
                                IncomingOrders.Add(order);
                                break;
                            case "bereiden":
                                PreparingOrders.Add(order);
                                break;
                            case "inoven":
                                FurnaceOrders.Add(order);
                                break;
                            case "geannuleerd":
                                CancelledOrders.Add(order);
                                break;
                                // other statuses if needed
                        }
                    }

                    OnPropertyChanged(nameof(IncomingOrders));
                    OnPropertyChanged(nameof(PreparingOrders));
                    OnPropertyChanged(nameof(FurnaceOrders));
                    OnPropertyChanged(nameof(CancelledOrders));
                });
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Error loading orders: {ex.Message}");
            }
        }

        /// <summary>
        /// Moves an order from "besteld" -> "bereiden"
        /// </summary>
        private async void ProcessOrder(object? param)
        {
            if (param is Bestelling order)
            {
                try
                {
                    order.Status = BestelStatus.bereiden.ToString();
                    _context.Bestellings.Update(order);
                    await _context.SaveChangesAsync();
                    await LoadOrders();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error updating order to bereiden: {ex.Message}");
                }
            }
        }

        /// <summary>
        /// Moves an order from "bereiden" -> "inoven"
        /// </summary>
        private async void MoveToFurnace(object? param)
        {
            if (param is Bestelling order)
            {
                try
                {
                    order.Status = BestelStatus.inoven.ToString();
                    _context.Bestellings.Update(order);
                    await _context.SaveChangesAsync();
                    await LoadOrders();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error moving order to furnace: {ex.Message}");
                }
            }
        }

        /// <summary>
        /// Moves an order from "inoven" -> "uitoven"
        /// </summary>
        private async void FinishCooking(object? param)
        {
            if (param is Bestelling order)
            {
                try
                {
                    order.Status = BestelStatus.uitoven.ToString();
                    _context.Bestellings.Update(order);
                    await _context.SaveChangesAsync();
                    await LoadOrders();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error finishing cooking: {ex.Message}");
                }
            }
        }

        /// <summary>
        /// Permanently deletes a "geannuleerd" order from the DB, 
        /// also removing child Bestelregels & BestelregelIngredients,
        /// but leaving the Klant if they have a user.
        /// </summary>
        private async void DeleteCancelledOrder(object? param)
        {
            if (param is Bestelling order)
            {
                try
                {
                    var fullOrder = await _context.Bestellings
                        .Include(o => o.Klant)
                            .ThenInclude(k => k.KlantUsers)
                        .Include(o => o.Bestelregels)
                            .ThenInclude(br => br.BestelregelIngredients)
                        .FirstOrDefaultAsync(o => o.Id == order.Id);

                    if (fullOrder == null)
                    {
                        Console.WriteLine("Cancelled order not found for deletion.");
                        return;
                    }

                    // Remove child data
                    var allIngredients = fullOrder.Bestelregels
                        .SelectMany(br => br.BestelregelIngredients)
                        .ToList();
                    _context.RemoveRange(allIngredients);

                    _context.RemoveRange(fullOrder.Bestelregels);

                    // Remove the order
                    _context.Bestellings.Remove(fullOrder);

                    // If the klant is not linked to any user, remove it too
                    var klant = fullOrder.Klant;
                    if (klant != null && !klant.KlantUsers.Any())
                    {
                        _context.Klants.Remove(klant);
                    }

                    await _context.SaveChangesAsync();
                    await LoadOrders();
                }
                catch (Exception ex)
                {
                    Console.WriteLine($"Error deleting cancelled order: {ex.Message}");
                }
            }
        }
    }
}