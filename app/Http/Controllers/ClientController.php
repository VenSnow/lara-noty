<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)->orderByDesc('id')->paginate(15);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function show(Client $client)
    {
        if (auth()->user()->id != $client->user_id)
        {
            return abort(404);
        }
        $hosts = $client->hosts()->paginate(15);
        $projects = $client->projects()->orderBy('domain_end')->orderBy('host_end')->paginate(15);
        return view('clients.show', compact('client', 'hosts', 'projects'));
    }

    public function edit(Client $client)
    {
        //
    }

    public function update(Request $request, Client $client)
    {
        if (auth()->user()->id != $client->user_id)
        {
            return abort(404);
        }
        $this->validate($request, [
           'first_name' => 'required|min:2|max:25',
           'last_name' => 'sometimes|min:2|max:25',
           'email' => 'required|email|min:2|max:50',
           'phone' => 'required|min:7|max:50',
           'comment' => 'sometimes|min:5|max:500',
        ]);

        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Клиент успешно изменён');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
