<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Host;
use App\Models\Project;
use Illuminate\Http\Request;

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
        $project = new Project;
        $project->user_id = auth()->user()->id;
        $project->name = $request->name;
        $project->domain = $request->domain;
        $project->client_id = $request->client_id;
        $project->domain_end = $request->domain_end;
        $project->host_id = $request->host_id;
        $project->host_end = $request->host_end;
        $project->ftp_login = $request->ftp_login;
        $project->ftp_password = $request->ftp_password;
        $project->db_login = $request->db_login;
        $project->db_password = $request->db_password;
        $project->comment = $request->comment;
        $project->save();

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

        $project->update([
            'name' => $request->name,
            'domain' => $request->domain,
            'client_id' => $request->client_id,
            'domain_end' => $request->domain_end,
            'host_id' => $request->host_id,
            'host_end' => $request->host_end,
            'ftp_login' => $request->ftp_login,
            'ftp_password' => $request->ftp_password,
            'db_login' => $request->db_login,
            'db_password' => $request->db_password,
            'comment' => $request->comment,
        ]);

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
