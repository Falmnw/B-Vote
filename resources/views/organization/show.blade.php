@extends('layout.master')

@section('content')
<p>{{$organization->deskripsi}}</p>
<main>
    <section class="csc-section">
        <div class="csc-container">
            <div class="logo-circle">
                @if($organization->logo)
                    <img src="{{ asset('storage/' . $organization->logo) }}" alt="">
                @endif
            </div>

            <div class="card-content">
                <h2 class="card-title">{{$organization->name}}</h2>
                <p class="card-text">{{$organization->deskripsi}}</p>
            </div>
        </div>
    </section>
    @if($sesi)
        <section class="kandidat-title">
            <div class="kandidat-section">
                <h2>Cari Tahu Kandidat</h2> 
            </div>
        </section>
        @if($organization->getRoleUser() == 'Admin' && $sesi)
        <form action="{{ route('organization.delete-session', $organization->id) }}" method="post">
            @csrf
            <button type="submit" >Delete</button>
        </form>
        @endif

        @if(now()->lessThan($sesi->start_time))
            <p >Voting akan dibuka pada {{ $sesi->start_time->format('d M Y H:i') }}</p>
        @elseif(now()->greaterThan($sesi->end_time))
            <p >Voting sudah berakhir ({{ $sesi->end_time->format('d M Y H:i') }})</p>
            <p>{{$winner->user->name}}</p>
        @else
            <p >Voting sedang berlangsung (hingga {{ $sesi->end_time->format('d M Y H:i') }})</p>
        <form action="{{ route('organization.store-vote', $organization->id)}}" method="post">
            @csrf
            
            @foreach($organization->candidates as $candidate)
                <section class="candidate-section">
                    <div class="candidate-card">
                        <div class="candidate-inner">
                            <div class="candidate-photo">
                                <img class="logo-circle" src="{{ asset('storage/' . $candidate->picture) }}" alt="Naruto Uzumaki">
                            </div>
                            <div class="candidate-info">
                                <h3 class="candidate-name">{{ $candidate->name ?? $candidate->user->name ?? 'N/A' }}</h3>
                                <p class="candidate-role">{{ $candidate->divisi }}</p>
                                <a href="{{ route('candidate.show', $candidate->id) }}" class="candidate-btn" style="text-decoration: none;">Cek Kandidat</a>
                            </div>
                            <div>
                                <input type="radio" name="candidate_id" value="{{ $candidate->id }}" id="candidate-{{ $candidate->id }}"style="margin-right: 15px; transform: scale(1.5);">
                            </div>
                        </div>
                    </div>
                </section>
            
            @endforeach
            <section class="voting-section">
                <button type="submit" class="voting-btn">Lakukan Voting!</button>
            </section>
        </form>
        @endif
    @else
        <p style="color: red;">Gk ada Pemilihan</p>
    @endif
    @if(session('error'))
        <p>{{ session("error")}}</p>
    @elseif(session('success'))
        <p>{{session("success")}}</p>
    @endif
</main>


@endsection

