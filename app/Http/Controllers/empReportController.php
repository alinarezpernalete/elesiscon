<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Job;
use Illuminate\Support\Facades\DB;
use PDF;

class empReportController extends Controller
{
    public function index(Request $request)
    {
    	$employees = Employee::all();
    	$departments = Department::all();
    	$jobs = Job::all();
        return view('empReport')->with('employees', $employees)->with('departments', $departments)->with('jobs', $jobs);
    }

    public function byDepartment(Request $request)
    {
        $department = $request->get('department');
    	$employee = Employee::join('departments', 'employees.departmentEmployee', '=', 'departments.id')
    		->join('jobs', 'employees.jobEmployee', '=', 'jobs.id')
    		->where('departmentEmployee', $department)->get();
    	if (count($employee) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('employee');
            $pdf = PDF::loadView('pdf.printEmpByDepartment', $data);
            
            return $pdf->stream();
        }
    }
    public function byJob(Request $request)
    {
        $job = $request->get('job');
    	$employee = Employee::join('departments', 'employees.departmentEmployee', '=', 'departments.id')
    		->join('jobs', 'employees.jobEmployee', '=', 'jobs.id')
    		->where('jobEmployee', $job)->get();
    	
        if (count($employee) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('employee');
            $pdf = PDF::loadView('pdf.printEmpByJob', $data);
            
            return $pdf->stream();
        }
    }
    public function byStatus(Request $request)
    {
        $status = $request->get('status');
    	$employee = Employee::join('departments', 'employees.departmentEmployee', '=', 'departments.id')
    		->join('jobs', 'employees.jobEmployee', '=', 'jobs.id')
    		->where('statusEmployee', $status)->get();
    	
        if (count($employee) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('employee');
            $pdf = PDF::loadView('pdf.printEmpByStatus', $data);
            
            return $pdf->stream();
        }
    }
}
