@extends('layouts.app')

@section('content')
<div class="openingstijden-container" style="display: flex; flex-wrap: wrap; gap: 20px;">
    <!-- Linkerkolom: Adres en Kaart -->
    <div class="openingstijden-left" style="flex: 1; min-width: 300px;">
        <h2>Contactgegevens</h2>
        <address>
            <strong>Bedrijfsnaam</strong><br>
            Straatnaam 123<br>
            1234 AB Plaatsnaam<br>
            Nederland<br><br>
            <a href="mailto:info@bedrijf.nl">info@bedrijf.nl</a><br>
            <a href="tel:+310123456789">+31 012 345 6789</a>
        </address>
        <div class="map-container" style="margin-top: 20px;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241317.1160995443!2d4.8979755!3d52.377956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c609c11d76e57b%3A0x82338be7b170fe6f!2sAmsterdam!5e0!3m2!1snl!2snl!4v1632403102938!5m2!1snl!2snl"
                width="100%"
                height="250"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>

    <!-- Rechterkolom: Openingstijden -->
    <div class="openingstijden-right" style="flex: 1; min-width: 300px; max-height: 100vh; overflow-y: auto;">
        <h2>Openingstijden</h2>
        <ul style="padding: 0; list-style-type: none; line-height: 1.8;">
            <li><strong>Maandag:</strong> 09:00 - 18:00</li>
            <li><strong>Dinsdag:</strong> 09:00 - 18:00</li>
            <li><strong>Woensdag:</strong> 09:00 - 18:00</li>
            <li><strong>Donderdag:</strong> 09:00 - 18:00</li>
            <li><strong>Vrijdag:</strong> 09:00 - 18:00</li>
            <li><strong>Zaterdag:</strong> 10:00 - 16:00</li>
            <li><strong>Zondag:</strong> Gesloten</li>
        </ul>
    </div>
</div>
@endsection
