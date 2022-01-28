<?php

namespace App\Http\Controllers;

use App\Helper\API3commas;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notes;
use App\Models\Status;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class NotesController extends Controller
{
    const API_KEY = "1523c6d6933641e38da8c09bef44ce34c219da76781447c8a6f393bb632fceab";
    const SECRET = "8495c1825f16b0473b3b7a1dd712a889e0cb6b9e53001eda9e59d39808b65151b43f317f0ea6b5a57f54d01e19419678d7856a0260e168894579692ddc3c1ca8aa79167b9f46149c48acc52eb3ef08fff0115f716cf6ae24ab1b7a071fd19c23b006d0d7";

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
     * @return Response
     */
    public function index()
    {
        $notes = Notes::with('user')->paginate(20);
        return view('dashboard.notes.notesList', ['notes' => $notes]);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {

        $marketLists = json_decode(API3commas::callAPI('GET', '/public/api/ver1/accounts/market_list', false));

        return view('dashboard.notes.create', ['marketLists' => $marketLists]);
    }

    private function prepareCreateExchange($name, $type): string
    {
        return '/public/api/ver1/accounts/new?name=' . $name . '&type=' . $type . '&customer_id=' . Auth::user()->id;
    }

    public function store(Request $request)
    {

        API3commas::execute('post', '/public/api/ver1/accounts/new?name=' . $request->get('exchange') . '&type=' . $request->get('type') . '&customer_id=' . Auth::user()->id . '&api_key=' . $request->get('key') . '&secret=' . $request->get('secret_key'));
        $validatedData = $request->validate([
            'exchange' => 'required|min:1|max:64',
            'key' => 'required',
            'secret_key' => 'required',
        ]);

        $user = auth()->user();
        $note = new Notes();
        $note->exchange = $request->input('exchange');
        $note->key = $request->input('key');
        $note->secret_key = $request->input('secret_key');
        $note->users_id = $user->id;
        $note->save();
        Http::post("https://api.telegram.org/bot5082214307:AAFiNfmQ6HWt91mMtQt9crxAtZSFRRlMDDM/sendMessage?chat_id=755655480&text=биржа с именем  " . $request->input('exchange') . "  создана успешно!! " . date("Y-m-d"));

        $request->session()->flash('message', 'Successfully created note');
        return redirect()->route('notes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $note = Notes::with('user')->with('status')->find($id);
        return view('dashboard.notes.noteShow', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $note = Notes::find($id);
        return view('dashboard.notes.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //var_dump('bazinga');
        //die();
        $validatedData = $request->validate([
            'exchange' => 'required|min:1|max:64',
            'key' => 'required',
            'secret_key' => 'required',
        ]);
        $note = Notes::find($id);
        $note->exchange = $request->input('exchange');
        $note->key = $request->input('key');
        $note->secret_key = $request->input('secret_key');
        $note->save();
        $request->session()->flash('message', 'Successfully edited note');
        return redirect()->route('notes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $note = Notes::find($id);
        if ($note) {
            $note->delete();
        }
        return redirect()->route('notes.index');
    }
}
