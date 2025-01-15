@extends('layouts.app')

@section('title', 'Options')

@section('content')
<div class="options-container" style="max-width: 900px; margin: auto; font-family: Arial, sans-serif; padding: 20px; border-radius: 12px; background: #f9f9f9; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
    <h2 style="text-align: center; color: #333; font-size: 24px; margin-bottom: 20px;">Options</h2>

    <!-- Theme Option -->
    <div class="option-section" style="margin-bottom: 20px;">
        <h3 style="color: #555; font-size: 18px; margin-bottom: 10px;">Theme</h3>
        <div style="display: flex; gap: 20px; align-items: center;">
            <label for="theme" style="font-size: 16px; color: #555;">Select Theme:</label>
            <select id="theme" onchange="applyTheme()" style="padding: 8px; font-size: 14px; border: 1px solid #ddd; border-radius: 5px; width: 200px;">
                <option value="light">Light</option>
                <option value="dark">Dark</option>
                <option value="blue">Blue</option>
            </select>
        </div>
    </div>

    <!-- Notification Option -->
    <div class="option-section" style="margin-bottom: 20px;">
        <h3 style="color: #555; font-size: 18px; margin-bottom: 10px;">Notifications</h3>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <label style="font-size: 16px; color: #555;">
                <input type="checkbox" id="emailNotification" onclick="toggleNotification('email')" style="margin-right: 10px;">
                Enable Email Notifications
            </label>
            <label style="font-size: 16px; color: #555;">
                <input type="checkbox" id="smsNotification" onclick="toggleNotification('sms')" style="margin-right: 10px;">
                Enable SMS Notifications
            </label>
        </div>
    </div>

    <!-- Accessibility Option -->
    <div class="option-section" style="margin-bottom: 20px;">
        <h3 style="color: #555; font-size: 18px; margin-bottom: 10px;">Accessibility</h3>
        <label style="font-size: 16px; color: #555;">
            <input type="checkbox" id="highContrast" onclick="toggleHighContrast()" style="margin-right: 10px;">
            Enable High Contrast Mode
        </label>
    </div>

    <!-- Reset Settings -->
    <div class="option-section">
        <h3 style="color: #555; font-size: 18px; margin-bottom: 10px;">Reset Settings</h3>
        <button onclick="resetSettings()" style="padding: 10px 20px; font-size: 16px; background-color: #d9534f; color: #fff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
            Reset to Default
        </button>
    </div>
</div>

<script>
    function applyTheme() {
        const theme = document.getElementById('theme').value;
        document.body.className = ''; // Reset classes
        if (theme === 'dark') {
            document.body.classList.add('dark-theme');
        } else if (theme === 'blue') {
            document.body.classList.add('blue-theme');
        }
    }

    function toggleNotification(type) {
        const isEnabled = document.getElementById(`${type}Notification`).checked;
        alert(`${type.charAt(0).toUpperCase() + type.slice(1)} Notifications are now ${isEnabled ? 'enabled' : 'disabled'}.`);
    }

    function toggleHighContrast() {
        const isHighContrast = document.getElementById('highContrast').checked;
        if (isHighContrast) {
            document.body.classList.add('high-contrast');
        } else {
            document.body.classList.remove('high-contrast');
        }
    }

    function resetSettings() {
        document.body.className = ''; // Reset all body classes
        document.getElementById('theme').value = 'light';
        document.getElementById('emailNotification').checked = false;
        document.getElementById('smsNotification').checked = false;
        document.getElementById('highContrast').checked = false;
        alert('Settings have been reset to default.');
    }
</script>

<style>
    /* Theme Styles */
    .dark-theme {
        background-color: #333;
        color: #fff;
    }

    .dark-theme .options-container {
        background-color: #444;
        color: #fff;
    }

    .blue-theme {
        background-color: #e6f7ff;
        color: #0056b3;
    }

    .blue-theme .options-container {
        background-color: #d9f2ff;
        color: #004080;
    }

    /* High Contrast Mode */
    .high-contrast {
        background-color: #000;
        color: #ff0;
    }

    .high-contrast .options-container {
        background-color: #000;
        color: #ff0;
    }

    /* Button Hover */
    button:hover {
        background-color: #c9302c;
    }

    /* Option Section Styles */
    .option-section {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .option-section:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
