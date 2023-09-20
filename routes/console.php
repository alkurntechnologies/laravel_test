<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\UpgradeDatabase;
use App\Jobs\BidWinner;
use App\Jobs\CheckDealProduct;
use App\Jobs\CheckLowStock;
use App\Jobs\CloseRfq;
use App\Jobs\StatusChangeReminderToSeller;
use App\Jobs\QbRefreshToken;
use App\Jobs\MembershipRenewal;
use App\Jobs\Webhook;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('upgrade', function () {
    UpgradeDatabase::dispatch();
});

Artisan::command('bid:win', function () {
    BidWinner::dispatch();
});

Artisan::command('sale:end', function () {
    CheckDealProduct::dispatch();
});

Artisan::command('low:stock', function () {
    CheckLowStock::dispatch();
});

Artisan::command('close:rfq', function () {
    CloseRfq::dispatch();
});

Artisan::command('reminder', function () {
    StatusChangeReminderToSeller::dispatch();
});

Artisan::command('revoke:token', function () {
    QbRefreshToken::dispatch();
});

Artisan::command('membership:renewal', function () {
    MembershipRenewal::dispatch();
});

Artisan::command('bid:auto-pay', function () {
    AuctionAutoDebit::dispatch();
});

Artisan::command('qb:webhook', function () {
    Webhook::dispatch();
});