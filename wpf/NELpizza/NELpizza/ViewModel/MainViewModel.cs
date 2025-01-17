using System;
using System.Collections.ObjectModel;
using System.Windows.Input;
using Microsoft.EntityFrameworkCore;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;
using NELpizza.ViewModels;
using NELpizza.ViewModels.Views;

namespace NELpizza.ViewModels
{
    internal class MainViewModel : ObservableObject
    {
        private object? _currentView;

        public MainViewModel()
        {
            CurrentView = new MainViewContentViewModel();
            NavigateCommand = new RelayCommand(Navigate);
        }

        public object? CurrentView
        {
            get => _currentView;
            set
            {
                _currentView = value;
                OnPropertyChanged();
            }
        }

        public ICommand NavigateCommand { get; }

        private void Navigate(object? parameter)
        {
            string? viewName = parameter as string;

            CurrentView = viewName switch
            {
                "ParentItemViewModel" => new ParentItemViewModel(),
                "UnusedViewModel" => new UnusedViewModel(),
                "BlockTypeViewModel" => new BlockTypeViewModel(),
                "KlantViewModel" => new KlantViewModel(),
                "ExportViewModel" => new ExportViewModel(),
                _ => new MainViewContentViewModel()
            };
        }
    }
}