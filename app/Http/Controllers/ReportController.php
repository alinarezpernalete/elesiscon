<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class ReportController extends Controller
{
    public function getUsers()
    {
        $employees = Employee::all();
        return $employees
    }
}
