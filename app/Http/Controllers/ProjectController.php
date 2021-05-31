<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Host;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->user()->id)->orderByDesc('id')->paginate(15);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $clients = Client::where('user_id', auth()->user()->id)->select('id', 'first_name', 'last_name')->get();
        $hosts = Host::where('user_id', auth()->user()->id)->select('id', 'name')->get();
        return view('projects.create', compact('clients', 'hosts'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'domain' => 'required|min:3|max:50',
            'client_id' => 'required|numeric',
            'domain_end' => 'required|date',
            'host_id' => 'required|numeric',
            'host_end' => 'required|date',
            'ftp_login' => 'required|min:2',
            'ftp_password' => 'required',
            'db_login' => 'required|min:2',
            'db_password' => 'required',
        ]);

        $project = $request->all();

        Auth::user()->projects()->create($project);

        return redirect()->route('projects.index')->with('success', 'Проект успешно добавлен');
    }


    public function show(Project $project)
    {
        if (auth()->user()->id != $project->user_id)
        {
            return abort(404);
        }
        $clients = Client::where('user_id', auth()->user()->id)->select('id', 'first_name', 'last_name')->get();
        $hosts = $project->client->hosts;
        return view('projects.show', compact('project', 'clients', 'hosts'));
    }

    public function edit(Project $project)
    {
        //
    }

    public function update(Request $request, Project $project)
    {
        if (auth()->user()->id != $project->user_id)
        {
            return abort(404);
        }
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'domain' => 'required|min:3|max:50',
            'client_id' => 'required|numeric',
            'domain_end' => 'required|date',
            'host_id' => 'required|numeric',
            'host_end' => 'required|date',
            'ftp_login' => 'required|min:2',
            'ftp_password' => 'required',
            'db_login' => 'required|min:2',
            'db_password' => 'required',
        ]);

        $project->update($request->all());

        return back()->with('success', 'Проект успешно изменён');
    }

    public function destroy(Project $project)
    {
        if (auth()->user()->id != $project->user_id)
        {
            return abort(404);
        }
        $project->delete();
        return back()->with('success', 'Проект успешно удалён');
    }
}
