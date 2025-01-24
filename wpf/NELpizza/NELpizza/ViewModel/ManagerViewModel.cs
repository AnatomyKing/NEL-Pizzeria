using Microsoft.Win32;
using System.Collections.ObjectModel;
using System.IO;
using System.Linq;
using System.Windows.Input;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;
using Microsoft.EntityFrameworkCore;
using System.Runtime.CompilerServices;

namespace NELpizza.ViewModels.Views
{
    public class ManagerViewModel : ObservableObject
    {
        private readonly AppDbContext _dbContext;

        // ================== PIZZA STUFF ==================
        public ObservableCollection<Pizza> Pizzas { get; } = new();

        private Pizza? _selectedPizza;
        public Pizza? SelectedPizza
        {
            get => _selectedPizza;
            set
            {
                if (SetProperty(ref _selectedPizza, value))
                {
                    // Whenever the selected pizza changes, refresh the form fields + ingredients
                    if (value != null)
                    {
                        PizzaNaam = value.Naam;
                        PizzaPrijs = value.Prijs;
                        PizzaBeschrijving = value.Beschrijving ?? string.Empty;
                        PizzaImage = value.Image;

                        RefreshSelectedPizzaIngredients();
                    }
                    else
                    {
                        // No pizza selected - clear form
                        PizzaNaam = string.Empty;
                        PizzaPrijs = 0;
                        PizzaBeschrijving = string.Empty;
                        PizzaImage = null;
                        SelectedPizzaIngredients.Clear();
                    }
                    OnPropertyChanged(nameof(PizzaNaam));
                    OnPropertyChanged(nameof(PizzaPrijs));
                    OnPropertyChanged(nameof(PizzaBeschrijving));
                    OnPropertyChanged(nameof(PizzaImage));
                }
            }
        }

        protected bool SetProperty<T>(ref T storage, T value, [CallerMemberName] string? propertyName = null)
        {
            if (EqualityComparer<T>.Default.Equals(storage, value))
                return false;

            storage = value;
            OnPropertyChanged(propertyName);
            return true;
        }

        // Form fields for new/updated pizza
        private string _pizzaNaam = "";
        public string PizzaNaam
        {
            get => _pizzaNaam;
            set => SetProperty(ref _pizzaNaam, value);
        }

        private decimal _pizzaPrijs;
        public decimal PizzaPrijs
        {
            get => _pizzaPrijs;
            set => SetProperty(ref _pizzaPrijs, value);
        }

        private string _pizzaBeschrijving = "";
        public string PizzaBeschrijving
        {
            get => _pizzaBeschrijving;
            set => SetProperty(ref _pizzaBeschrijving, value);
        }

        private byte[]? _pizzaImage;
        public byte[]? PizzaImage
        {
            get => _pizzaImage;
            set => SetProperty(ref _pizzaImage, value);
        }

        // ========== PIZZA -> INGREDIENT RELATION ==========

        // The actual Ingredient list for the selected pizza
        public ObservableCollection<Ingredient> SelectedPizzaIngredients { get; } = new();

        // The ingredient we want to add to the selected pizza
        private Ingredient? _ingredientToAdd;
        public Ingredient? IngredientToAdd
        {
            get => _ingredientToAdd;
            set => SetProperty(ref _ingredientToAdd, value);
        }

        // The ingredient we might remove from the selected pizza
        private Ingredient? _selectedIngredientLink;
        public Ingredient? SelectedIngredientLink
        {
            get => _selectedIngredientLink;
            set => SetProperty(ref _selectedIngredientLink, value);
        }

        // Commands for adding/removing
        public ICommand AddIngredientToPizzaCommand { get; }
        public ICommand RemoveIngredientFromPizzaCommand { get; }

        // ================== EMPLOYEE STUFF ==================
        public ObservableCollection<Employee> Employees { get; } = new();

        private Employee? _selectedEmployee;
        public Employee? SelectedEmployee
        {
            get => _selectedEmployee;
            set
            {
                if (SetProperty(ref _selectedEmployee, value))
                {
                    if (value != null)
                    {
                        EmployeeNaam = value.Naam;
                        Functie = value.Functie;
                        Email = value.Email;
                        Telefoon = value.Telefoon;
                    }
                    else
                    {
                        EmployeeNaam = "";
                        Functie = "";
                        Email = "";
                        Telefoon = "";
                    }
                    OnPropertyChanged(nameof(EmployeeNaam));
                    OnPropertyChanged(nameof(Functie));
                    OnPropertyChanged(nameof(Email));
                    OnPropertyChanged(nameof(Telefoon));
                }
            }
        }

        // Form fields for new/updated Employee
        private string _employeeNaam = "";
        public string EmployeeNaam
        {
            get => _employeeNaam;
            set => SetProperty(ref _employeeNaam, value);
        }

