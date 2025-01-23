using Microsoft.Win32;
using System.Collections.ObjectModel;
using System.IO;
using System.Linq;
using System.Windows.Input;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;

namespace NELpizza.ViewModels.Views
{
    public class ManagerViewModel : ObservableObject
    {
        private readonly AppDbContext _dbContext;

        // Observable collections for pizzas and employees
        public ObservableCollection<Pizza> Pizzas { get; } = new();
        public ObservableCollection<Employee> Employees { get; } = new();

        // Properties for Pizza form
        public string PizzaNaam { get; set; }
        public decimal PizzaPrijs { get; set; }
        public string PizzaBeschrijving { get; set; }
        public byte[]? PizzaImage { get; set; }
        public Pizza? SelectedPizza { get; set; }

        // Properties for Employee form
        public string EmployeeNaam { get; set; }
        public string Functie { get; set; }
        public string Email { get; set; }
        public string Telefoon { get; set; }
        public Employee? SelectedEmployee { get; set; }

        // Commands
        public ICommand AddPizzaCommand { get; }
        public ICommand UpdatePizzaCommand { get; }
        public ICommand DeletePizzaCommand { get; }
        public ICommand UploadImageCommand { get; }
        public ICommand AddEmployeeCommand { get; }
        public ICommand UpdateEmployeeCommand { get; }
        public ICommand DeleteEmployeeCommand { get; }

        public ManagerViewModel()
        {
            _dbContext = new AppDbContext();
            LoadData();

            // Initialize commands
            AddPizzaCommand = new RelayCommand(_ => AddPizza());
            UpdatePizzaCommand = new RelayCommand(_ => UpdatePizza(), _ => SelectedPizza != null);
            DeletePizzaCommand = new RelayCommand(_ => DeletePizza(), _ => SelectedPizza != null);
            UploadImageCommand = new RelayCommand(_ => UploadImage());

            AddEmployeeCommand = new RelayCommand(_ => AddEmployee());
            UpdateEmployeeCommand = new RelayCommand(_ => UpdateEmployee(), _ => SelectedEmployee != null);
            DeleteEmployeeCommand = new RelayCommand(_ => DeleteEmployee(), _ => SelectedEmployee != null);
        }

        private void LoadData()
        {
            // Load pizzas
            Pizzas.Clear();
            foreach (var pizza in _dbContext.Pizzas.ToList())
            {
                Pizzas.Add(pizza);
            }

            // Load employees
            Employees.Clear();
            foreach (var employee in _dbContext.Employees.ToList())
            {
                Employees.Add(employee);
            }
        }

        // Pizza CRUD Methods
        private void AddPizza()
        {
            var newPizza = new Pizza
            {
                Naam = PizzaNaam,
                Prijs = PizzaPrijs,
                Beschrijving = PizzaBeschrijving,
                Image = PizzaImage
            };

            _dbContext.Pizzas.Add(newPizza);
            _dbContext.SaveChanges();
            Pizzas.Add(newPizza);

            // Clear form fields
            PizzaNaam = string.Empty;
            PizzaPrijs = 0;
            PizzaBeschrijving = string.Empty;
            PizzaImage = null;

            OnPropertyChanged(nameof(PizzaNaam));
            OnPropertyChanged(nameof(PizzaPrijs));
            OnPropertyChanged(nameof(PizzaBeschrijving));
            OnPropertyChanged(nameof(PizzaImage));
        }

        private void UpdatePizza()
        {
            if (SelectedPizza == null) return;

            SelectedPizza.Naam = PizzaNaam;
            SelectedPizza.Prijs = PizzaPrijs;
            SelectedPizza.Beschrijving = PizzaBeschrijving;
            SelectedPizza.Image = PizzaImage;

            _dbContext.Pizzas.Update(SelectedPizza);
            _dbContext.SaveChanges();

            // Refresh the list
            LoadData();
        }

        private void DeletePizza()
        {
            if (SelectedPizza == null) return;

            _dbContext.Pizzas.Remove(SelectedPizza);
            _dbContext.SaveChanges();
            Pizzas.Remove(SelectedPizza);
        }

        private void UploadImage()
        {
            var openFileDialog = new OpenFileDialog
            {
                Title = "Select an Image",
                Filter = "Image Files|*.jpg;*.jpeg;*.png;*.bmp"
            };

            if (openFileDialog.ShowDialog() == true)
            {
                PizzaImage = File.ReadAllBytes(openFileDialog.FileName);
                OnPropertyChanged(nameof(PizzaImage));
            }
        }

        // Employee CRUD Methods
        private void AddEmployee()
        {
            var newEmployee = new Employee
            {
                Naam = EmployeeNaam,
                Functie = Functie,
                Email = Email,
                Telefoon = Telefoon
            };

            _dbContext.Employees.Add(newEmployee);
            _dbContext.SaveChanges();
            Employees.Add(newEmployee);

            // Clear form fields
            EmployeeNaam = string.Empty;
            Functie = string.Empty;
            Email = string.Empty;
            Telefoon = string.Empty;

            OnPropertyChanged(nameof(EmployeeNaam));
            OnPropertyChanged(nameof(Functie));
            OnPropertyChanged(nameof(Email));
            OnPropertyChanged(nameof(Telefoon));
        }

        private void UpdateEmployee()
        {
            if (SelectedEmployee == null) return;

            SelectedEmployee.Naam = EmployeeNaam;
            SelectedEmployee.Functie = Functie;
            SelectedEmployee.Email = Email;
            SelectedEmployee.Telefoon = Telefoon;

            _dbContext.Employees.Update(SelectedEmployee);
            _dbContext.SaveChanges();

            // Refresh the list
            LoadData();
        }

        private void DeleteEmployee()
        {
            if (SelectedEmployee == null) return;

            _dbContext.Employees.Remove(SelectedEmployee);
            _dbContext.SaveChanges();
            Employees.Remove(SelectedEmployee);
        }
    }
}
