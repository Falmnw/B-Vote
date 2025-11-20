<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('content')

<!-- CSS FE -->
<link rel="stylesheet" href="{{ asset('css/adminOK.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap">

<header>
    <nav>
        <img src="{{ asset('images/Logo B-Vote.png') }}" id="bvote_logo">

        <div class="nav-center">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('organization') }}">Organization</a>
        </div>

        <a href="{{ route('logout') }}" class="login">Logout</a>
        <a href="#" class="signup">Dashboard</a>
    </nav>
</header>

<main class="dashboard-main">

    <!-- ========================== -->
    <!-- ADMIN PROFILE SECTION -->
    <!-- ========================== -->
    <section class="admin-profile">
        <div class="profile-card">

            <!-- FOTO PROFIL -->
            <div class="profile-avatar" id="profileAvatar">
                <img id="avatarImage"
                     src="{{ asset('images/default-avatar.png') }}"
                     alt="Profile">
            </div>

            <div class="profile-info">
                <div class="profile-name-row">
                    <h2 id="profileName">{{ $user->name }}</h2>
                    <button id="editProfileBtn" class="btn-edit">Edit Profile</button>
                </div>

                <p id="profileTagline" class="profile-tagline">
                    {{ $user->tagline ?? 'Tambahkan tagline singkat Anda di sini.' }}
                </p>
            </div>

        </div>

        <!-- FORM EDIT PROFILE -->
        <form id="profileForm" class="profile-form hidden">
            <div class="form-row">
                <label for="avatarInput">Upload Foto Profil</label>
                <input type="file" id="avatarInput" accept="image/*">
            </div>

            <div class="form-row">
                <label for="taglineInput">Tagline</label>
                <input type="text" id="taglineInput" value="{{ $user->tagline }}">
            </div>

            <div class="form-actions">
                <button type="button" id="saveProfileBtn" class="btn-primary">Simpan</button>
                <button type="button" id="cancelEditBtn" class="btn-secondary">Batal</button>
            </div>
        </form>


        <!-- ========================== -->
        <!-- ADMIN TABS SECTION -->
        <!-- ========================== -->
        <section class="admin-tabs-section">

            <div class="admin-tabs">
                <button class="admin-tab active" data-target="tab-give-role">Give Role</button>
                <button class="admin-tab" data-target="tab-store-email">Store Email</button>
                <button class="admin-tab" data-target="tab-choose-candidate">Choose Candidate</button>
                <button class="admin-tab" data-target="tab-create-session">Create Session</button>
            </div>

            <div class="admin-tab-panels">

                <!-- TAB 1: GIVE ROLE -->
                <div class="admin-tab-panel active" id="tab-give-role">
                    <h3>Give Role</h3>
                    <p>Pilih user dan tentukan role baru untuk mereka.</p>

                    <form class="admin-simple-form">
                        <label for="giveRoleEmail">Email User</label>
                        <select id="giveRoleEmail">
                            <option value="">Pilih email...</option>
                            @foreach($allUsers as $u)
                                <option value="{{ $u->email }}">{{ $u->email }}</option>
                            @endforeach
                        </select>

                        <label for="giveRoleSelect">Role Baru</label>
                        <select id="giveRoleSelect">
                            <option value="user">User</option>
                            <option value="committee">Committee</option>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Super Admin</option>
                        </select>

                        <button type="button" class="btn-primary">Assign Role</button>
                    </form>
                </div>


                <!-- TAB 2: STORE EMAIL -->
                <div class="admin-tab-panel" id="tab-store-email">
                    <h3>Store Email</h3>
                    <p>Simpan email yang akan diundang ke dalam sistem.</p>

                    <form class="admin-simple-form" id="emailForm">
                        <label for="emailInput">Email User</label>
                        <input type="email" id="emailInput" placeholder="masukkan email user..." required>
                        <button type="submit" class="btn-primary">Tambah Email</button>
                        <small id="emailStatus" class="form-note"></small>
                    </form>
                </div>


                <!-- TAB 3: CHOOSE CANDIDATE -->
                <div class="admin-tab-panel" id="tab-choose-candidate">
                    <h3>Choose Candidate</h3>
                    <p>Pilih kandidat yang akan diikutsertakan dalam sesi voting.</p>

                    <form class="admin-simple-form" id="candidateForm">
                        <label for="candidatePhoto">Foto Kandidat</label>
                        <input type="file" id="candidatePhoto" accept="image/*">

                        <label for="candidateEmail">Email User</label>
                        <select id="candidateEmail">
                            <option value="">Pilih email...</option>
                            @foreach($allUsers as $u)
                                <option value="{{ $u->email }}">{{ $u->email }}</option>
                            @endforeach
                        </select>

                        <label for="candidateFullName">Nama Lengkap</label>
                        <input type="text" id="candidateFullName" placeholder="misal: Naruto Uzumaki">

                        <label for="candidateDivision">Divisi</label>
                        <input type="text" id="candidateDivision" placeholder="misal: Media and Publication">

                        <label for="candidateVision">Visi</label>
                        <textarea id="candidateVision" class="large-text"></textarea>

                        <label for="candidateMission">Misi</label>
                        <textarea id="candidateMission" class="large-text"></textarea>

                        <label for="candidatePrograms">Program Kerja</label>
                        <textarea id="candidatePrograms" class="large-text"></textarea>

                        <button type="button" class="btn-primary">Tambah Kandidat</button>
                    </form>
                </div>


                <!-- TAB 4: CREATE SESSION -->
                <div class="admin-tab-panel" id="tab-create-session">
                    <h3>Create Session</h3>
                    <p>Buat sesi voting baru.</p>

                    <form class="admin-simple-form">
                        <label for="sessionName">Nama Sesi</label>
                        <input type="text" id="sessionName" placeholder="misal: Pemilihan Ketua CSC 2025">

                        <label for="sessionStart">Tanggal Mulai</label>
                        <input type="date" id="sessionStart">

                        <label for="sessionEnd">Tanggal Selesai</label>
                        <input type="date" id="sessionEnd">

                        <button type="button" class="btn-primary">Buat Sesi</button>
                    </form>
                </div>

            </div>
        </section>

    </section>
</main>

<footer class="footer">
    <div class="footer-left"><span>© B-Vote</span></div>
    <div class="footer-divider"></div>
    <div class="footer-right">
        <a href="#">Support</a>
        <a href="#">About Us</a>
    </div>
</footer>


@endsection

@section('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
<script src="{{ asset('js/adminOK.js') }}"></script>
@endsection
