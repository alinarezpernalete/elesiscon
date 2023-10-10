<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use App\Models\Activity;
use App\Models\HourMgmt;
use App\Models\HourMgmtDetail;

class HoursManagementController extends Controller
{
    public function index(Request $request)
    {
    	$projects = Project::all();
    	$activities = Activity::all();
    	return view('hoursManagement')->with('projects', $projects)->with('activities', $activities);
    }

    public function addHours(Request $request)
    {
        $validatedHourMgmt = '0';
        $newHourMgmt = new HourMgmtDetail();
        $newHourMgmt->codeEmployee = $request->employeeHourMgmt;
        $newHourMgmt->codeProject = $request->projectHourMgmt;
        $newHourMgmt->codeActivity = $request->activityHourMgmt;
        $newHourMgmt->hrsHourMgmt = $request->hrsHourMgmt;
        $newHourMgmt->dateHourMgmt = $request->dateHourMgmt;
        $newHourMgmt->descriptionHourMgmt = $request->descriptionHourMgmt;
        $newHourMgmt->validatedHourMgmt = $validatedHourMgmt;
        $newHourMgmt->save();
        return $newHourMgmt;
    }

    public function loadHours(Request $request)
    {
        $employeeHourMgmt = $request->get('employeeHourMgmt');
        $hours = DB::table('hour_mgmt_details')
        ->join('projects', 'hour_mgmt_details.codeProject', '=', 'projects.id')
        ->join('activities', 'hour_mgmt_details.codeActivity', '=', 'activities.id')
        ->join('employees', 'hour_mgmt_details.codeEmployee', '=', 'employees.id')
        ->select(
                'hour_mgmt_details.id', 
                'hour_mgmt_details.codeEmployee', 
                'employees.firstNameEmployee', 
                'employees.lastNameEmployee',
                'projects.codeProject',
                'projects.nameProject',
                'activities.codeActivity',
                'activities.nameActivity',
                'hour_mgmt_details.hrsHourMgmt',
                'hour_mgmt_details.dateHourMgmt',
                'hour_mgmt_details.descriptionHourMgmt',
                'hour_mgmt_details.validatedHourMgmt')
        ->where('hour_mgmt_details.codeEmployee', $employeeHourMgmt)
        ->where('hour_mgmt_details.validatedHourMgmt', 0)
        ->where('hour_mgmt_details.codeHourMgmt', null)
        ->get();
        //Es necesario poner la fecha de rango, de la fecha tal a la fecha tal
        return $hours;
    }

    public function deleteHours(Request $request)
    {
        $id = $request->get('id');
        $deleteDetail = DB::table('hour_mgmt_details')->where('id', '=', $id)->delete();
        return response()->json(['success'=>'Deleted detail and hours']);
    }

    public function getDateToCode(Request $request)
    {
        $employeeHourMgmt = $request->get('employeeHourMgmt');
        $dateToCode = DB::table('hour_mgmt_details')
        ->join('employees', 'hour_mgmt_details.codeEmployee', '=', 'employees.id')
        ->select('hour_mgmt_details.created_at', 'employees.codeEmployee')
        ->where('hour_mgmt_details.codeEmployee', $employeeHourMgmt)
        ->where('hour_mgmt_details.validatedHourMgmt', 0)
        ->take(1)->get();
        return $dateToCode;
    }

    public function createCodeHourMgmt(Request $request)
    {
        $validatedHourMgmt = '0';
        $newHourMgmt = new HourMgmt();
        $newHourMgmt->codeHourMgmt = $request->codeHourMgmt;
        $newHourMgmt->codeEmployee = $request->employeeHourMgmt;
        $newHourMgmt->validatedHourMgmt = $validatedHourMgmt;
        $newHourMgmt->save();
        return $newHourMgmt;
    }

    public function updateValidated(Request $request)
    {
        $idHour = $request->get('idHour');
        $codeHourMgmt = $request->get('codeHourMgmt');
        $updateHours = HourMgmtDetail::where('id', $idHour)
            ->update(['codeHourMgmt' => $codeHourMgmt]); 

        return $updateHours;
    }

