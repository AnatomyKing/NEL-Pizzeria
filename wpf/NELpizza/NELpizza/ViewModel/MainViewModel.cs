using System.Windows.Input;
using NELpizza.Helpers;
using NELpizza.ViewModels.Views;
using NELpizza.ViewModels;


namespace NELpizza.ViewModels
{
    internal class MainViewModel : ObservableObject
    {
        private object? _currentView;

        public MainViewModel()
        {
            CurrentView = new BakerOrdersViewModel();
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
                "DeliveryOrdersViewModel" => new DeliveryOrdersViewModel(),
                "TrackTraceViewModel" => new TrackTraceViewModel(),
                "MenuManagementViewModel" => new MenuManagementViewModel(),
                "CustomerManagementViewModel" => new CustomerManagementViewModel(),
                _ => new BakerOrdersViewModel()
            };
        }
    }
}
