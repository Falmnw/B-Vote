<h3>{{$organization->name}}</h3>
@if($organization->logo)
    <img src="{{ asset('storage/' . $organization->logo) }}" 
         alt="Profile Photo" 
         style="max-width: 200px; border-radius: 10px;">
@endif
<br>
@if($organization->getRoleUser() == 'Admin')
    <a href="{{ route('organization.profile', $organization->id) }}">Ubah Profil Organisasi</a>
    <a href="{{route('organization.give-role', $organization->id)}}">give role</a>
    <a href="{{route('organization.store-email', $organization->id)}}">store email</a>
    <a href="{{route('organization.store-candidate', $organization->id)}}">Select Candidate</a>
    <a href="{{route('organization.create-session', $organization->id)}}">Create Session</a>
@endif
<p>{{$organization->deskripsi}}</p>
@if($sesi)
    @if($organization->getRoleUser() == 'Admin')
    <form action="{{ route('organization.delete-session', $organization->id) }}" method="post">
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
        @csrf
        
        <h3>Pilih Satu Kandidat:</h3>
        
        @foreach($organization->candidates as $candidate)
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; display: flex; align-items: center;">
                
                <input 
                    type="radio" 
                    name="candidate_id" 
                    value="{{ $candidate->id }}" 
                    id="candidate-{{ $candidate->id }}"
                    style="margin-right: 15px; transform: scale(1.5);">
                
                <div style="flex-grow: 1;">
                    <label for="candidate-{{ $candidate->id }}">
                        <img src="{{ asset('storage/' . $candidate->picture) }}" alt="Profile Photo" style="max-width: 100px; border-radius: 5px;">
                        
                        <p><strong>Nama:</strong> {{ $candidate->name ?? $candidate->user->name ?? 'N/A' }}</p> 
                        <p><strong>Divisi:</strong> {{ $candidate->divisi }}</p>
                    </label>
                    
                    <a href="{{ route('candidate.show', $candidate->id) }}" class="bg-gray-400 text-black px-3 py-1 rounded mt-1 text-sm inline-block">
                        Cek Detail
                    </a>
                </div>
                
            </div>
        @endforeach

        <hr>
        
        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded mt-4">
            SUBMIT VOTE
        </button>
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

