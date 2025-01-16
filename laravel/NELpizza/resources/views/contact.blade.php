@extends('layouts.app')

@section('title', 'Contact Us')
@section('refrence')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection
@section('menu-title', 'Contact Information')

@section('content')
<div class="contact-container">
    <!-- Left Column: Address Information -->
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

        <h2>Opening Hours</h2>
        <ul class="opening-hours">
            <li><strong>Maandag:</strong> 09:00 - 18:00</li>
            <li><strong>Dinsdag:</strong> 09:00 - 18:00</li>
            <li><strong>Woensdag:</strong> 09:00 - 18:00</li>
            <li><strong>Donderdag:</strong> 09:00 - 18:00</li>
            <li><strong>vrijdag:</strong> 09:00 - 18:00</li>
            <li><strong>Zaterdag:</strong> 10:00 - 16:00</li>
            <li><strong>Zondag:</strong> Closed</li>
        </ul>
    </div>

    <!-- Right Column: Map -->
    <div class="contact-right">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241317.1160995443!2d4.8979755!3d52.377956!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c609c11d76e57b%3A0x82338be7b170fe6f!2sAmsterdam!5e0!3m2!1snl!2snl!4v1632403102938!5m2!1snl!2snl"
            allowfullscreen=""
            loading="lazy"
        ></iframe>
    </div>
</div>
@endsection
