<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Job;
use App\User;

class EmployeesController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*if($request){ $query = trim($request->get('search')); $employees = Employee::where('nameEmployee', 'LIKE', '%'. $query .'%')->orderBy('id', 'asc')->paginate(5); return view('employees', ['employees' => $employees, 'search' => $query, 'value' => $query]); } $employees = Employee::all()->paginate(5);return view('employees', ['employees' => $employees]);*/

        $departments = Department::all();
        $jobs = Job::all();
        $users = User::all();
        $employees = DB::table('employees')
        ->join('departments', 'employees.departmentEmployee', '=', 'departments.id')
        ->join('jobs', 'employees.jobEmployee', '=', 'jobs.id')
        ->select('employees.id', 'employees.codeEmployee', 'employees.firstNameEmployee', 'employees.lastNameEmployee', 'employees.birthDateEmployee', 'departments.nameDepartment', 'jobs.nameJob', 'employees.phoneEmployee', 'employees.joinDateEmployee')->where('statusEmployee', 1)->orderBy('id', 'DESC')->paginate(10);
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $employees = DB::table('employees')
            ->join('departments', 'employees.departmentEmployee', '=', 'departments.id')
            ->join('jobs', 'employees.jobEmployee', '=', 'jobs.id')
            ->select('employees.id', 'employees.codeEmployee', 'employees.firstNameEmployee', 'employees.lastNameEmployee', 'employees.birthDateEmployee', 'departments.nameDepartment', 'jobs.nameJob', 'employees.phoneEmployee', 'employees.joinDateEmployee')->where($filterSearch, 'LIKE', "%$search%")->where('statusEmployee', 1)->orderBy('id', 'DESC')->paginate(10);

            return view('employees')->with('employees', $employees)->with('departments', $departments)->with('jobs', $jobs)->with('users', $users)->with('search', $search);
        }

        return view('employees')->with('employees', $employees)->with('departments', $departments)->with('jobs', $jobs)->with('users', $users)->with('search', $search);
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

        $newEmployee = new Employee();
        $newEmployee->codeEmployee = $request->codeEmployee;
        $newEmployee->firstNameEmployee = $request->firstNameEmployee;
        $newEmployee->lastNameEmployee = $request->lastNameEmployee;
        $newEmployee->birthDateEmployee = $request->birthDateEmployee;
        $newEmployee->departmentEmployee = $request->departmentEmployee;
        $newEmployee->jobEmployee = $request->jobEmployee;
        $newEmployee->phoneEmployee = $request->phoneEmployee;
        $newEmployee->joinDateEmployee = $request->joinDateEmployee;
        $newEmployee->genderEmployee = $request->genderEmployee;
        $newEmployee->additionalEmployee = $request->additionalEmployee;
        $newEmployee->addressEmployee = $request->addressEmployee;
        $newEmployee->statusEmployee = 1;
        $newEmployee->save();
        return $newEmployee;
        //return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_employee)
    {
        $employee = Employee::find($id_employee);

        $employee->nameEmployee = $request->nameEmployee;
        $employee->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id_employee)
    {
        $employee = Employee::find($id_employee);
        $employee->delete();
        return redirect()->back();
    }

    public function updateUser(Request $request)
    {
        $id = $request->get('id');
        $codeUser = $request->get('codeUser'); if ($codeUser != "") 
        { $updateUser = Employee::where('id', $id)->update(['codeUser' => $codeUser]); }
        $department = $request->get('department'); if ($department != "") 
        { $updateUser = Employee::where('id', $id)->update(['departmentEmployee' => $department]); }
        $job = $request->get('job'); if ($job != "") 
        { $updateUser = Employee::where('id', $id)->update(['jobEmployee' => $job]); }
        $phone = $request->get('phone'); if ($phone != "") 
        { $updateUser = Employee::where('id', $id)->update(['phoneEmployee' => $phone]); }

        return $updateUser;
    }

    public function additionalInfo(Request $request)
    {
        $id = $request->get('id');
        $employees = DB::table('employees')
        ->select('employees.id', 'employees.codeEmployee', 'employees.firstNameEmployee', 'employees.lastNameEmployee', 'employees.birthDateEmployee', 'employees.departmentEmployee', 'employees.jobEmployee', 'employees.phoneEmployee', 'employees.joinDateEmployee', 'employees.codeUser', 'employees.genderEmployee','employees.additionalEmployee','employees.addressEmployee')->where('employees.id', $id)->get();

        return $employees;
    }

    public function desactiveEmployee(Request $request)
    {
        $id = $request->get('id');
        $updateUser = Employee::where('id', $id)->update(['statusEmployee' => 0]);
        return $updateUser;
    }
}
