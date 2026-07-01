<?php
namespace App\Console\Commands;
use App\Models\Consultation;
use Illuminate\Console\Command;

class ConsultationExpireCommand extends Command
{
    protected $signature   = 'babyspa:consultation-expire';
    protected $description = 'Auto-expire idle consultations after 24 hours';

    public function handle(): void
    {
        $expired = Consultation::whereIn('status', ['OPEN','CLAIMED'])
            ->where('last_activity_at', '<', now()->subHours(24))
            ->get();

        foreach ($expired as $c) {
            $c->update(['status' => 'EXPIRED', 'expired_at' => now()]);
        }
        $this->info("Expired {$expired->count()} consultations.");
    }
}
