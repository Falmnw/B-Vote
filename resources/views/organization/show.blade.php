@extends('layout.master')

@section('content')

<main>

    {{-- ORGANIZATION HEADER --}}
    <section class="csc-section">
        <div class="csc-container">

            <div class="profile-avatar" id="profileAvatar">
                @if($organization->logo)
                    <img id="avatarImage" src="{{ asset('storage/' . $organization->logo) }}" alt="">
                @endif
            </div>

            <div class="card-content">
                <div class="card-header">
                    <h2 class="card-titles">{{ $organization->name }}</h2>

                    {{-- DASHBOARD BUTTON --}}
                    @if($organization->getRoleUser() === 'Admin')
                    <a href="{{ route('admin-feature', $organization->id) }}" class="dashboard-btn">
                        Dashboard
                    </a>
                    @endif
                </div>

                <p class="card-text">
                    {{ $organization->deskripsi }}
                </p>
            </div>

        </div>
    </section>
    {{-- JIKA ADA SESI PEMILIHAN --}}
    @if($sesi)
        
        {{-- COUNTDOWN (selama voting berlangsung) --}}
        @if(now()->between($sesi->start_time, $sesi->end_time))
        <section class="countdown-section">
            <div class="countdown-card">

                
                <div class="countdown-header">
                    <span class="countdown-badge">Sedang Berlangsung</span>
                    <p class="countdown-title">Sisa Waktu Pemilihan</p>
                </div>

                <div class="countdown-timer">
                    <div class="time-box">
                        <span class="time-value" id="cd-days">00</span>
                        <span class="time-label">Hari</span>
                    </div>
                    <div class="time-box">
                        <span class="time-value" id="cd-hours">00</span>
                        <span class="time-label">Jam</span>
                    </div>
                    <div class="time-box">
                        <span class="time-value" id="cd-minutes">00</span>
                        <span class="time-label">Menit</span>
                    </div>
                    <div class="time-box">
                        <span class="time-value" id="cd-seconds">00</span>
                        <span class="time-label">Detik</span>
                    </div>
                </div>

                <p class="countdown-endtime">
                    Berakhir pada:
                    <span id="cd-enddate">{{ $sesi->end_time->format('d M Y H:i') }}</span>
                </p>
            </div>
        </section>
        @endif

        {{-- JUDUL KANDIDAT --}}
        <section class="kandidat-title">
            <div class="kandidat-section">
                <h2>Cari Tahu Kandidat</h2>
            </div>
        </section>


        {{-- FORM VOTING --}}
        @if(now()->lessThan($sesi->start_time))
            <p style="text-align:center;">Voting akan dibuka pada {{ $sesi->start_time->format('d M Y H:i') }}</p>
        
        @elseif(now()->greaterThan($sesi->end_time))
            <p style="text-align:center;">Voting sudah berakhir.</p>
            <p style="text-align:center; font-size:20px; font-weight:600;">
                Pemenang: {{ $winner->user->name }}
            </p>

        @else
        {{-- VOTING SEDANG BERLANGSUNG --}}
        <form action="{{ route('organization.store-vote', $organization->id) }}" method="post">
            @csrf

            @foreach($organization->candidates as $candidate)
            <section class="candidate-section">
                <div class="candidate-card">
                    <div class="candidate-inner">

                        <div class="profile-avatar" id="profileAvatar">
                            <img id="avatarImage" src="{{ asset('storage/' . $candidate->picture) }}" alt="">
                        </div>

                        <div class="candidate-info">
                            <h3 class="candidate-name">{{ $candidate->name ?? $candidate->user->name }}</h3>
                            <p class="candidate-role">{{ $candidate->divisi }}</p>

                            <a href="{{ route('candidate.show', $candidate->id) }}" 
                               class="candidate-btn" style="text-decoration:none;">
                                Cek Kandidat
                            </a>
                        </div>

                        <div class="candidate-select">
                            <input type="radio" 
                                   name="candidate_id" 
                                   value="{{ $candidate->id }}" 
                                   id="candidate-{{ $candidate->id }}">
                            <label for="candidate-{{ $candidate->id }}"></label>
                        </div>

                    </div>
                </div>
            </section>
            @endforeach

            {{-- TOMBOL VOTING --}}
            <section class="voting-section">
                <button type="submit" class="voting-btn">Lakukan Voting!</button>
            </section>

        </form>
        @endif
    @else
        <section class="countdown-section">
            <div class="countdown-card">

                
                <div class="countdown-header">
                    <span class="countdown-badge">Tidak Ada Pemilihan</span>
                    <p class="countdown-title">Sisa Waktu Pemilihan</p>
                </div>

                <div class="countdown-timer">
                    <div class="time-box">
                        <span class="time-value" id="cd-days">00</span>
                        <span class="time-label">Hari</span>
                    </div>
                    <div class="time-box">
                        <span class="time-value" id="cd-hours">00</span>
                        <span class="time-label">Jam</span>
                    </div>
                    <div class="time-box">
                        <span class="time-value" id="cd-minutes">00</span>
                        <span class="time-label">Menit</span>
                    </div>
                    <div class="time-box">
                        <span class="time-value" id="cd-seconds">00</span>
                        <span class="time-label">Detik</span>
                    </div>
                </div>
            </div>
        </section>
    @endif


    {{-- FLASH MESSAGE --}}
    @if(session('error'))
        <p style="color:red; text-align:center;">{{ session('error') }}</p>
    @elseif(session('success'))
        <p style="color:green; text-align:center;">{{ session('success') }}</p>
    @endif

</main>
<script src="{{ asset('assets/js/countdown.js') }}"></script>
@endsection
