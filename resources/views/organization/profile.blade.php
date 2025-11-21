<form action="{{ route('organization.changeProfile', $organization->id)}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div>
        <label for="logo">Foto Baru:</label>
        <input type="file" name="logo" id="logo" accept="image/*" required>
    </div>

    @error('logo')
        <div style="color: red;">{{ $message }}</div>
    @enderror

    
    <input type="text" name="deskripsi">


    <button type="submit" style="margin-top: 10px;">Upload</button>
</form>
