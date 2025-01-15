@extends('layouts.app')

@section('content')
<div class="openingstijden-container" style="display: flex; flex-wrap: wrap; gap: 30px; margin: 20px auto; max-width: 1200px; font-family: 'Arial', sans-serif;">
    <!-- Linkerkolom: Adres en Kaart -->
    <div class="openingstijden-left" style="flex: 1; min-width: 300px; background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 style="font-size: 22px; color: #333; margin-bottom: 15px;">Contactgegevens</h2>
        <address style="font-size: 16px; line-height: 1.8; color: #555;">
            <strong style="color: #007bff;">Bedrijfsnaam</strong><br>
            Straatnaam 123<br>
            1234 AB Plaatsnaam<br>
            Nederland<br><br>
            <a href="mailto:info@bedrijf.nl" style="color: #007bff; text-decoration: none;">info@bedrijf.nl</a><br>
            <a href="tel:+310123456789" style="color: #007bff; text-decoration: none;">+31 012 345 6789</a>
        </address>
        <div class="map-container" style="margin-top: 20px;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241317.1160995443!2d4.8979755!3d52.377956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c609c11d76e57b%3A0x82338be7b170fe6f!2sAmsterdam!5e0!3m2!1snl!2snl!4v1632403102938!5m2!1snl!2snl"
                width="100%"
                height="250"
                style="border: 1px solid #ddd; border-radius: 10px;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>

    <!-- Rechterkolom: Openingstijden -->
    <div class="openingstijden-right" style="flex: 1; min-width: 300px; background: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); animation: fadeIn 1s;">
        <h2 style="font-size: 22px; color: #333; margin-bottom: 15px;">Openingstijden</h2>
        <ul style="padding: 0; list-style-type: none; font-size: 16px; line-height: 1.8; color: #555;">
            <li style="display: flex; justify-content: space-between;">
                <strong>Maandag:</strong> <span>09:00 - 18:00</span>
            </li>
            <li style="display: flex; justify-content: space-between;">
                <strong>Dinsdag:</strong> <span>09:00 - 18:00</span>
            </li>
            <li style="display: flex; justify-content: space-between;">
                <strong>Woensdag:</strong> <span>09:00 - 18:00</span>
            </li>
            <li style="display: flex; justify-content: space-between;">
                <strong>Donderdag:</strong> <span>09:00 - 18:00</span>
            </li>
            <li style="display: flex; justify-content: space-between;">
                <strong>Vrijdag:</strong> <span>09:00 - 18:00</span>
            </li>
            <li style="display: flex; justify-content: space-between;">
                <strong>Zaterdag:</strong> <span>10:00 - 16:00</span>
            </li>
            <li style="display: flex; justify-content: space-between;">
                <strong>Zondag:</strong> <span>Gesloten</span>
            </li>
        </ul>
    </div>
</div>

{{-- Animations --}}
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .openingstijden-container h2 {
        animation: fadeIn 0.8s ease-in-out;
    }

    .openingstijden-left, .openingstijden-right {
        animation: fadeIn 1s ease-in-out;
    }
</style>
@endsection
