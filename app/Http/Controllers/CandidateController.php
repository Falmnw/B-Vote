<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\Poll;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    private function checkUser($id){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $roleName = OrganizationUser::where('organization_id', $id)->where('user_id', $user->id)->first();
        if (!$roleName) {
            abort(403, 'Unauthorized access');
        } 
        return true;
    }
    private function checkAdmin($id){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $roleName = OrganizationUser::where('organization_id', $id)->where('user_id', $user->id)->first()->getRoleUser();
        if ($roleName !== 'Admin') {
            abort(403, 'Unauthorized access');
        } 
        return true;
    }
    public function createSession($id){
        
        $organization = Organization::findOrFail($id);
        return view('organization.create-session', compact('organization'));
    }
    
    public function storeSession(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $activePoll = Poll::where('organization_id', $id)->where('end_time', '>=', now())->first();
        
        if ($activePoll) {
            return redirect()->back()->withInput()->with('error', 'Organisasi ini sudah memiliki sesi voting yang sedang berlangsung dan berakhir pada tanggal ' . $activePoll->end_time->format('d M Y H:i'));
        }
        $session = Poll::create([
            'organization_id' => $id,
            'title' => $validate['title'],
            'start_time' => $validate['start_time'],
            'end_time' => $validate['end_time'],
        ]);
        $candidates = Candidate::where('organization_id', $id)->get();
        foreach ($candidates as $candidate) {
            $candidate->poll_id = $session->id;
            $candidate->save();
        }

        return back()->with('success', 'Voting berhasil dibuat.');
    }

    public function deleteSession($id){
        $this->checkAdmin($id);
        $sesi =Poll::where('organization_id', $id)->first();
        $candidate =Candidate::where('organization_id', $id);
        $vote =Vote::where('poll_id', $sesi->id);
        $sesi->delete();
        $candidate->delete();
        $vote->delete();
         return redirect()->route('organization.show', ['id' => $id])->with('success', 'Delete Berhasil');
    }
    public function showSession($id){
        $sesi = Poll::where('organization_id', $id)->first();
        $organization = Organization::with('candidates')->findOrFail($id);
        $user = Auth::user();
        $winner = $organization->candidates()->orderByDesc('total')->first();
        return view('organization.show-session', compact('sesi', 'organization','user', 'winner'));
    }
    public function show($id){
        $this->checkAdmin($id);
        $organization = Organization::findOrFail($id);
        return view('organization.store-candidate', compact('organization'));
    }

    public function storeCandidate(Request $request, $id){
        $this->checkAdmin($id);
        $organization = Organization::findOrFail($id);
        $validatedData = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:candidates,email'], 
            'divisi' => ['required', 'string'],
            'visi' => ['required', 'string'],
            'misi' => ['required', 'string'],
            'proker' => ['required', 'string'],
            'background' => ['required', 'string'],
            'picture' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);
        $user = User::where('email', $validatedData['email'])->first();
        if(!$user){
            abort(403, 'User is not part of this organization.');
        }
        $path = $request->file('picture')->store('candidates/pictures', 'public');
        if (!$organization->users()->where('id', $user->id)->exists()) {
            abort(403, 'User is not part of this organization.');
        }

        try {
            $candidate = new Candidate();
            $candidate->organization_id = $organization->id; 
            $candidate->user_id = $user->id; 
            $candidate->name = $validatedData['username'];
            $candidate->email = $validatedData['email'];
            $candidate->divisi = $validatedData['divisi'];
            $candidate->visi = $validatedData['visi'];
            $candidate->misi = $validatedData['misi'];
            $candidate->proker = $validatedData['proker'];
            $candidate->background = $validatedData['background'];
            $candidate->picture = $path; 

            $candidate->save();

            
            return redirect()->route('organization.show', $organization->id)
                             ->with('success', 'Kandidat baru berhasil ditambahkan!');

        }catch (\Exception $e) {
            
            if (isset($path)) {
                Storage::disk('public')->delete($path);
                
            }
        return back()->withInput()->with('error', 'Gagal menambahkan kandidat: ' . $e->getMessage());
        }
    }
    public function detail($candidateId){
        $candidate = Candidate::where('id', $candidateId)->first();
        return view('organization.show-candidate', compact('candidate'));
    }

    public function storeVote(Request $request, $organizationId){
        
        $request->validate([
            'candidate_id' => 'required|numeric|exists:candidates,id' 
        ]);
        
        $user = Auth::user();
        $candidate_user_id = $request->input('candidate_id'); 
    
        $this->checkUser($organizationId); 

        $activePoll = Poll::where('organization_id', $organizationId)->where('start_time', '<=', now())->where('end_time', '>=', now())->latest()->first();

        
        if (!$activePoll) {
            return redirect()->route('organization.show', ['id' => $organizationId])->with('error', 'Saat ini tidak ada sesi voting yang berlangsung.');
        }
        
        $exists = Vote::where('user_id', $user->id)
                    ->where('poll_id', $activePoll->id) 
                    ->exists();

        if ($exists) {
            return redirect()->route('organization.show', ['id' => $organizationId])->with('error', 'Anda Sudah Vote');
        }
        
        
        $candidate = Candidate::where('id', $candidate_user_id)
                            ->where('organization_id', $organizationId)
                            ->first();
        
        if (!$candidate) {
            return redirect()->route('organization.show', ['id' => $organizationId])->with('error', 'Kandidat yang dipilih tidak valid.');
        }
        
        Vote::create([
            'user_id' => $user->id,
            'poll_id' => $activePoll->id, 
        ]);
        
        
        $candidate->total += 1;
        $candidate->save();
        
        return redirect()->route('organization.show', ['id' => $organizationId])->with('success', 'Berhasil Vote');
    }
}