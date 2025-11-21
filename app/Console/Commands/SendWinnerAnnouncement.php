<?php

namespace App\Console\Commands;

use App\Mail\WinnerAnnouncement;
use Illuminate\Console\Command;
use App\Models\Poll;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class SendWinnerAnnouncement extends Command
{
    protected $signature = 'app:send-winner-announcement-loop';
    protected $description = 'Sending email to all voters continuously every minute';

    public function handle()
    {
        //ni kalau manual
        $this->info('SendWinnerAnnouncement command started. Press CTRL+C to stop.');


        while (true) {
            $isAuto = Cache::get('auto_announcement', true);
            if (!$isAuto) {
                $this->info('Auto Announcement is OFF. Skipping this iteration.');
                sleep(30);
                continue;
            }
            Log::info('SendWinnerAnnouncement command running at '.now());

            $now = now();

    
            $polls = Poll::with('organization', 'candidates.user')
             ->where('end_time', '<=', $now)
             ->where('is_announced', false)
             ->get();


            foreach ($polls as $poll) {
                $organization = $poll->organization;

                $winnerVote = DB::table('candidates')
                        ->select('candidates.name', 'candidates.total')
                        ->where('organization_id', $organization->id)
                        ->orderByDesc('total')
                        ->first();

                if (!$winnerVote) continue;
                
                $winnerCandidate = $winnerVote->name;
                $winnerTotal = $winnerVote->total;

        
                $users = $organization->users; 

                foreach ($users as $user){
                    Mail::to($user->email)
                        ->send(new WinnerAnnouncement($winnerCandidate, $organization, $winnerTotal));
                    $this->info("Email queued for: {$user->email}");
                }
                $poll->update(['is_announced' => true]);

            }

            $this->info('Iteration finished at '.now());

            sleep(30);
        }
    }
}
