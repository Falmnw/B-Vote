<form action="/logout">
    @csrf
    <button type="submit">logout</button>
</form>
<p>Nama: {{$user->name}}</p>
<p>Email: {{$user->email}}</p>
@if(session('error'))
    <script>alert('{{session("error")}}')</script>
@endif



@foreach($user->organizations as $org)
    <div style="align-items:center;display:flex;">
        <a href="{{ route('organization.show', $org->id) }}">{{ $org->name }} </a><p>Role: {{ $org->pivot->role->name }}</p>
    </div>
@endforeach


<h3>=========================</h3>

<a href="{{ route('otherOrganization')}}">Other Organization</a>


