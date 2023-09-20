<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\CheckLowStock;
use App\Jobs\BidWinner;
use App\Jobs\CheckDealProduct;
use App\Jobs\CloseRfq;
use App\Jobs\StatusChangeReminderToSeller;
use App\Jobs\QbRefreshToken;
use App\Jobs\MembershipRenewal;
use App\Jobs\AuctionAutoDebit;
use App\Jobs\Webhook;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\lowStock::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
