<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreRequest;
use App\Http\Requests\Client\UpdateRequest;
use App\Models\Client;
use App\Models\Host;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::where('user_id', auth()->user()->id)->orderByDesc('id')->paginate(15);

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $hosts = Host::where('user_id', Auth::user()->id)->select('id', 'name')->orderByDesc('id')->get();

        return view('clients.create', compact('hosts'));
    }

    public function store(StoreRequest $request)
    {
        $client = Auth::user()->clients()->create($request->validated());
        $client->hosts()->attach($request->hosts);

        return redirect()->route('clients.index')->with('success', 'Клиент успешно добавлен');
    }

    public function show(Client $client)
    {
        if (Auth::user()->id != $client->user_id) {
            abort(404);
        }

        $allHosts = Host::where('user_id', Auth::user()->id)->select('id', 'name')->orderByDesc('id')->get();
        $hosts = $client->hosts()->paginate(15);
        $projects = $client->projects()->orderBy('domain_end')->orderBy('host_end')->paginate(15);

        return view('clients.show', compact('client', 'hosts', 'projects', 'allHosts'));
    }

    public function edit(Client $client)
    {
        return redirect()->route('clients.show', $client);
    }

    public function update(UpdateRequest $request, Client $client)
    {
        if (Auth::user()->id != $client->user_id) {
            abort(404);
        }

        $client->update($request->validated());
        $client->hosts()->sync($request->hosts);

        return back()->with('success', 'Клиент успешно изменён');
    }

    public function destroy(Client $client)
    {
        if (Auth::user()->id != $client->user_id) {
            abort(404);
        }

        $client->delete();

        return back()->with('success', 'Клиент успешно удалён');
    }
}
