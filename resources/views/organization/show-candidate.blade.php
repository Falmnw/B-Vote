
@extends('layout.master')
@section('content')

{{-- HEADER CANDIDATE --}}
<div class="headers">
    {{-- Foto Kandidat --}}
    <img src="{{ asset('storage/' . $candidate->picture) }}" 
         class="foto_candidate" alt="Profile Photo">

    {{-- Nama Kandidat --}}
    <h1 class="nama_candidate">
        {{ $candidate->name ?? $candidate->user->name }}
    </h1>

    {{-- Logo Organisasi --}}
        <img src="{{ asset('assets/images/logo_csc.png') }}" class="logo_organisasi" style="max-width: 200px; border-radius: 100px;">
</div>

{{-- DIVISI / JABATAN --}}
<div class="jabatan">
    <h2>{{ $candidate->divisi }}</h2>
</div>


{{-- CARD VISI --}}
<div class="card">
    <div class="card-header">
        <img src="{{ asset('assets/images/goal.png') }}" class="icong">
        <span class="card-title">Visi</span>
    </div>

    <p id="hehe">{{ $candidate->visi }}</p>
</div>


{{-- CARD MISI --}}
<div class="card">
    <div class="card-header">
        <img src="{{ asset('assets/images/visi.png') }}" class="icong">
        <span class="card-title">Misi</span>
    </div>

    <ul>
        @foreach(explode("\n", $candidate->misi) as $m)
            <li>{{ $m }}</li>
        @endforeach
    </ul>
</div>


{{-- CARD PROKER --}}
<div class="card">
    <div class="card-header">
        <img src="{{ asset('assets/images/visi.png') }}" class="icong">
        <span class="card-title">Program Kerja</span>
    </div>

    <ul>
        @foreach(explode("\n", $candidate->proker) as $p)
            <li>{{ $p }}</li>
        @endforeach
    </ul>
</div>

@endsection
