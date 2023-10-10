<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use PDF;

class custReportController extends Controller
{
    public function index(Request $request)
    {
        return view('custReport');
    }
	public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');

        $customer = DB::table('customers')
        ->whereRaw("(customers.created_at >= ? AND customers.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->orderBy('customers.created_at', 'DESC')->get();

        if (count($customer) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('customer', 'since', 'until');
            $pdf = PDF::loadView('pdf.printCustByDate', $data);
            
            return $pdf->stream();
        }
    }
    public function byStatus(Request $request)
    {
        $status = $request->get('status');
    	$customer = Customer::where('statusCustomer', $status)->get();
    	
        if (count($customer) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('customer');
            $pdf = PDF::loadView('pdf.printCustByStatus', $data);
            
            return $pdf->stream();
        }
    }
}
