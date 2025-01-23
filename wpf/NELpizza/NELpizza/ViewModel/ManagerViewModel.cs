using Microsoft.Win32; // For OpenFileDialog
using NELpizza.Databases;
using NELpizza.Model;
using System.IO;
using NELpizza.Helpers;
using System.Collections.ObjectModel;
using System.Windows.Input;

namespace NELpizza.ViewModels.Views
{
    public class ManagerViewModel : ObservableObject
    {
        private string _naam = string.Empty;
        private decimal _prijs;
        private string? _beschrijving;
        private byte[]? _image;
        private Pizza? _selectedPizza;

        private readonly AppDbContext _dbContext;

        public ManagerViewModel()
        {
            AddPizzaCommand = new RelayCommand(_ => AddPizza());
            UpdatePizzaCommand = new RelayCommand(_ => UpdatePizza(), _ => CanModifyOrDelete);
            DeletePizzaCommand = new RelayCommand(_ => DeletePizza(), _ => CanModifyOrDelete);
            UploadImageCommand = new RelayCommand(_ => UploadImage());

            _dbContext = new AppDbContext();
            LoadPizzas();
        }

        // Properties
        public string Naam
        {
            get => _naam;
            set { _naam = value; OnPropertyChanged(); }
        }

        public decimal Prijs
        {
            get => _prijs;
            set { _prijs = value; OnPropertyChanged(); }
        }

        public string? Beschrijving
        {
            get => _beschrijving;
            set { _beschrijving = value; OnPropertyChanged(); }
        }

        public byte[]? Image
        {
            get => _image;
            set { _image = value; OnPropertyChanged(); }
        }

        public Pizza? SelectedPizza
        {
            get => _selectedPizza;
            set
            {
                _selectedPizza = value;
                OnPropertyChanged();
                OnPropertyChanged(nameof(CanModifyOrDelete));

                if (_selectedPizza != null)
                {
                    Naam = _selectedPizza.Naam;
                    Prijs = _selectedPizza.Prijs;
                    Beschrijving = _selectedPizza.Beschrijving;
                    Image = _selectedPizza.Image;
                }
            }
        }

        public bool CanModifyOrDelete => SelectedPizza != null;

        public ObservableCollection<Pizza> Pizzas { get; set; } = new ObservableCollection<Pizza>();

        public ICommand AddPizzaCommand { get; }
        public ICommand UpdatePizzaCommand { get; }
        public ICommand DeletePizzaCommand { get; }
        public ICommand UploadImageCommand { get; }

        private void LoadPizzas()
        {
            Pizzas.Clear();
            var pizzasFromDb = _dbContext.Pizzas.ToList();
            foreach (var pizza in pizzasFromDb)
            {
                Pizzas.Add(pizza);
            }
        }

        private void AddPizza()
        {
            var newPizza = new Pizza
            {
                Naam = Naam,
                Prijs = Prijs,
                Beschrijving = Beschrijving,
                Image = Image // Save image to DB
            };

            _dbContext.Pizzas.Add(newPizza);
            _dbContext.SaveChanges();

            Pizzas.Add(newPizza);
            ClearInputs();
        }

        private void UpdatePizza()
        {
            if (SelectedPizza == null) return;

            SelectedPizza.Naam = Naam;
            SelectedPizza.Prijs = Prijs;
            SelectedPizza.Beschrijving = Beschrijving;
            SelectedPizza.Image = Image;

            _dbContext.Pizzas.Update(SelectedPizza);
            _dbContext.SaveChanges();

            OnPropertyChanged(nameof(Pizzas)); // Refresh UI
            ClearInputs();
        }

        private void DeletePizza()
        {
            if (SelectedPizza == null) return;

            _dbContext.Pizzas.Remove(SelectedPizza);
            _dbContext.SaveChanges();

            Pizzas.Remove(SelectedPizza);
            ClearInputs();
        }

        private void UploadImage()
        {
            OpenFileDialog openFileDialog = new OpenFileDialog
            {
                Filter = "Image Files|*.jpg;*.jpeg;*.png;*.bmp"
            };

            if (openFileDialog.ShowDialog() == true)
            {
                Image = File.ReadAllBytes(openFileDialog.FileName);
            }
        }

        private void ClearInputs()
        {
            Naam = string.Empty;
            Prijs = 0;
            Beschrijving = null;
            Image = null;
            SelectedPizza = null;
        }
    }
}
