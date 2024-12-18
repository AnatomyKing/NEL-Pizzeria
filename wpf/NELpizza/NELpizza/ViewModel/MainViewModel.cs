using System;
using System.Collections.ObjectModel;
using System.ComponentModel;
using System.Runtime.CompilerServices;
using System.Windows;
using System.Windows.Input;
using Microsoft.EntityFrameworkCore;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;
using NELpizza.ViewModel;

namespace NELpizza.ViewModel
{
    internal class MainViewModel : INotifyPropertyChanged
    {
        private int _clickCount;

        public MainViewModel()
        {
            IncrementCommand = new RelayCommand(IncrementCounter);
            ClickCount = 0;
        }

        public int ClickCount
        {
            get => _clickCount;
            set
            {
                _clickCount = value;
                OnPropertyChanged();
            }
        }

        public ICommand IncrementCommand { get; }

        private void IncrementCounter(object parameter)
        {
            ClickCount++;
        }

        public event PropertyChangedEventHandler PropertyChanged;

        protected void OnPropertyChanged([CallerMemberName] string propertyName = null)
        {
            PropertyChanged?.Invoke(this, new PropertyChangedEventArgs(propertyName));
        }
    }

    public class RelayCommand : ICommand
    {
        private readonly Action<object> _execute;
        private readonly Predicate<object> _canExecute;

        public RelayCommand(Action<object> execute, Predicate<object> canExecute = null)
        {
            _execute = execute ?? throw new ArgumentNullException(nameof(execute));
            _canExecute = canExecute;
        }

        public bool CanExecute(object parameter) => _canExecute?.Invoke(parameter) ?? true;

        public void Execute(object parameter) => _execute(parameter);

        public event EventHandler CanExecuteChanged
        {
            add => CommandManager.RequerySuggested += value;
            remove => CommandManager.RequerySuggested -= value;
        }
    }
}
