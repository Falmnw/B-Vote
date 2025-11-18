<h2>Store Email To Organization</h2>

@if(session('error'))
    <p>{{ session('error') }}</p>
@endif

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<form action="{{ route('organization.store-email', $organization->id) }}" method="POST">
    @csrf
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    <input type="hidden" name="organization_id" value="{{ $organization->id }}" required>
    <button type="submit">Add</button>
</form>
