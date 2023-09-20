<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Product;
use App\Models\FeaturedProduct;
use App\Notifications\lowStockNotify;

class featuredRemoved extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'featured:removed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Featured product removed';

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

        $products = Product::join('featured_products', 'featured_products.product_id', '=', 'products.id')
                    ->select('products.*','featured_products.id as featured','featured_products.end_date as end_date')
                    ->get(); 

        foreach ($products as $product) {
            if(strtotime($product->end_date) < strtotime(date('Y-m-d'))){
                // \Log::info(print_r($product));
                FeaturedProduct::find($product->featured)->delete();
                // $user = User::find($product->user_id);
                // $user->notify(new lowStockNotify($product)); 
            } 
        }
        return 0;
    } 
}
