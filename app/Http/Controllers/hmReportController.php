<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Activity;
use App\Models\HourMgmtDetail;
use Illuminate\Support\Facades\DB;
use PDF;

class hmReportController extends Controller
{
    public function index(Request $request)
    {
    	$employees = Employee::all();
    	$projects = Project::all();
    	$activities = Activity::all();
        return view('hmReport')->with('employees', $employees)->with('projects', $projects)->with('activities', $activities);
    }

    public function byUser(Request $request)
    {
        $employee = $request->get('employee');
        $since = $request->get('since');
        $until = $request->get('until');
        
        $hourMgmt = HourMgmtDetail::join('projects', 'hour_mgmt_details.codeProject', '=', 'projects.id')
        		->join('activities', 'hour_mgmt_details.codeActivity', '=', 'activities.id')->join('employees', 'hour_mgmt_details.codeEmployee', '=', 'employees.id')
        		->where('hour_mgmt_details.codeEmployee', $employee)
        		->whereRaw("(hour_mgmt_details.created_at >= ? AND hour_mgmt_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $hourTot = DB::table('hour_mgmt_details')
                ->select(DB::raw('SUM(hrsHourMgmt) as total'))->where('codeEmployee', $employee)->whereRaw("(hour_mgmt_details.created_at >= ? AND hour_mgmt_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($hourMgmt) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('hourMgmt', 'hourTot', 'since', 'until');
            $pdf = PDF::loadView('pdf.printHourMgmtByUser', $data);
            
            return $pdf->stream();
        }
    }

    public function byProject(Request $request)
    {
        $project = $request->get('project');
        $since = $request->get('since');
        $until = $request->get('until');
        $hourMgmt = HourMgmtDetail::join('employees', 'hour_mgmt_details.codeEmployee', '=', 'employees.id')
        		->join('activities', 'hour_mgmt_details.codeActivity', '=', 'activities.id')->join('projects', 'hour_mgmt_details.codeProject', '=', 'projects.id')
        		->where('hour_mgmt_details.codeProject', $project)
        		->whereRaw("(hour_mgmt_details.created_at >= ? AND hour_mgmt_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();
        $hourTot = DB::table('hour_mgmt_details')
                ->select(DB::raw('SUM(hrsHourMgmt) as total'))->where('hour_mgmt_details.codeProject', $project)->whereRaw("(hour_mgmt_details.created_at >= ? AND hour_mgmt_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();
        if (count($hourMgmt) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('hourMgmt', 'hourTot', 'since', 'until');
            $pdf = PDF::loadView('pdf.printHourMgmtByProject', $data);
            
            return $pdf->stream();
        }
    }
    public function byGraphic(Request $request)
    {
        $project = $request->get('project');
        $since = $request->get('since');
        $until = $request->get('until');

        $datas = HourMgmtDetail::select(\DB::raw("hrsHourMgmt"))
                    /*->whereDay('created_at', date('d'))*/
                    ->whereRaw("(hour_mgmt_details.created_at >= ? AND hour_mgmt_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
                    ->where('codeProject', $project)
                    ->pluck('hrsHourMgmt');

        if (count($datas) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            return view('pdf.exampleGraphic', compact('datas'));
        }
    }
}
