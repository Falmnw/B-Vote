<h2>Store Email To Organization</h2>

@if(session('error'))
    <p>{{ session('error') }}</p>
@endif

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="/adminStoreEmail" method="POST">
    @csrf
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    <label for="organization_id">Organization:</label><br>
    <select id="organization_id" name="organization_id" required>
        <option value="">-- Choose Organization --</option>
        @foreach($organizations as $organization)
            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
        @endforeach
    </select><br><br>

    <button type="submit">Add</button>
</form>
