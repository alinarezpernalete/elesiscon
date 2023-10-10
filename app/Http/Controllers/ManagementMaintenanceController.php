<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Job;
use App\Models\Project;
use App\Models\Activity;

class ManagementMaintenanceController extends Controller
{
	public function index(Request $request)
    {
        $departments = Department::all();
        $jobs = Job::all();
        $projects = Project::all();
        $activities = Activity::all();
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");
        /*--------------------------------------------------------------------------------------------------------*/
        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            if ($filterSearch == "codeDepartment" || $filterSearch == "nameDepartment") {
                $departments = DB::table('departments')
                ->select('departments.id', 'departments.codeDepartment', 'departments.nameDepartment')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->get();

                return view('managementMaintenance')->with('departments', $departments)->with('jobs', $jobs)->with('projects', $projects)->with('activities', $activities)->with('search', $search)->with('filterSearch', $filterSearch);
            }

            if ($filterSearch == "codeJob" || $filterSearch == "nameJob") {
                $jobs = DB::table('jobs')
                ->select('jobs.id', 'jobs.codeJob', 'jobs.nameJob')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->get();

                return view('managementMaintenance')->with('departments', $departments)->with('jobs', $jobs)->with('projects', $projects)->with('activities', $activities)->with('search', $search)->with('filterSearch', $filterSearch);
            }

            if ($filterSearch == "codeProject" || $filterSearch == "nameProject") {
                $projects = DB::table('projects')
                ->select('projects.id', 'projects.codeProject', 'projects.nameProject')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->get();

                return view('managementMaintenance')->with('departments', $departments)->with('jobs', $jobs)->with('projects', $projects)->with('activities', $activities)->with('search', $search)->with('filterSearch', $filterSearch);
            }

            if ($filterSearch == "codeActivity" || $filterSearch == "nameActivity") {
                $activities = DB::table('activities')
                ->select('activities.id', 'activities.codeActivity', 'activities.nameActivity')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->get();

                return view('managementMaintenance')->with('departments', $departments)->with('jobs', $jobs)->with('projects', $projects)->with('activities', $activities)->with('search', $search)->with('filterSearch', $filterSearch);
            }
        }
        /*--------------------------------------------------------------------------------------------------------*/
        return view('managementMaintenance')->with('departments', $departments)->with('jobs', $jobs)->with('projects', $projects)->with('activities', $activities)->with('search', $search)->with('filterSearch', $filterSearch);
    }

    public function checkDepartment(Request $request)
    {
        $newDepartment = new Bank();
        $newDepartment->codeDepartment = $request->codeDepartment;
        $newDepartment->nameDepartment = $request->nameDepartment;
        $newDepartment->save();
    }

    public function checkJob(Request $request)
    {
        $newJob = new Job();
        $newJob->codeJob = $request->codeJob;
        $newJob->nameJob = $request->nameJob;
        $newJob->save();
    }

    public function checkProject(Request $request)
    {
        $newProject = new Project();
        $newProject->codeProject = $request->codeProject;
        $newProject->nameProject = $request->nameProject;
        $newProject->save();
    }

    public function checkActivity(Request $request)
    {
        $newActivity = new Activity();
        $newActivity->codeActivity = $request->codeActivity;
        $newActivity->nameActivity = $request->nameActivity;
        $newActivity->save();
    }

}
