using System;
using System.Collections.ObjectModel;
using System.Linq;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Input;
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

        private Bestelling? _selectedOrder;
        public Bestelling? SelectedOrder
        {
            get => _selectedOrder;
            set => SetProperty(ref _selectedOrder, value);
        }

        public ICommand ProcessOrderCommand { get; }

        public BakkerViewModel()
        {
            _context = new AppDbContext();
            ProcessOrderCommand = new RelayCommand(ProcessOrder);

            // Set up live update every 5 seconds
            _liveUpdateService = new LiveUpdateService(LoadOrders, TimeSpan.FromSeconds(5));
            _liveUpdateService.Start();

            LoadOrders().ConfigureAwait(false);
        }

        /// <summary>
        /// Implements the SetProperty method to handle property changes.
        /// </summary>
        /// <typeparam name="T">Type of the property.</typeparam>
        /// <param name="storage">Reference to the property's backing field.</param>
        /// <param name="value">New value to set.</param>
        /// <param name="propertyName">Name of the property.</param>
        /// <returns>True if the value was changed; otherwise, false.</returns>
        protected bool SetProperty<T>(ref T storage, T value, [System.Runtime.CompilerServices.CallerMemberName] string? propertyName = null)
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
                    .Include(b => b.Bestelregels)
                        .ThenInclude(br => br.Pizza)
                    .Include(b => b.Bestelregels)
                        .ThenInclude(br => br.BestelregelIngredients)
                        .ThenInclude(bi => bi.Ingredient)
                    .ToListAsync();

                Application.Current.Dispatcher.Invoke(() =>
                {
                    IncomingOrders.Clear();
                    PreparingOrders.Clear();
                    FurnaceOrders.Clear();

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
                                // Optionally handle other statuses
                        }
                    }
                });
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Error loading orders: {ex.Message}");
            }
        }

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
                    Console.WriteLine($"Error updating order: {ex.Message}");
                }
            }
        }
    }
}