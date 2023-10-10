<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\AR;
use Illuminate\Support\Facades\DB;
use PDF;

class ARReportController extends Controller
{
    public function index(Request $request)
    {
    	$banks = Bank::all();
    	$currencies = Currency::all();
    	$customers = Customer::all();
        return view('ARReport')->with('banks', $banks)->with('currencies', $currencies)->with('customers', $customers);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');

        $ARs = AR::join('sales', 'a_r_s.codeSale', '=', 'sales.id')->
        join('customers', 'a_r_s.codeCustomer', '=', 'customers.id')->
        join('payment_conditions', 'a_r_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_r_s.codeCurrency', '=', 'currencies.id')->
        join('banks', 'a_r_s.codeBank', '=', 'banks.id')
        ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $ARsTot = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountDocument) as total'))
                ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $ARsTot2 = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountAR) as total'))->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($ARs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('ARs','since','until','ARsTot','ARsTot2');
            $pdf = PDF::loadView('pdf.printARByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byBank(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $bank = $request->get('bank');

        $ARs = AR::join('sales', 'a_r_s.codeSale', '=', 'sales.id')->
        join('customers', 'a_r_s.codeCustomer', '=', 'customers.id')->
        join('payment_conditions', 'a_r_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_r_s.codeCurrency', '=', 'currencies.id')->
        join('banks', 'a_r_s.codeBank', '=', 'banks.id')->
        where('a_r_s.codeBank', $bank)
        ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $ARsTot = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountDocument) as total'))
                ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
                ->where('a_r_s.codeBank', $bank)->get();

        $ARsTot2 = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountAR) as total'))->where('a_r_s.codeBank', $bank)->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($ARs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('ARs','since','until','ARsTot','ARsTot2');
            $pdf = PDF::loadView('pdf.printARByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byCurrency(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $currency = $request->get('currency');

        $ARs = AR::join('sales', 'a_r_s.codeSale', '=', 'sales.id')->
        join('customers', 'a_r_s.codeCustomer', '=', 'customers.id')->
        join('payment_conditions', 'a_r_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_r_s.codeCurrency', '=', 'currencies.id')->
        join('banks', 'a_r_s.codeBank', '=', 'banks.id')->
        where('a_r_s.codeCurrency', $currency)
        ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $ARsTot = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountDocument) as total'))
                ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
                ->where('a_r_s.codeCurrency', $currency)->get();

        $ARsTot2 = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountAR) as total'))->where('a_r_s.codeCurrency', $currency)->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($ARs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('ARs','since','until','ARsTot','ARsTot2');
            $pdf = PDF::loadView('pdf.printARByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byCustomer(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $customer = $request->get('customer');
        $ARs = AR::where('codeCustomer', $customer)->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();
        
        $ARs = AR::join('sales', 'a_r_s.codeSale', '=', 'sales.id')->
        join('customers', 'a_r_s.codeCustomer', '=', 'customers.id')->
        join('payment_conditions', 'a_r_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_r_s.codeCurrency', '=', 'currencies.id')->
        join('banks', 'a_r_s.codeBank', '=', 'banks.id')->
        where('a_r_s.codeCustomer', $customer)
        ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $ARsTot = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountDocument) as total'))
                ->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
                ->where('a_r_s.codeCustomer', $customer)->get();

        $ARsTot2 = DB::table('a_r_s')
                ->select(DB::raw('SUM(amountAR) as total'))->where('a_r_s.codeCustomer', $customer)->whereRaw("(a_r_s.updated_at >= ? AND a_r_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($ARs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('ARs','since','until','ARsTot','ARsTot2');
            $pdf = PDF::loadView('pdf.printARByCustomer', $data);
            
            return $pdf->stream();
        }
    }
}
