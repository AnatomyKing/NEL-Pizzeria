using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using NELpizza.ViewModels.Views;

namespace NELpizza.View
{
    public partial class BakkerView : UserControl
    {
        public BakkerView()
        {
            InitializeComponent();
        }

        // This method is bound to the "Show Cancelled Orders" button's Click event in XAML
        private void OpenDrawerButton_Click(object sender, RoutedEventArgs e)
        {
            if (DataContext is BakkerViewModel vm)
            {
                vm.IsRightDrawerOpen = !vm.IsRightDrawerOpen;
            }
        }
    }
}