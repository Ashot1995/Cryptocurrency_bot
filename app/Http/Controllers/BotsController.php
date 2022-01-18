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
//        Http::post("https://api.telegram.org/bot5082214307:AAFiNfmQ6HWt91mMtQt9crxAtZSFRRlMDDM/sendMessage?chat_id=755655480&text=my sample text");
        $bots = Bots::with('user')->paginate(20);
        return view('dashboard.bots.botsList', ['bots' => $bots]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.bots.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'exchange' => 'required|min:1|max:64',
            'deposit' => 'required',
            'percentage' => 'required',
        ]);
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
