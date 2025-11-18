<h3>{{$organization->name}}</h3>
@if($organization->getRoleUser() == 'Admin')
    <a href="{{route('organization.give-role', $organization->id)}}">give role</a>
    <a href="{{route('organization.store-email', $organization->id)}}">store email</a>
    <a href="{{route('organization.create-session', $organization->id)}}">Create Session</a>
@endif
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam, eius assumenda? Nihil et, veniam, animi laborum cupiditate beatae aut corrupti accusamus quae enim maxime, saepe nostrum distinctio dolores qui harum?Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis eius vel molestiae officia voluptatum tempora ab dolorem, magnam eveniet ipsa, iusto quibusdam facere minima error quisquam doloribus sed fuga suscipit.</p>
@if($sesi)
    @if($organization->getRoleUser() == 'Admin')
    <form action="{{ route('organization.delete-session', $organization->id) }}">
        @csrf
        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
    </form>
    @endif

    @if(now()->lessThan($sesi->start_time))
        <p class="text-blue-500">Voting akan dibuka pada {{ $sesi->start_time->format('d M Y H:i') }}</p>
    @elseif(now()->greaterThan($sesi->end_time))
        <p class="text-red-500">Voting sudah berakhir ({{ $sesi->end_time->format('d M Y H:i') }})</p>
        <p>{{$winner->user->name}}</p>
    @else
        <p class="text-green-500">Voting sedang berlangsung (hingga {{ $sesi->end_time->format('d M Y H:i') }})</p>
        <form action="{{ route('organization.store-vote', $organization->id)}}" method="post">
            <input type="hidden" name="organization_id" value="{{ $organization->id }}">
            @foreach($organization->candidates as $candidate)
                @csrf
                <div style="display: flex;">
                    <p>{{ $candidate->user->name }}</p>
                    <input type="radio" name="candidate_id" value="{{ $candidate->user_id }}">
                </div>
            @endforeach
            @if(session('error'))
                <p>{{ session("error")}}</p>
            @elseif(session('success'))
                <p>{{session("success")}}</p>
            @endif
            <button type="submit">Vote</button>
        </form>
    @endif
@else
    <p style="color: red;">Gk ada Pemilihan</p>
@endif


