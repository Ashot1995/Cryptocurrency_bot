<?php

namespace App\Http\Controllers;

use App\Helper\API3commas;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $accounts = json_decode(API3commas::callAPI('GET', '/public/api/ver1/accounts', false));
//       dd(json_decode(API3commas::callAPI('GET', '/public/api/ver1/bots', false)));

        //api 9YDHoK5YiR1GH0WciD6RCgr0Api7zp4DIhBr7ubPGf1KmCxsbNy2uG4bwX38QEMo
        //30587179
        //market_code": "binance_futures_coin"

//        dd(json_decode(API3commas::callAPI('GET', '/public/api/ver1/bots', false)));

        dd(json_decode(API3commas::execute('post', $this->prepareCreateBotRequestUri())));

        dd(json_decode(API3commas::callAPI('GET', '/public/api/ver1/bots?account_id=30587179', false)));

        return view('dashboard.statistic.statistic', compact('accounts'));
    }

    private function prepareCreateBotRequestUri(): string
    {
        return '/public/api/ver1/bots/create_bot?' . collect([
            'name'                          => 'ASH',
            'account_id'                    => 30587176,
            'pairs'                         => urlencode("['BTC_LTC']"),
            'base_order_volume'             => 100,
            'take_profit'                   => 0.05,
            'safety_order_volume'           => 0.1,
            'martingale_volume_coefficient' => 1,
            'martingale_step_coefficient'   => 1,
            'max_safety_orders'             => 10,
            'active_safety_orders_count'    => 50,
            'safety_order_step_percentage'  => 5,
            'take_profit_type'              => 'base',
            'strategy_list'                 => urlencode(json_encode([['strategy' => 'manual']])),
        ])->map(function ($value, $key) {
            return $key . '=' . $value;
        })->join('&');
    }
}
