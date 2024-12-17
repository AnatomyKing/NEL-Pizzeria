﻿using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Input;
using MaterialDesignThemes.Wpf;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;

namespace NELpizza.ViewModels.Views
{
    internal class UnusedViewModel : ObservableObject
    {
        #region Fields

        private readonly AppDbContext _context;
        private bool _isDialogOpen;

        #endregion

        #region Constructor

        public UnusedViewModel()
        {
            _context = new AppDbContext();
            LoadData();

            EditCommand = new RelayCommand(OpenEditDialog, CanEdit);
        }

        #endregion

        #region Properties

        public ObservableCollection<CustomModelData> UnusedItems { get; private set; } = new ObservableCollection<CustomModelData>();

        private CustomModelData? _selectedUnusedItem;
        public CustomModelData? SelectedUnusedItem
        {
            get => _selectedUnusedItem;
            set
            {
                if (_selectedUnusedItem != value)
                {
                    _selectedUnusedItem = value;
                    OnPropertyChanged();

                    if (value != null)
                    {
                        OpenEditDialog(null);
                    }
                }
            }
        }

        public ICommand EditCommand { get; }

        #endregion

        #region Methods

        /// <summary>
        /// Loads all unused items from the database.
        /// </summary>
        private void LoadData()
        {
            UnusedItems = new ObservableCollection<CustomModelData>(
                _context.CustomModelDataItems
                    .Where(x => !x.Status)
                    .ToList()
            );

            OnPropertyChanged(nameof(UnusedItems));
        }

        /// <summary>
        /// Checks if the selected item can be edited.
        /// </summary>
        private bool CanEdit(object? parameter) => SelectedUnusedItem != null;

        /// <summary>
        /// Opens the edit dialog for the selected unused item.
        /// </summary>
        private async void OpenEditDialog(object? obj)
        {
            if (_selectedUnusedItem == null || _isDialogOpen) return;

            _isDialogOpen = true;

            try
            {
                var parentItems = new ObservableCollection<ParentItem>(_context.ParentItems.ToList());
                var blockTypes = new ObservableCollection<BlockType>(_context.BlockTypes.ToList());
                var shaderArmorColorInfos = new ObservableCollection<ShaderArmorColorInfo>(_context.ShaderArmorColorInfos.ToList());

                var viewModel = new AddEditCMDViewModel(_selectedUnusedItem, parentItems, blockTypes, shaderArmorColorInfos);
                var result = await DialogHost.Show(viewModel, "UnusedDialog");

                if (result is true)
                {
                    HandleItemStatusChange();
                    _context.SaveChanges();
                }
            }
            finally
            {
                _isDialogOpen = false;
                SelectedUnusedItem = null;
            }
        }

        /// <summary>
        /// Handles changes to the item's status after the edit dialog closes.
        /// </summary>
        private void HandleItemStatusChange()
        {
            if (_selectedUnusedItem != null && _selectedUnusedItem.Status)
            {
                UnusedItems.Remove(_selectedUnusedItem);
                OnPropertyChanged(nameof(UnusedItems));
            }
        }

        #endregion
    }
}