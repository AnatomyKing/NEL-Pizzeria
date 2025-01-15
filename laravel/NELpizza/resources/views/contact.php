@extends('layouts.app')

@section('title', 'Contact Us')
@section('menu-title', 'Contact Us')

@section('content')
<div class="contact-container">
    <!-- Left Column: Address and Map -->
    <div class="contact-left">
        <h2>Contact Information</h2>
        <address>
            <strong>Stonks Pizza</strong><br>
            Straatnaam 123<br>
            1234 AB Plaatsnaam<br>
            Nederland<br><br>
            <a href="mailto:info@bedrijf.nl">info@bedrijf.nl</a><br>
            <a href="tel:+310123456789">+31 012 345 6789</a>
        </address>
        <div class="map-container">
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

    <!-- Right Column: Opening Hours -->
    <div class="contact-right">
        <h2>Opening Hours</h2>
        <ul>
            <li><strong>Monday:</strong> 09:00 - 18:00</li>
            <li><strong>Tuesday:</strong> 09:00 - 18:00</li>
            <li><strong>Wednesday:</strong> 09:00 - 18:00</li>
            <li><strong>Thursday:</strong> 09:00 - 18:00</li>
            <li><strong>Friday:</strong> 09:00 - 18:00</li>
            <li><strong>Saturday:</strong> 10:00 - 16:00</li>
            <li><strong>Sunday:</strong> Closed</li>
        </ul>
    </div>
</div>
@endsection
