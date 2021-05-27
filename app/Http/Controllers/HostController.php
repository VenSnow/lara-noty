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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Host  $host
     * @return \Illuminate\Http\Response
     */
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
        ]);

        $host->update([
            'name' => $request->name,
            'address' => $request->address,
            'host_login' => $request->host_login,
            'host_password' => $request->host_password,
        ]);

        return back()->with('success', 'Хост успешно изменён');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Host  $host
     * @return \Illuminate\Http\Response
     */
    public function destroy(Host $host)
    {
        //
    }
}
