﻿using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Text.Json;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Input;
using Microsoft.EntityFrameworkCore;
using NELpizza.Databases;
using NELpizza.Helpers;
using NELpizza.Model;

namespace NELpizza.ViewModels.Views
{
    internal class ExportViewModel : ObservableObject
    {
        #region Fields

        private readonly string _defaultExportPath = @"C:\Users\mrluu\AppData\Roaming\.minecraft\resourcepacks\harambe\assets";

        #endregion

        #region Properties

        private string _exportPath = string.Empty;  // Fix for CS8618
        public string ExportPath
        {
            get => _exportPath;
            set
            {
                _exportPath = value;
                OnPropertyChanged();
            }
        }

        public ICommand ExportCommand { get; }

        #endregion

        #region Constructor

        public ExportViewModel()
        {
            ExportPath = _defaultExportPath;
            ExportCommand = new RelayCommand(ExportData);
        }

        #endregion

        #region Methods

        private void ExportData(object? obj)
        {
            using var context = new AppDbContext();

            var allItems = context.CustomModelDataItems
                .Include(cmd => cmd.ParentItem)
                .Include(cmd => cmd.CustomVariations).ThenInclude(cv => cv.BlockType)
                .Include(cmd => cmd.ShaderArmors).ThenInclude(sa => sa.ShaderArmorColorInfo)
                .Include(cmd => cmd.BlockTypes).ThenInclude(cmbt => cmbt.BlockType)
                .ToList();

            var groupedItems = GroupItemsByParent(allItems);

            Directory.CreateDirectory(ExportPath);
            string filePath = Path.Combine(ExportPath, "export.yml");

            WriteExportFile(groupedItems, filePath);

            MessageBox.Show($"Export completed!\n\nFile: {filePath}", "Export", MessageBoxButton.OK, MessageBoxImage.Information);
        }

        private Dictionary<string, List<CustomModelData>> GroupItemsByParent(IEnumerable<CustomModelData> items)
        {
            return items.GroupBy(i => i.ParentItem?.Name ?? "(No Parent)")
                        .ToDictionary(
                            g => g.Key,
                            g => g.OrderBy(i => i.Name).ToList()
                        );
        }

        private void WriteExportFile(Dictionary<string, List<CustomModelData>> groupedItems, string filePath)
        {
            using var writer = new StreamWriter(filePath);

            foreach (var (parentName, items) in groupedItems)
            {
                writer.WriteLine($"{parentName}:");

                foreach (var item in items)
                {
                    string exportLine = CreateOldFormatLine(item);
                    writer.WriteLine($"  - {exportLine}");
                }

                writer.WriteLine(); // Blank line between groups
            }
        }

        private string CreateOldFormatLine(CustomModelData item)
        {
            string line = $"{item.Name} = CustomModelData: {item.CustomModelNumber}";

            // Handle Variations
            var variations = item.CustomVariations
                .OrderBy(cv => cv.BlockType?.Name)
                .ThenBy(cv => cv.Variation)
                .ToList();

            if (variations.Any())
            {
                var firstVar = variations.First();
                line += $" | {firstVar.BlockType?.Name ?? "Unknown"} {firstVar.Variation} [{firstVar.BlockData}]";
            }

            // Handle Shader Infos
            var shaderInfos = item.ShaderArmors
                .Select(sa => sa.ShaderArmorColorInfo)
                .Where(info => info != null)
                .Distinct()
                .ToList();

            if (shaderInfos.Any())
            {
                foreach (var info in shaderInfos)
                {
                    line += $" | #{info!.Name} = {info.HEX} | {info.RGB} | {info.Color}";
                }
            }

            return line;
        }

        #endregion
    }
}