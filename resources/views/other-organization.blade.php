


@extends('layout.master')

@section('content')
@if(session('error'))
    <script>alert('{{session("error")}}')</script>
@endif

<?php $i = 1 ?>
@foreach($organizations as $org)
    @if(!$user->organizations->contains($org->id))
        <div class="group-header">
            <h2>Your Organization</h2>
        </div>
        <div class="group">
            <div class="left">
                <div class="profile-avatar" id="profileAvatar">
                    <img id="avatarImage" src="{{ asset('storage/' . $org->logo) }}" alt="">
                </div>
            </div>

            <div class="right">
                <div class="group-name">
                    <h2><a href="{{route('organization.show', $org->id)}}" style="text-decoration: none;">{{$org->name}}</a></h2>
                </div>

                <div class="group-description">
                    <p>{{ $org->deskripsi}}</p>
                </div>
                @php
                    $poll = $org->polls->where('start_time', '<=', now())->where('end_time', '>=', now())->first();
                @endphp
                <div class="group-session">
                    @if($poll && now()->between($poll->start_time, $poll->end_time))
                    <h3><span style="color:red;">Voting session:</span> <span style="color:black;">{{$poll->start_time->format('d M Y H:i')}} - {{$poll->end_time->format('d M Y H:i')}}</span></h3>`
                    @else
                        <h3><span style="color:red;">No voting session</span></h3>`
                    @endif
                    </div>
            </div>
        </div>
        <?php $i++ ?>
    @endif
@endforeach
<div class="bottom-bar">
    <a href="{{ route('home')}}" button class="bottom-button">
        Your Groups!
    </a>
</div>
@endsection


