using System;
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
    public class BakkerViewModel : ObservableObject
    {
        private readonly AppDbContext _context;
        private readonly LiveUpdateService _liveUpdateService;

        // ObservableCollection to hold "besteld" orders
        public ObservableCollection<Bestelling> Bestellingen { get; } = new();

        // Command to manually refresh orders
        public ICommand RefreshOrdersCommand { get; }

        public BakkerViewModel()
        {
            _context = new AppDbContext();

            // Initialize commands
            RefreshOrdersCommand = new RelayCommand(async _ => await LoadBestellingen());

            // Initialize LiveUpdateService to refresh every 5 seconds
            _liveUpdateService = new LiveUpdateService(async () => await LoadBestellingen(), TimeSpan.FromSeconds(5));
            _liveUpdateService.Start();

            // Initial load
            Task.Run(async () => await LoadBestellingen());
        }

        /// <summary>
        /// Loads orders with status "besteld" from the database.
        /// </summary>
        public async Task LoadBestellingen()
        {
            try
            {
                // Fetch orders with status "besteld" including related Klant and Bestelregels
                var bestellingen = await _context.Bestellings
                    .Where(b => b.Status.ToLower() == "besteld")
                    .Include(b => b.Klant)
                    .Include(b => b.Bestelregels)
                        .ThenInclude(br => br.Pizza)
                    .ToListAsync();

                // Update the ObservableCollection on the UI thread
                Application.Current.Dispatcher.Invoke(() =>
                {
                    Bestellingen.Clear();
                    foreach (var bestelling in bestellingen)
                    {
                        Bestellingen.Add(bestelling);
                    }
                });
            }
            catch (Exception ex)
            {
                // Handle exceptions (e.g., log them)
                MessageBox.Show($"Fout bij het laden van bestellingen: {ex.Message}", "Fout", MessageBoxButton.OK, MessageBoxImage.Error);
            }
        }

        /// <summary>
        /// Stops the live update when disposing the ViewModel (optional).
        /// </summary>
        public void Dispose()
        {
            _liveUpdateService.Stop();
            _context.Dispose();
        }
    }
}