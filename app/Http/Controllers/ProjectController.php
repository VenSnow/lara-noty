<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->user()->id)->orderBy('domain_end')->orderBy('host_end')->paginate(15);
        return view('projects.index', compact('projects'));
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if (auth()->user()->id != $project->user_id)
        {
            return abort(404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
