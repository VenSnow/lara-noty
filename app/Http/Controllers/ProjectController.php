<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Client;
use App\Models\Host;
use App\Models\Project;
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
        $clients = Client::where('user_id', Auth::user()->id)->select('id', 'first_name', 'last_name')->get();
        $hosts = Host::where('user_id', Auth::user()->id)->select('id', 'name')->get();

        return view('projects.create', compact('clients', 'hosts'));
    }

    public function store(StoreRequest $request)
    {
        Auth::user()->projects()->create($request->validated());

        return redirect()->route('projects.index')->with('success', 'Проект успешно добавлен');
    }


    public function show(Project $project)
    {
        if (Auth::user()->id != $project->user_id) {
            abort(404);
        }

        $clients = Client::where('user_id', Auth::user()->id)->select('id', 'first_name', 'last_name')->get();
        $hosts = $project->client->hosts;

        return view('projects.show', compact('project', 'clients', 'hosts'));
    }

    public function edit(Project $project)
    {
        return redirect()->route('projects.show', $project);
    }

    public function update(UpdateRequest $request, Project $project)
    {
        if (Auth::user()->id != $project->user_id) {
            abort(404);
        }

        $project->update($request->validated());

        return back()->with('success', 'Проект успешно изменён');
    }

    public function destroy(Project $project)
    {
        if (Auth::user()->id != $project->user_id) {
            abort(404);
        }

        $project->delete();

        return back()->with('success', 'Проект успешно удалён');
    }
}
