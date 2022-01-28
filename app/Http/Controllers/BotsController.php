<?php

namespace App\Http\Controllers;

use App\Helper\API3commas;
use App\Models\Bots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BotsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bots = Bots::with('user')->paginate(20);
        return view('dashboard.bots.botsList', ['bots' => $bots]);
    }


    public function create()
    {
        $bots = json_decode(API3commas::callAPI('GET', '/public/api/ver1/accounts', false));

        return view('dashboard.bots.create',compact('bots'));
    }

    private function prepareCreateBotRequestUri($name): string
    {
        return '/public/api/ver1/bots/create_bot?' . collect([
                'name'                          => $name,
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

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'exchange' => 'required|min:1|max:64',
            'deposit' => 'required',
            'percentage' => 'required',
        ]);

//        API3commas::execute('post', $this->prepareCreateBotRequestUri(
//            $request->input('exchange')),
//            $request->input('key'),
//            $request->input('secret_key')
//        );

        $user = auth()->user();
        $note = new Bots();
        $note->exchange = $request->input('exchange');
        $note->deposit = $request->input('deposit');
        $note->percentage = $request->input('percentage');
        $note->users_id = $user->id;
        $note->save();
        $request->session()->flash('message', 'Successfully created note');
        return redirect()->route('bots.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bot = Bots::with('user')->find($id);
        return view('dashboard.bots.botsShow', ['bot' => $bot]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bot = Bots::find($id);
        return view('dashboard.bots.edit', ['bot' => $bot]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //var_dump('bazinga');
        //die();
        $validatedData = $request->validate([
            'exchange' => 'required|min:1|max:64',
            'deposit' => 'required',
            'percentage' => 'required',
        ]);
        $note = Bots::find($id);
        $note->exchange = $request->input('exchange');
        $note->deposit = $request->input('deposit');
        $note->percentage = $request->input('percentage');
        $note->save();
        $request->session()->flash('message', 'Successfully edited note');
        return redirect()->route('bots.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Bots::find($id);
        if ($note) {
            $note->delete();
        }
        return redirect()->route('bots.index');
    }
}
