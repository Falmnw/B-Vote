<h3>Select Candidate</h3>
@if(session('error'))
    <p>{{session('error')}}</p>
@endif
<form action="{{ route('organization.store-candidate', $organization->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <div>
        <input type="text" name="username" placeholder="username" required><br>
        <input type="email" name="email" placeholder="email" required><br>
        <input type="text" name="divisi" placeholder="divisi" required><br>
        <input type="text" name="visi" placeholder="visi" required><br>
        <input type="text" name="misi" placeholder="misi" required><br>
        <input type="text" name="proker" placeholder="proker" required><br>
        <input type="text" name="background" placeholder="background" required><br>
        <input type="file" name="picture" accept="image/*" placeholder="picture" required><br>
        <button type="submit">Add</button>
    </div>
</form>
