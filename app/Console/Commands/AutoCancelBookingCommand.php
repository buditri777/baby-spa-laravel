<?php
namespace App\Console\Commands;
use App\Models\Booking;
use Illuminate\Console\Command;

class AutoCancelBookingCommand extends Command
{
    protected $signature   = 'babyspa:auto-cancel';
    protected $description = 'Auto-cancel REQUESTED bookings older than 24h';

    public function handle(): void
    {
        $cancelled = Booking::where('status', 'REQUESTED')
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => 'CANCELLED', 'cancel_reason' => 'Auto-cancelled: no confirmation']);
        $this->info("Cancelled {$cancelled} bookings.");
    }
}
