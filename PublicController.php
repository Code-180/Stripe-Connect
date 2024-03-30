<?php

namespace App\Http\Controllers;

use URL;

class PublicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }
    public function stripePayment()
    {

        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $stripe = new \Stripe\StripeClient(env('STRIP_KEY'));
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // Product Craete
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //$getProductOBJ = $stripe->products->create(['name' => 'Stubborn Attachments Book']);
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // One Time Price Create
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // $getPriceOBJ = $stripe->prices->create([
        //     'currency'       => 'usd',
        //     'unit_amount'    => 1000,
        //     'product'        => 'prod_PpHSd6pfBTi0Bf',
        //     'billing_scheme' => 'per_unit',
        // ]);
        // dd($getPriceOBJ);
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //Payment Code
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $getSessionCheckOutOBJ = $stripe->checkout->sessions->create([
            'line_items'  => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                'price'    => 'price_1OzcvfSDjsmm0EA1YIuBNR6V',
                'quantity' => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => URL::to('/success'),
            'cancel_url'  => URL::to('/cancel'),
        ]);
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //Payment Code B2B VenderPayment
        //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $stripe->checkout->sessions->create([
            'mode'                => 'payment',
            'line_items'          => [
                [
                    'price'    => 'price_1OzcvfSDjsmm0EA1YIuBNR6V',
                    'quantity' => 1,
                ],
            ],
            'payment_intent_data' => [
                'application_fee_amount' => 200,
                'transfer_data'          => ['destination' => 'acct_1Ozd7t4I8K9BKuvw'],
            ],
            'success_url'         => URL::to('/success'),
            'cancel_url'          => URL::to('/cancel'),
        ]);
        return redirect()->intended($getSessionCheckOutOBJ->url);

    }
    public function stripeConnect()
    {
        
        $stripe = new \Stripe\StripeClient(env('STRIP_KEY'));
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $connectOBJ = $stripe->accounts->create(['type' => 'standard']); //standard, express, or custom
        dd($connectOBJ);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //Varify All The Details For The Vendor
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //Generate Link
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $accountOBJ  = $stripe->accountLinks->create([
            'account'     => 'acct_1OzdLkSHE3lCPgoV',
            'refresh_url' => URL::to('/success'),
            'return_url'  => URL::to('/success'),
            'type'        => 'account_onboarding',
        ]);
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // SAMPLE RETURN 
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // {
        //   "object": "account_link",
        //   "created": 1680577733,
        //   "expires_at": 1680578033,
        //   "url": "https://connect.stripe.com/setup/c/acct_1Mt0CORHFI4mz9Rw/TqckGNUHg2mG"
        // }

    }
}
