<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use PDF;

class delNoteReportController extends Controller
{
    public function index(Request $request)
    {
    	$users = User::all();
    	$customers = Customer::all();
        return view('delNoteReport')->with('users', $users)->with('customers', $customers);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        /*$delNotes = Sale::join('users', 'sales.userSale', '=', 'users.id')
        		->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        $delNotes = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.delNoteDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.delNoteDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $delNotesTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($delNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('delNotes','delNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printDelNoteByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byUser(Request $request)
    {
        $user = $request->get('user');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$delNotes = Sale::join('users', 'sales.userSale', '=', 'users.id')
        		->where('userSale', $user)
        		->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        $delNotes = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.delNoteDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('userSale', $user)
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.delNoteDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $delNotesTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('userSale', $user)
        ->get();

        if (count($delNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('delNotes','delNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printDelNoteByUser', $data);
            
            return $pdf->stream();
        }
        
        return $pdf->stream();
    }

    public function byCustomer(Request $request)
    {
        $customer = $request->get('customer');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$delNotes = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
        		->where('customerSale', $customer)
        		->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        
        $delNotes = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.delNoteDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('customerSale', $customer)
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.delNoteDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $delNotesTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('customerSale', $customer)
        ->get();

        if (count($delNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('delNotes','delNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printDelNoteByCustomer', $data);
            
            return $pdf->stream();
        }
        
    }

    public function byCancel(Request $request)
    {
        $typeSale = $request->get('typeSale');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$delNotes = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
        		->where('typeSale', $typeSale)
        		->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        
        $delNotes = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.delNoteDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('typeSale', $typeSale)
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.delNoteDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $delNotesTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(sales.delNoteDateSale >= ? AND sales.delNoteDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('typeSale', $typeSale)
        ->get();

        if (count($delNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('delNotes','delNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printDelNoteByCustomer', $data);
            
            return $pdf->stream();
        }
    }

}