        private string _functie = "";
        public string Functie
        {
            get => _functie;
            set => SetProperty(ref _functie, value);
        }

        private string _email = "";
        public string Email
        {
            get => _email;
            set => SetProperty(ref _email, value);
        }

        private string _telefoon = "";
        public string Telefoon
        {
            get => _telefoon;
            set => SetProperty(ref _telefoon, value);
        }

        // ================== INGREDIENT STUFF ==================
        public ObservableCollection<Ingredient> AllIngredients { get; } = new();

        private Ingredient? _selectedIngredient;
        public Ingredient? SelectedIngredient
        {
            get => _selectedIngredient;
            set
            {
                if (SetProperty(ref _selectedIngredient, value))
                {
                    if (value != null)
                    {
                        IngredientNaam = value.Naam;
                        IngredientPrijs = value.Prijs;
                    }
                    else
                    {
                        IngredientNaam = "";
                        IngredientPrijs = 0;
                    }
                    OnPropertyChanged(nameof(IngredientNaam));
                    OnPropertyChanged(nameof(IngredientPrijs));
                }
            }
        }

        // Form fields for new/updated Ingredient
        private string _ingredientNaam = "";
        public string IngredientNaam
        {
            get => _ingredientNaam;
            set => SetProperty(ref _ingredientNaam, value);
        }

        private decimal _ingredientPrijs;
        public decimal IngredientPrijs
        {
            get => _ingredientPrijs;
            set => SetProperty(ref _ingredientPrijs, value);
        }

        // ================== COMMANDS ==================
        public ICommand AddPizzaCommand { get; }
        public ICommand UpdatePizzaCommand { get; }
        public ICommand DeletePizzaCommand { get; }
        public ICommand UploadImageCommand { get; }

        public ICommand AddEmployeeCommand { get; }
        public ICommand UpdateEmployeeCommand { get; }
        public ICommand DeleteEmployeeCommand { get; }

        public ICommand AddIngredientCommand { get; }
        public ICommand UpdateIngredientCommand { get; }
        public ICommand DeleteIngredientCommand { get; }

        public ManagerViewModel()
        {
            _dbContext = new AppDbContext();
            LoadData();

            // Pizza commands
            AddPizzaCommand = new RelayCommand(_ => AddPizza());
            UpdatePizzaCommand = new RelayCommand(_ => UpdatePizza(), _ => SelectedPizza != null);
            DeletePizzaCommand = new RelayCommand(_ => DeletePizza(), _ => SelectedPizza != null);
            UploadImageCommand = new RelayCommand(_ => UploadImage());

            // Employee commands
            AddEmployeeCommand = new RelayCommand(_ => AddEmployee());
            UpdateEmployeeCommand = new RelayCommand(_ => UpdateEmployee(), _ => SelectedEmployee != null);
            DeleteEmployeeCommand = new RelayCommand(_ => DeleteEmployee(), _ => SelectedEmployee != null);

            // Ingredient commands
            AddIngredientCommand = new RelayCommand(_ => AddIngredient());
            UpdateIngredientCommand = new RelayCommand(_ => UpdateIngredient(), _ => SelectedIngredient != null);
            DeleteIngredientCommand = new RelayCommand(_ => DeleteIngredient(), _ => SelectedIngredient != null);

            // Pizza <-> Ingredient commands
            AddIngredientToPizzaCommand = new RelayCommand(_ => AddIngredientToPizza(), _ => SelectedPizza != null && IngredientToAdd != null);
            RemoveIngredientFromPizzaCommand = new RelayCommand(_ => RemoveIngredientFromPizza(), _ => SelectedPizza != null && SelectedIngredientLink != null);
        }

        private void LoadData()
        {
            // Load pizzas
            Pizzas.Clear();
            foreach (var pizza in _dbContext.Pizzas.Include(p => p.Ingredienten)) // load the IngredientPizza relationships
            {
                Pizzas.Add(pizza);
            }

            // Load employees
            Employees.Clear();
            foreach (var employee in _dbContext.Employees.ToList())
            {
                Employees.Add(employee);
            }

            // Load all ingredients
            AllIngredients.Clear();
            foreach (var ing in _dbContext.Ingredienten.ToList())
            {
                AllIngredients.Add(ing);
            }
        }

        // ================== PIZZA CRUD ==================
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

            // Clear form
            PizzaNaam = "";
            PizzaPrijs = 0;
            PizzaBeschrijving = "";
            PizzaImage = null;

            OnPropertyChanged(nameof(PizzaNaam));
            OnPropertyChanged(nameof(PizzaPrijs));
            OnPropertyChanged(nameof(PizzaBeschrijving));
            OnPropertyChanged(nameof(PizzaImage));
        }

