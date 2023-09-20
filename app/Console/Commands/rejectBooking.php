<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RinkBooking;
use App\Models\User;
use App\Notifications\BookingRejected;

class rejectBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reject:booking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reject booking request if not accepted within 24 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        \Log::info('cron working');

        $bookings = RinkBooking::where('created_at','<=',date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') .' -24 hours')))
                    ->whereStatus('Pending')->get();

        foreach ($bookings as $booking) {
            $user = User::find($booking->user_id);
            $user->notify(new BookingRejected($booking));
        }
        
        RinkBooking::where('created_at','<=',date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') .' -24 hours')))
                    ->whereStatus('Pending')->update(['status'=>'Rejected']);

        return 0;
    }
}
