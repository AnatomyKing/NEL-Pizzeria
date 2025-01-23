using System;
using System.Windows.Input;
using NELpizza.Helpers;
using NELpizza.ViewModels.Views;

namespace NELpizza.ViewModels
{
    public class MainViewModel : ObservableObject
    {
        private object? _currentView;

        public MainViewModel()
        {
            CurrentView = new BakkerViewModel(); // Default view
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
            if (parameter is not string viewName)
            {
                CurrentView = new BakkerViewModel();
                return;
            }

            CurrentView = viewName switch
            {
                "BakkerViewModel" => new BakkerViewModel(),
                "BezorgerViewModel" => new BezorgerViewModel(),
                "ManagerViewModel" => new ManagerViewModel(),
                _ => new BakkerViewModel()
            };
        }
    }
}
