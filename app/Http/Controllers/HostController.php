<?php

namespace App\Http\Controllers;

use App\Http\Requests\Host\StoreRequest;
use App\Http\Requests\Host\UpdateRequest;
use App\Models\Host;
use Illuminate\Support\Facades\Auth;

class HostController extends Controller
{
    public function index()
    {
        $hosts = Host::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(15);

        return view('hosts.index', compact('hosts'));
    }

    public function create()
    {
        return view('hosts.create');
    }

    public function store(StoreRequest $request)
    {
        Auth::user()->hosts()->create($request->validated());

        return redirect()->route('hosts.index')->with('success', 'Хост успешно добавлен');
    }

    public function show(Host $host)
    {
        if (Auth::user()->id != $host->user_id) {
            abort(404);
        }

        $clients = $host->clients()->paginate(15);
        $projects = $host->projects()->orderBy('domain_end')->orderBy('host_end')->paginate(15);

        return view('hosts.show', compact( 'host', 'clients', 'projects'));
    }

    public function edit(Host $host)
    {
        if (Auth::user()->id != $host->user_id) {
            abort(404);
        }
        return redirect()->route('hosts.show', $host);
    }

    public function update(UpdateRequest $request, Host $host)
    {
        if (Auth::user()->id != $host->user_id) {
            abort(404);
        }

        $host->update($request->validated());

        return redirect()->route('hosts.show', $host)->with('success', 'Хост успешно изменён');
    }

    public function destroy(Host $host)
    {
        if ($host->user_id != Auth::user()->id) {
            abort(404);
        }

        $host->delete();

        return redirect()->route('hosts.index')->with('success', 'Хост успешно удалён');
    }
}
