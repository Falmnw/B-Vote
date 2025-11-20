<?php
// ...existing code...
@extends('layout.master')

@section('title', 'Home')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/home-page.css') }}">

<header>
    <nav>
        <img src="{{ asset('resource/Logo B-Vote.png') }}" alt="B-Vote" id="bvote_logo">

        <!-- Wrapper tengah -->
        <div class="nav-center">
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/organization') }}">Organization</a>
        </div>

        <a href="{{ url('/login') }}" class="login">Log Out</a>
    </nav>
</header>

<main>
    <section class="hero">
        <div class="hero-content">
            <h1 id="main_banner">Your Voice Matters</h1>
            <p>Tercatat, Terjaga, Terjamin</p>
            <img src="{{ asset('resource/Background_Photo.png') }}" alt="Background">
        </div>
    </section>

    <!-- Laptop -->
    <section>
        <img src="{{ asset('resource/Group 102.png') }}" alt="Laptop" class="laptop">

        <div class="card-background">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A mollitia officiis magni magnam nemo ducimus!</p>
            <button><a href="#">Vote Now!</a></button>
        </div>
    </section>

    <section>
        <div class="temukan-rumpunmu">
            <h2>Temukan Rumpunmu</h2>
        </div>

        <div class="rumpun-grid">
            <div class="nama-rumpun">
                <li><a href="#">Rumpun Penalaran</a></li>
                <li><a href="#">Rumpun Sosial</a></li>
                <li><a href="#">Rumpun Seni</a></li>
                <li><a href="#">Rumpun Teknologi</a></li>
            </div>
            <img src="{{ asset('resource/Group 108.png') }}" alt="Rumpun" class="rumpun-image">
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-left">
        <span>© B-Vote</span>
    </div>

    <div class="footer-divider"></div>

    <div class="footer-right">
        <a href="#">Support</a>
        <a href="#">About Us</a>
    </div>
</footer>
@endsection
// ...existing code...