        private void UpdatePizza()
        {
            if (SelectedPizza == null) return;

            // Save the ID now
            var oldId = SelectedPizza.Id;

            // Apply changes
            SelectedPizza.Naam = PizzaNaam;
            SelectedPizza.Prijs = PizzaPrijs;
            SelectedPizza.Beschrijving = PizzaBeschrijving;
            SelectedPizza.Image = PizzaImage;

            _dbContext.Pizzas.Update(SelectedPizza);
            _dbContext.SaveChanges();

            // Reload everything
            LoadData();

            // Reselect the same pizza by ID
            SelectedPizza = Pizzas.FirstOrDefault(p => p.Id == oldId);
        }

        private void DeletePizza()
        {
            if (SelectedPizza == null) return;

            _dbContext.Pizzas.Remove(SelectedPizza);
            _dbContext.SaveChanges();
            Pizzas.Remove(SelectedPizza);
            SelectedPizza = null;
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

        // ================== EMPLOYEE CRUD ==================
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

            // Clear
            EmployeeNaam = "";
            Functie = "";
            Email = "";
            Telefoon = "";

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

            // Refresh
            LoadData();
            // Re-select employee
            SelectedEmployee = Employees.FirstOrDefault(e => e.Id == SelectedEmployee.Id);
        }

        private void DeleteEmployee()
        {
            if (SelectedEmployee == null) return;

            _dbContext.Employees.Remove(SelectedEmployee);
            _dbContext.SaveChanges();
            Employees.Remove(SelectedEmployee);
            SelectedEmployee = null;
        }

        // ================== INGREDIENT CRUD ==================
        private void AddIngredient()
        {
            var newIng = new Ingredient
            {
                Naam = IngredientNaam,
                Prijs = IngredientPrijs
            };
            _dbContext.Ingredienten.Add(newIng);
            _dbContext.SaveChanges();
            AllIngredients.Add(newIng);

            // Clear
            IngredientNaam = "";
            IngredientPrijs = 0;
            OnPropertyChanged(nameof(IngredientNaam));
            OnPropertyChanged(nameof(IngredientPrijs));
        }

        private void UpdateIngredient()
        {
            if (SelectedIngredient == null) return;

            SelectedIngredient.Naam = IngredientNaam;
            SelectedIngredient.Prijs = IngredientPrijs;

            _dbContext.Ingredienten.Update(SelectedIngredient);
            _dbContext.SaveChanges();

            // Refresh
            LoadData();
            // Reselect
            SelectedIngredient = AllIngredients.FirstOrDefault(i => i.Id == SelectedIngredient.Id);
        }

        private void DeleteIngredient()
        {
            if (SelectedIngredient == null) return;

            // Deleting an ingredient will also remove link table entries if OnDelete.Cascade is set
            _dbContext.Ingredienten.Remove(SelectedIngredient);
            _dbContext.SaveChanges();
            AllIngredients.Remove(SelectedIngredient);
            SelectedIngredient = null;
        }

        // ================== PIZZA <-> INGREDIENT RELATIONSHIP ==================
        private void RefreshSelectedPizzaIngredients()
        {
            SelectedPizzaIngredients.Clear();
            if (SelectedPizza == null) return;

            // Make sure we load the IngredientPizza link table
            // so we can see which ingredients are associated
            var pizzaId = SelectedPizza.Id;
            var fullPizza = _dbContext.Pizzas
                .Include(p => p.Ingredienten)
                    .ThenInclude(ip => ip.Ingredient)
                .FirstOrDefault(p => p.Id == pizzaId);

            if (fullPizza != null)
            {
                foreach (var link in fullPizza.Ingredienten)
                {
                    if (link.Ingredient != null)
                        SelectedPizzaIngredients.Add(link.Ingredient);
                }
            }
        }

        private void AddIngredientToPizza()
        {
            if (SelectedPizza == null || IngredientToAdd == null) return;

            // Check if already linked
            var existingLink = _dbContext.IngredientPizzas
                .FirstOrDefault(ip => ip.PizzaId == SelectedPizza.Id && ip.IngredientId == IngredientToAdd.Id);
            if (existingLink == null)
            {
                // Create the link
                var newLink = new IngredientPizza
                {
                    PizzaId = SelectedPizza.Id,
                    IngredientId = IngredientToAdd.Id
                };
                _dbContext.IngredientPizzas.Add(newLink);
                _dbContext.SaveChanges();
            }

            // Refresh
            RefreshSelectedPizzaIngredients();
        }

        private void RemoveIngredientFromPizza()
        {
            if (SelectedPizza == null || SelectedIngredientLink == null) return;

            var link = _dbContext.IngredientPizzas
                .FirstOrDefault(ip => ip.PizzaId == SelectedPizza.Id && ip.IngredientId == SelectedIngredientLink.Id);
            if (link != null)
            {
                _dbContext.IngredientPizzas.Remove(link);
                _dbContext.SaveChanges();
            }

            // Refresh
            RefreshSelectedPizzaIngredients();
        }
    }
}