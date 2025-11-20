<div>
    <img src="{{ asset('storage/' . $candidate->picture) }}" alt="Profile Photo" style="max-width: 200px; border-radius: 10px;">
    
    <p><strong>Nama:</strong> {{ $candidate->name ?? $candidate->user->name ?? 'N/A' }}</p> 
    <p><strong>Divisi:</strong> {{ $candidate->divisi }}</p>
    <p><strong>Visi:</strong> {{ $candidate->visi }}</p>
    <p><strong>Misi:</strong> {{ $candidate->misi }}</p>
    <p><strong>Proker:</strong> {{ $candidate->proker }}</p>
    <p><strong>Background:</strong> {{ $candidate->background }}</p>
</div>
@if(session('error'))
    <p>{{ session("error")}}</p>
@elseif(session('success'))
    <p>{{session("success")}}</p>
@endif