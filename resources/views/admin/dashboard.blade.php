<p>Nama: {{$user->name}}</p>
<p>Email: {{$user->email}}</p>
<p>Role: {{$user->role}}</p>

@if(Auth::user()->email === env('ADMIN_EMAIL'))
    <a href="{{ route('admin.storeEmail') }}">Masukkin Email ke Organisasi</a>
    <a href="{{ route('admin.viewOrganization') }}">Ubah Role User</a>
    
@endif
