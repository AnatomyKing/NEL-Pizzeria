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
            CurrentView = new BakkerViewModel();
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
                "BezorgerViewModel" => new BezorgerViewModel(),
                "ManagerViewModel" => new ManagerViewModel(),
                _ => new BakkerViewModel()
            };
        }
    }
}