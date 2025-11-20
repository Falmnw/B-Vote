<h3>daftar member</h3>

<form action="{{ route('organization.give-role', $organization->id)}}" method="post" style="display:flex;align-items:center;">
    @csrf
    <input type="hidden" name="organization_id" value="{{ $organization->id }}">
    <select name="user_id" required>
        <option value="">-- Select Email --</option>
    @foreach($organization->users as $user)
        <!-- <p style="margin-right:10px;">{{ $user->name }} <br> Role: {{ $user->pivot->role->name }}</p> -->
        <option value="{{ $user->id }}">{{ $user->email }}</option>
        <!-- <input type="hidden" name="user_id" value="{{ $user->id }}"> -->
    @endforeach
    </select>
    <select name="role_id" required>
        <option value="">-- Select Role --</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select><br><br>
    <button type="submit">Apply</button>
</form>
