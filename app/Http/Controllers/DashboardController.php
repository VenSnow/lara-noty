<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Host;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Client::where('user_id', auth()->user()->id)->get()->pluck('id');
        $hostsCount = Host::where('user_id', auth()->user()->id)->get()->pluck('id');
        $projectsCount = Project::where('user_id', auth()->user()->id)->get()->pluck('id');
        $projects = Project::where('user_id', auth()->user()->id)->where(function ($q) {
            $q->where('domain_end', '<=', Carbon::now()->addDays(45));
            $q->orWhere('host_end', '<=', Carbon::now()->addDays(45));
        })->orderBy('domain_end')->orderBy('host_end')->paginate(15);
        return view('dashboard', compact('clientsCount', 'hostsCount', 'projectsCount', 'projects'));
    }
}

//Project::where('user_id', auth()->user()->id)
//    ->whereBetween('domain_end', [$startDate, $endDate])
//    ->orderBy('domain_end')
//    ->orderBy('host_end')
//    ->paginate(15);
