<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use PDF;

class quoReportController extends Controller
{
    public function index(Request $request)
    {
    	$users = User::all();
    	$customers = Customer::all();
        return view('quoReport')->with('users', $users)->with('customers', $customers);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        
        /*$quotations = Sale::
        join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        //SELECT sales.codeSale, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle FROM sale_details, sales WHERE sale_details.codeSale = sales.id AND sales.quoDateSale BETWEEN '2021-06-17 00:00:00' AND '2021-06-18 23:59:59' GROUP by sales.codeSale HAVING COUNT(sales.codeSale) >= 1

        $quotations = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.quoDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.quoDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $quotationsTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($quotations) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('quotations','quotationsTotal','since','until');
            $pdf = PDF::loadView('pdf.printQuoByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byUser(Request $request)
    {
        $user = $request->get('user');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$quotations = Sale::join('users', 'sales.userSale', '=', 'users.id')
        		->where('userSale', $user)
        		->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        $quotations = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.quoDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('userSale', $user)
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.quoDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $quotationsTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
                ->select(DB::raw('SUM(unitPriceArticle) as total'))->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->where('userSale', $user)->get();

        if (count($quotations) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('quotations','quotationsTotal','since','until');
            $pdf = PDF::loadView('pdf.printQuoByUser', $data);
            
            return $pdf->stream();
        }
    }

    public function byCustomer(Request $request)
    {
        $customer = $request->get('customer');
        $since = $request->get('since');
        $until = $request->get('until');
        
        /*$quotations = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->where('customerSale', $customer)
        ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        $quotations = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.quoDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('customerSale', $customer)
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.quoDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $quotationsTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
                ->select(DB::raw('SUM(unitPriceArticle) as total'))
                ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
                ->where('customerSale', $customer)->get();

        if (count($quotations) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('quotations','quotationsTotal','since','until');
            $pdf = PDF::loadView('pdf.printQuoByCustomer', $data);
            
            return $pdf->stream();
        }
    }

    public function byCancel(Request $request)
    {
        $typeSale = $request->get('typeSale');
        $since = $request->get('since');
        $until = $request->get('until');
        $quotations = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
        		->where('typeSale', $typeSale)
        		->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $quotations = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->select(DB::raw('sales.codeSale, payment_conditions.namePayment, sales.descriptionSale, sales.quoDateSale, users.name, customers.nameCustomer, customers.codeCustomer, (case when COUNT(sales.codeSale) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('typeSale', $typeSale)
        ->groupBy('sales.codeSale', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.quoDateSale', 'users.name', 'customers.nameCustomer', 'customers.codeCustomer')
        ->havingRaw('COUNT(sales.codeSale) >= 1')->get();

        $quotationsTotal = DB::table('sale_details')
        ->join('sales', 'sale_details.codeSale', '=', 'sales.id')
                ->select(DB::raw('SUM(unitPriceArticle) as total'))
                ->whereRaw("(sales.quoDateSale >= ? AND sales.quoDateSale <= ?)", [$since." 00:00:00", $until." 23:59:59"])
                ->where('typeSale', $typeSale)->get();

        if (count($quotations) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('quotations','since','until','quotationsTotal');
            $pdf = PDF::loadView('pdf.printQuoByCancel', $data);
            
            return $pdf->stream();
        }
    }
}