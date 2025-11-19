<h3>daftar member</h3>

@foreach($organization->users as $user)
    <form action="{{ route('organization.give-role', $organization->id)}}" method="post" style="display:flex;align-items:center;">
        @csrf
        <p style="margin-right:10px;">{{ $user->name }} <br> Role: {{ $user->pivot->role->name }}</p>
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="organization_id" value="{{ $organization->id }}">
        
        <select name="role_id" required>   
            <option value="">Select Role</option>
            <option value="3">member</option>
            <option value="4">aktivis</option>
            <option value="5">pengurus</option>
            <option value="6">candidate</option>
        </select>
        
        <button type="submit">Apply</button>
    </form>
@endforeach
