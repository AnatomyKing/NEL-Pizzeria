using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Threading;

namespace NELpizza.Helpers
{
    public class LiveUpdateService
    {
        private readonly Func<Task> _updateAction;
        private readonly TimeSpan _interval;
        private readonly DispatcherTimer _timer;

        public LiveUpdateService(Func<Task> updateAction, TimeSpan interval)
        {
            _updateAction = updateAction ?? throw new ArgumentNullException(nameof(updateAction));
            _interval = interval;
            _timer = new DispatcherTimer
            {
                Interval = _interval
            };
            _timer.Tick += async (s, e) =>
            {
                try
                {
                    await _updateAction();
                }
                catch (Exception ex)
                {
                    // Handle exceptions (e.g., log them)
                    // For simplicity, we'll use Console.WriteLine here
                    Console.WriteLine($"LiveUpdateService error: {ex.Message}");
                }
            };
        }

        public void Start()
        {
            _timer.Start();
        }

        public void Stop()
        {
            _timer.Stop();
        }
    }
}