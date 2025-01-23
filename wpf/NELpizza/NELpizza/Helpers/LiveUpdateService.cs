using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Threading;

namespace NELpizza.Helpers
{
    internal class LiveUpdateService
    {
        private readonly DispatcherTimer _timer;
        private readonly Func<Task> _updateAction;

        public LiveUpdateService(Func<Task> updateAction, TimeSpan interval)
        {
            _updateAction = updateAction ?? throw new ArgumentNullException(nameof(updateAction));

            _timer = new DispatcherTimer
            {
                Interval = interval
            };
            _timer.Tick += async (s, e) => await ExecuteUpdate();
        }

        public void Start() => _timer.Start();

        public void Stop() => _timer.Stop();

        private async Task ExecuteUpdate()
        {
            try
            {
                await _updateAction();
            }
            catch (Exception ex)
            {
                Console.WriteLine($"Error during live update: {ex.Message}");
            }
        }
    }
}