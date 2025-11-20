@if(Auth::user()->email === env('ADMIN_EMAIL'))
@extends('layout.master')
@section('content')
    <section class="admin-tabs-section">
        <div class="admin-tabs">
            <button class="admin-tab active" data-target="tab-email">
            Masukan Email
            </button>
            <button class="admin-tab" data-target="tab-role">
            Ubah Role User
            </button>
        </div>

        <div class="admin-tab-panels">
            <!-- PANEL: Masukan Email -->
            <div class="admin-tab-panel active" id="tab-email">
                <h3>Masukan Email</h3>
                <p>Di sini nanti form untuk memasukkan email user (misalnya untuk kirim undangan voting, dsb).</p>
                <form action="/adminStoreEmail" method="POST" class="admin-simple-form" id="emailForm">
                    @csrf
                    <label for="emailInput">Email User</label>
                    <input type="email" name="email" id="emailInput" placeholder="masukkan email user..." required>
                    <label for="orgSelect">Organisasi</label>
                    <select id="orgSelect" name="organization_id" required>
                        <option value="">-- Choose Organization --</option>
                        @foreach($organizations as $organization)
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                    @if(session('error'))
                        <p style="color: red;">{{ session('error') }}</p>
                    @endif

                    @if(session('success'))
                        <p style="color: green;">{{ session('success') }}</p>
                    @endif
                    <button type="submit" class="btn-primary">Tambah Email</button>
                    <small id="emailStatus" class="form-note"></small>
                </form>

            </div>
            <div class="admin-tab-panel" id="tab-role">
                <h3>Ubah Role User</h3>
                <p>Di sini nanti form untuk mengubah role user (misal: user → admin, viewer, dsb).</p>
                <form method="POST" action="{{ route('changeUserRole') }}" class="admin-simple-form" id="roleForm"> 
                    @csrf
                    {{-- Hidden organization ID (organisasi yang sedang aktif) --}}
                    <label for="orgSelect">Organisasi</label>
                    <select id="orgSelect" name="organization_id" required>
                        <option value="">-- Choose Organization --</option>
                        @foreach($organizations as $organization)
                            
                            <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                        @endforeach
                    </select>
                    <label for="roleEmailSelect">Pilih Email User</label>
                    <select name="user_id" id="roleEmailSelect" required>
                        <option value="">-- Pilih User --</option>
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                    </select>
                    <label for="roleSelect">Role Baru</label>
                    <select name="role_id" id="roleSelect" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select><br><br>
                    @if(session('error'))
                        <p>{{ session('error') }}</p>
                    @endif

                    @if(session('success'))
                        <p>{{ session('success') }}</p>
                    @endif
                    <button type="submit" class="btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </section>
    <script src="{{ asset('assets/js/profile.js') }}"></script>
@endsection
@endif
