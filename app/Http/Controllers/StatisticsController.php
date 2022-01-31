<?php

namespace App\Http\Controllers;

use App\Helper\API3commas;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $accounts = json_decode(API3commas::callAPI('GET', '/public/api/ver1/accounts', false));
        $bots = json_decode(API3commas::callAPI('GET', '/public/api/ver1/bots', false));
        return view('dashboard.statistic.statistic', compact('accounts','bots'));
    }

}
