@extends('layouts.app')

@section('title', 'Contact Us')
@section('refrence')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection
@section('menu-title', 'Contact Information')

@section('content')
<div class="contact-page">
    <!-- Banner Section -->
    <div class="contact-banner">
        <h1>Neem Contact Op Met Ons!</h1>
    </div>

    <div class="contact-content">
        <!-- Left Section -->
        <div class="contact-info">
            <h2>Contact Gegevens</h2>
            <p><strong>Stonks Pizza</strong></p>
            <p>Straatnaam 123, 1234 AB Plaatsnaam, Nederland</p>
            <p>Email: <a href="mailto:info@bedrijf.nl">info@bedrijf.nl</a></p>
            <p>Telefoon: <a href="tel:+310123456789">+31 012 345 6789</a></p>

            <h2>Openingstijden</h2>
            <ul class="opening-hours">
                <li><strong>Maandag:</strong> 09:00 - 18:00</li>
                <li><strong>Dinsdag:</strong> 09:00 - 18:00</li>
                <li><strong>Woensdag:</strong> 09:00 - 18:00</li>
                <li><strong>Donderdag:</strong> 09:00 - 18:00</li>
                <li><strong>Vrijdag:</strong> 09:00 - 18:00</li>
                <li><strong>Zaterdag:</strong> 10:00 - 16:00</li>
                <li><strong>Zondag:</strong> Gesloten</li>
            </ul>
        </div>

        <!-- Right Section (Google Map) -->
        <div class="contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241317.1160995443!2d4.8979755!3d52.377956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c609c11d76e57b%3A0x82338be7b170fe6f!2sAmsterdam!5e0!3m2!1snl!2snl!4v1632403102938!5m2!1snl!2snl"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>
@endsection
