@extends('layout.master')

@section('content')
    <main class="dashboard-main">

        <section class="admin-profile">
            <div class="profile-card">
                <div class="profile-avatar" id="profileAvatar">
                    <img id="avatarImage" src="{{ asset('storage/' . $organization->logo) }}" alt="">
                </div>
                <div class="profile-info">
                    <div class="profile-name-row">
                        <h2 id="profileName">{{$organization->name}}</h2>
                        <button id="editProfileBtn" class="btn-edit">Edit Profile</button>
                    </div>
                    <p id="profileTagline" class="profile-tagline"> </p>
                </div>
            </div>

            <form action="{{ route('organization.changeProfile', $organization->id)}}" method="POST" enctype="multipart/form-data" id="profileForm" class="profile-form hidden">
            @csrf    
                <div class="form-row">
                    <label for="avatarInput">Upload Foto Profil</label>
                    <input type="file" name="logo" id="avatarInput"  accept="image/*" required>
                </div>
                @error('logo')
                    <div style="color: red;">{{ $message }}</div>
                @enderror
                <div class="form-row">
                    <label for="taglineInput">Tagline</label>
                    <input type="text" id="taglineInput" name="deskripsi"required>
                </div>

                <div class="form-actions">
                    <button type="submit" id="saveProfileBtn" class="btn-primary">Simpan</button>
                    <button type="button" id="cancelEditBtn" class="btn-secondary">Batal</button>
                </div>
            </form>

            <section class="admin-tabs-section">
                <div class="admin-tabs">
                <button class="admin-tab active" data-target="tab-give-role">
                    Give Role
                </button>
                <button class="admin-tab" data-target="tab-store-email">
                    Store Email
                </button>
                <button class="admin-tab" data-target="tab-choose-candidate">
                    Choose Candidate
                </button>
                <button class="admin-tab" data-target="tab-create-session">
                    Create Session
                </button>
                </div>

                <div class="admin-tab-panels">
                @if(session('error'))
                    <p>{{session('error')}}</p>
                @endif
                @if(session('success'))
                    <p>{{session('success')}}</p>
                @endif
                <!-- PANEL: Give Role -->
                <div class="admin-tab-panel active" id="tab-give-role">
                <h3>Give Role</h3>
                <p>Pilih user dan tentukan role baru untuk mereka.</p>
                <form class="admin-simple-form" action="{{ route('organization.give-roles', $organization->id)}}" method="post">
                @csrf    
                <label for="giveRoleEmail">Email User</label>
                    <select id="giveRoleEmail" name="user_id">
                        <option value="">Pilih email...</option>
                        @foreach($organization->users as $user)
                            <!-- <p style="margin-right:10px;">{{ $user->name }} <br> Role: {{ $user->pivot->role->name }}</p> -->
                            <option value="{{ $user->id }}">{{ $user->email }}</option>
                            <!-- <input type="hidden" name="user_id" value="{{ $user->id }}"> -->
                        @endforeach
                    </select>

                    <label for="giveRoleSelect">Role Baru</label>
                    <select id="giveRoleSelect" name="role_id">
                        <option value="">-- Select Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn-primary">Assign Role</button>
                </form>
                </div>

                <!-- PANEL: Store Email -->
                <div class="admin-tab-panel" id="tab-store-email">
                    <h3>Store Email</h3>
                    <p>Simpan email yang akan diundang ke dalam sistem.</p>

                    <form action="{{ route('organization.store-email', $organization->id) }}" method="POST" class="admin-simple-form" id="emailForm">
                        @csrf
                        <input type="hidden" name="organization_id" value="{{ $organization->id }}" required>
                        <label for="emailInput">Email User</label>
                        <input type="email" id="emailInput" placeholder="masukkan email user..." name="email" required>
                        <button type="submit" class="btn-primary">Add</button>
                    </form>
                </div>

                <!-- PANEL: Choose Candidate -->
                <div class="admin-tab-panel" id="tab-choose-candidate">
                    <h3>Choose Candidate</h3>
                    <p>Pilih kandidat yang akan diikutsertakan dalam sesi voting.</p>
                    <form action="{{ route('organization.store-candidate', $organization->id)}}" method="post" enctype="multipart/form-data" class="admin-simple-form" id="candidateForm">
                        @csrf
                        <label for="candidatePhoto">Foto Kandidat</label>
                        <input type="file" id="candidatePhoto" name="picture" accept="image/jpg, image/jpeg, image/png" placeholder="picture" required>
                        <label for="giveRoleEmail">Email User</label>
                        <select name="email" id="candidateEmailSelect"> 
                            <option value="">Pilih email...</option>
                            @foreach($organization->users as $user)
                                <option value="{{ $user->email }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                        <label for="candidateFullName">Nama Lengkap</label>
                        <input type="text" name="username" id="candidateFullName" placeholder="username">
                        <label for="candidateDivision">Divisi</label>
                        <input type="text" name="divisi" id="candidateDivision" placeholder="divisi" required>
                        <label for="candidateVision">Visi</label>
                        <textarea class="large-text" type="text" name="visi" id="candidateVision" placeholder="visi" required></textarea>
                        <label for="candidateMission">Misi</label>
                        <textarea class="large-text" type="text" name="misi" id="candidateMission"  placeholder="misi" required></textarea>
                        <label for="candidatePrograms">Program Kerja</label>
                        <textarea class="large-text" type="text" name="proker" id="candidatePrograms" placeholder="proker" required></textarea>
                        <button type="submit" class="btn-primary">Tambah Kandidat</button>
                    </form>
                </div>

                <div class="admin-tab-panel" id="tab-create-session">
                    <h3>Create Session</h3>
                    <p>Buat sesi voting baru.</p>
                    <form class="admin-simple-form" id="sessionForm"action="{{ route('organization.create-session', $organization->id) }}"method="POST">
                        @csrf
                        <label for="sessionName">Judul Voting</label>
                        <input type="text" id="sessionName" name="title" placeholder="Example: Pemilihan Ketua CSC 2025" required>

                         <label for="sessionStart">Waktu Mulai</label>
                        <input id="sessionStart" type="datetime-local" name="start_time"  required>

                        <label for="sessionEnd">Waktu Selesai</label>
                        <input type="datetime-local" name="end_time" id="sessionEnd" required>   

                        <button type="submit" class="btn-primary">Buat Voting</button>
                    </form>
                    </div>

                </div>
            </section>

        </section>
    </main>
<script src="{{ asset('assets/js/adminOK.js') }}"></script>
@endsection