<?php

namespace App\Http\Controllers;

use App\Models\Host;
use Illuminate\Http\Request;

class HostController extends Controller
{
    public function index()
    {
        $hosts = Host::where('user_id', auth()->user()->id)->orderByDesc('id')->paginate(15);
        return view('hosts.index', compact('hosts'));
    }

    public function create()
    {
        return view('hosts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'address' => 'sometimes|min:3|max:100',
            'host_login' =>'sometimes|min:3|max:100',
            'host_password' => 'sometimes|min:3|max:100',
            'comment' => 'sometimes|min:5|max:300',
        ]);

        Host::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'address' => $request->address,
            'host_login' => $request->host_login,
            'host_password' => $request->host_password,
            'comment' => $request->comment,
        ]);

        return redirect()->route('hosts.index')->with('success', 'Хост успешно изменён');
    }

    public function show(Host $host)
    {
        if (auth()->user()->id != $host->user_id)
        {
            return abort(404);
        }
        $clients = $host->clients()->paginate(15);
        $projects = $host->projects()->orderBy('domain_end')->orderBy('host_end')->paginate(15);
        return view('hosts.show', compact( 'host', 'clients', 'projects'));
    }

    public function edit(Host $host)
    {
        //
    }

    public function update(Request $request, Host $host)
    {
        if (auth()->user()->id != $host->user_id)
        {
            return abort(404);
        }
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'address' => 'sometimes|min:3|max:100',
            'host_login' =>'sometimes|min:3|max:100',
            'host_password' => 'sometimes|min:3|max:100',
            'comment' => 'sometimes|min:5|max:300'
        ]);

        $host->update([
            'name' => $request->name,
            'address' => $request->address,
            'host_login' => $request->host_login,
            'host_password' => $request->host_password,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Хост успешно изменён');
    }

    public function destroy(Host $host)
    {
        if ($host->user_id === auth()->user()->id) {
            $host->delete();
            return back()->with('success', 'Хост успешно удалён');
        }
        abort(403);
    }
}
