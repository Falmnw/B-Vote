<h2>Assign Role to User</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if($errors->any())
    <ul style="color: red;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('changeUserRole') }}">
    @csrf

    {{-- Hidden organization ID (organisasi yang sedang aktif) --}}
    <input type="hidden" name="organization_id" value="{{ $organization->id }}">

    <label for="user_id">User:</label><br>
    <select name="user_id" id="user_id" required>
        <option value="">-- Pilih User --</option>
        @foreach($organization->users as $user)
            <option value="{{ $user->id }}">{{ $user->email }}</option>
        @endforeach
    </select>
    <select name="role_id" id="role_id" required>
        <option value="">-- Pilih Role --</option>
        @foreach($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
    </select><br><br>

    <button type="submit">Simpan</button>
</form>

