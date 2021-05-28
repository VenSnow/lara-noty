<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Host;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)->orderByDesc('id')->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $hosts = Host::where('user_id', auth()->user()->id)->select('id', 'name')->orderByDesc('id')->get();
        return view('clients.create', compact('hosts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|min:2|max:25',
            'last_name' => 'sometimes|min:2|max:25',
            'email' => 'required|email|min:2|max:50',
            'phone' => 'required|min:7|max:50',
            'comment' => 'sometimes|max:500',
        ]);

        $hosts = $request->hosts;


        $client = new Client;
        $client->user_id = auth()->user()->id;
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->comment = $request->comment;
        $client->save();
        $client->hosts()->attach($hosts);

        return redirect()->route('clients.index')->with('success', 'Клиент успешно добавлен');
    }

    public function show(Client $client)
    {
        if (auth()->user()->id != $client->user_id)
        {
            return abort(404);
        }
        $allHosts = Host::where('user_id', auth()->user()->id)->select('id', 'name')->orderByDesc('id')->get();
        $hosts = $client->hosts()->paginate(15);
        $projects = $client->projects()->orderBy('domain_end')->orderBy('host_end')->paginate(15);
        return view('clients.show', compact('client', 'hosts', 'projects', 'allHosts'));
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
           'comment' => 'sometimes|max:500',
        ]);

        $hosts = $request->hosts;

        $client = Client::findOrFail($client->id);
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->comment = $request->comment;
        $client->save();
        $client->hosts()->sync($hosts);

        return back()->with('success', 'Клиент успешно изменён');

    }

    public function destroy(Client $client)
    {
        if ($client->user_id === auth()->user()->id) {
            $client->delete();

            return back()->with('success', 'Клиент успешно удалён');
        }
        abort(403);
    }
}