    public function searchToValidated(Request $request)
    {
        $notValidated = DB::table('hour_mgmts')
        ->join('employees', 'hour_mgmts.codeEmployee', '=', 'employees.id')
        ->select('hour_mgmts.id', 'hour_mgmts.codeHourMgmt', 'employees.firstNameEmployee',
                'employees.lastNameEmployee', 'hour_mgmts.created_at', 'hour_mgmts.updated_at')
        ->where('hour_mgmts.validatedHourMgmt', 0)
        ->get();
        return $notValidated;
    }

    public function getHours(Request $request)
    {
        $id = $request->get('id');
        $hours = DB::table('hour_mgmt_details')
        ->join('projects', 'hour_mgmt_details.codeProject', '=', 'projects.id')
        ->join('activities', 'hour_mgmt_details.codeActivity', '=', 'activities.id')
        ->join('employees', 'hour_mgmt_details.codeEmployee', '=', 'employees.id')
        ->join('hour_mgmts', 'hour_mgmt_details.codeHourMgmt', '=', 'hour_mgmts.id')
        ->select(
                'hour_mgmt_details.id',
                'hour_mgmts.codeHourMgmt',
                'hour_mgmt_details.codeEmployee', 
                'employees.firstNameEmployee', 
                'employees.lastNameEmployee',
                'projects.codeProject',
                'projects.nameProject',
                'activities.codeActivity',
                'activities.nameActivity',
                'hour_mgmt_details.hrsHourMgmt',
                'hour_mgmt_details.dateHourMgmt',
                'hour_mgmt_details.descriptionHourMgmt',
                'hour_mgmt_details.validatedHourMgmt')
        ->where('hour_mgmt_details.codeHourMgmt', $id)
        ->where('hour_mgmt_details.validatedHourMgmt', 0)
        ->get();
        return $hours;
    }

    public function saveToValidated(Request $request)
    {
        /*$id = $request->get('id');
        $validated = $request->get('validated');
        if ($validated == "true") {
            $validated = 1;
        } else {
            if ($validated == "false") {
                $validated = 0;
            }
        }
        $updateHours = HourMgmtDetail::where('id', $id)
            ->update(['validatedHourMgmt' => $validated]); 

        $check = DB::table('hour_mgmt_details')
        ->select('hour_mgmt_details.id', 'hour_mgmt_details.validatedHourMgmt')
        ->where('hour_mgmt_details.id', $id)
        ->where('hour_mgmt_details.validatedHourMgmt', 0)
        ->get();

        return $check;*/
        
        $id = $request->get('id');
        $validated = $request->get('validated');
        $indicator = $request->get('indicator');
        
        if ($indicator == "Mgmt va false"){
            $updateHours = HourMgmt::where('id', $id)
            ->update(['validatedHourMgmt' => 0]); 
            return $updateHours;
        }
        if ($indicator == "Mgmt va true"){
            $updateHours = HourMgmt::where('id', $id)
            ->update(['validatedHourMgmt' => 1]); 
            return $updateHours;
        }
        if ($indicator == "details") {
            if ($validated == "true") { $validated = 1; } else { if ($validated == "false") { $validated = 0; } }
            
            $updateHours = HourMgmtDetail::where('id', $id)
                ->update(['validatedHourMgmt' => $validated]); 
                
            return $updateHours;
        }
    }


    /*****************************************************************/

