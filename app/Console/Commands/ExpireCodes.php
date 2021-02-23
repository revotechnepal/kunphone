<?php

namespace App\Console\Commands;

use App\Mail\ExpireCode;
use App\Models\Product;
use App\Models\ProductIncoming;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ExpireCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expired code mail';

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
        $products = ProductIncoming::where('is_approved', 1)->where('is_sent', 0)->get();
        $nowdate = date('Y-m-d h:i:s');

        $dateinmilisec = strtotime($nowdate);

        foreach ($products as $product) {

            $user = User::where('id', $product->user_id)->first();
            $productreal = Product::where('id', $product->product_id)->first();
            $updatedinmilisec = strtotime($product->updated_at.'+1 week');

            if($updatedinmilisec < $dateinmilisec){
                DB::update('update product_incomings set is_sent = 1 where id = ?', [$product->id]);
                $email = $user->email;
                $mailData = [
                    'name' => $user->name,
                    'product_name' => $productreal->name,
                    'ram' => $product->ram,
                    'rom' => $product->rom,
                    'exchangecode' => $product->exchangecode
                ];

                Mail::to($email)->send(new ExpireCode($mailData));
            }
        }
    }
}