    /*public function neededData(Request $request)
    {
        $employeeTimeControl = $request->get('employeeTimeControl');
        $neededData = DB::table('employees')
        ->select('employees.id', 'employees.codeEmployee')
        ->where('employees.codeUser', $employeeTimeControl)->get();
        return $neededData;
    }

    public function checkCodeTimeControl(Request $request)
    {
        $id = $request->get('id');
        $check = DB::table('time_controls')
        ->select('time_controls.employeeTimeControl')
        ->where('time_controls.employeeTimeControl', $id)->get();
        return $check;
    }

    public function loadHours(Request $request)
    {
        $employeeTimeControl = $request->get('employeeTimeControl');
        $hours = DB::table('time_control_details')
        ->join('time_controls', 'time_control_details.idTimeControlDetail', '=', 'time_controls.id')
        ->join('projects', 'time_control_details.projectTimeControlDetail', '=', 'projects.id')
        ->join('activities', 'time_control_details.activityTimeControlDetail', '=', 'activities.id')
        ->join('employees', 'time_controls.employeeTimeControl', '=', 'employees.id')
        ->select(
                'time_controls.codeTimeControl',
                'time_control_details.id', 
                'time_control_details.idTimeControlDetail', 
                'projects.codeProject',
                'projects.nameProject',
                'activities.codeActivity',
                'activities.nameActivity',
                'time_control_details.hoursTimeControlDetail',
                'time_control_details.dateTimeControlDetail',
                'time_control_details.descriptionTimeControlDetail',
                'time_control_details.validatedTimeControlDetail',
                'employees.firstNameEmployee',
                'employees.lastNameEmployee')
        ->where('time_controls.employeeTimeControl', $employeeTimeControl)
        ->where('time_controls.validatedTimeControl', 0)
        ->where('time_control_details.validatedTimeControlDetail', 0)->get();
        //Es necesario poner la fecha de rango, de la fecha tal a la fecha tal
        return $hours;
    }

    public function checkForAddHours(Request $request)
    {
        $codeTimeControl = $request->get('codeTimeControl');
        $employeeTimeControl = $request->get('employeeTimeControl');
        $checkForAddHours = DB::table('time_controls')
        ->select('time_controls.codeTimeControl')
        ->where('time_controls.codeTimeControl', $codeTimeControl)
        ->where('time_controls.employeeTimeControl', $employeeTimeControl)->get();
        
        return $checkForAddHours;
    }

    public function addTimeControl(Request $request)
    {
        $validatedTimeControl = '0';
        $newTimeControl = new TimeControl();
        $newTimeControl->codeTimeControl = $request->codeTimeControl;
        $newTimeControl->employeeTimeControl = $request->employeeTimeControl;
        $newTimeControl->validatedTimeControl = $validatedTimeControl;
        $newTimeControl->save();
    
        return $newTimeControl;
    }

    public function getCode(Request $request)
    {
        $codeTimeControl = $request->get('codeTimeControl');
        $codeResult = DB::table('time_controls')
        ->select('time_controls.codeTimeControl')
        ->where('time_controls.codeTimeControl', $codeTimeControl)->get();
        return $codeResult;
    }

    public function addHours(Request $request)
    {
        $validatedTimeControlDetail = '0';
        $newTimeControlDetail = new TimeControlDetail();
        $newTimeControlDetail->projectTimeControlDetail = $request->projectTimeControlDetail;
        $newTimeControlDetail->activityTimeControlDetail = $request->activityTimeControlDetail;
        $newTimeControlDetail->hoursTimeControlDetail = $request->hoursTimeControlDetail;
        $newTimeControlDetail->dateTimeControlDetail = $request->dateTimeControlDetail;
        $newTimeControlDetail->descriptionTimeControlDetail = $request->descriptionTimeControlDetail;
        $newTimeControlDetail->validatedTimeControlDetail = $validatedTimeControlDetail;
        $newTimeControlDetail->save();
    
        return $newTimeControlDetail;
    }

    public function deleteHours(Request $request)
    {
        $id = $request->get('id');
        $deleteDetail = DB::table('time_control_details')->where('id', '=', $id)->delete();
        return response()->json(['success'=>'Deleted detail and hours']);
    }

    public function loadToValidated(Request $request)
    {
        $employeeTimeControl = $request->get('employeeTimeControl');

        $hours = DB::table('time_controls')
        ->join('employees', 'time_controls.employeeTimeControl', '=', 'employees.id')
        ->join('projects', 'time_controls.projectTimeControl', '=', 'projects.id')
        ->join('activities', 'time_controls.activityTimeControl', '=', 'activities.id')
        ->join('departments', 'employees.departmentEmployee', '=', 'departments.id')
        ->select('time_controls.id', 'projects.codeProject', 'projects.nameProject', 'activities.codeActivity', 'activities.nameActivity', 'time_controls.hoursTimeControl', 'time_controls.hoursDateTimeControl',  'time_controls.descriptionTimeControl', 'employees.codeEmployee', 'employees.firstNameEmployee', 'employees.lastNameEmployee', 'employees.firstNameEmployee', 'departments.nameDepartment')->where('time_controls.validatedTimeControl', '1')->get();

        return $hours;
    }

    public function updateValidated(Request $request)
    {
        $idHour = $request->get('idHour');
        $updateHours = TimeControl::where('id', $idHour)
            ->update(['validatedTimeControl' => 1]); 

        return $updateHours;
    }*/
}
