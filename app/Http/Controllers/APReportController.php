<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\Provider;
use App\Models\AP;
use Illuminate\Support\Facades\DB;
use PDF;

class APReportController extends Controller
{
    public function index(Request $request)
    {
    	$banks = Bank::all();
    	$currencies = Currency::all();
    	$providers = Provider::all();
        return view('APReport')->with('banks', $banks)->with('currencies', $currencies)->with('providers', $providers);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $APs = AP::join('purchases', 'a_p_s.codePurchase', '=', 'purchases.id')->
        join('providers', 'a_p_s.codeProvider', '=', 'providers.id')->
        join('payment_conditions', 'a_p_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_p_s.codeCurrency', '=', 'currencies.id')
        ->
        join('banks', 'a_p_s.codeBank', '=', 'banks.id')
        ->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountDocument) as total'))->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot2 = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountAP) as total'))->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($APs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('APs','since','until','APsTot','APsTot2');
            $pdf = PDF::loadView('pdf.printAPByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byBank(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $bank = $request->get('bank');
        //$APs = AP::where('codeBank', $bank)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APs = AP::join('purchases', 'a_p_s.codePurchase', '=', 'purchases.id')->
        join('providers', 'a_p_s.codeProvider', '=', 'providers.id')->
        join('payment_conditions', 'a_p_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_p_s.codeCurrency', '=', 'currencies.id')
        ->join('banks', 'a_p_s.codeBank', '=', 'banks.id')
        ->where('a_p_s.codeBank', $bank)
        ->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountDocument) as total'))->where('a_p_s.codeBank', $bank)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot2 = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountAP) as total'))->where('a_p_s.codeBank', $bank)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($APs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('APs','since','until','APsTot','APsTot2');
            $pdf = PDF::loadView('pdf.printAPByBank', $data);
            
            return $pdf->stream();
        }
    }

    public function byCurrency(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $currency = $request->get('currency');
        
        /*$APs = AP::where('codeCurrency', $currency)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $currency = Currency::where('id', $currency)->get();
        
        $codePurchase = AP::join('purchases', 'a_p_s.codePurchase', '=', 'purchases.id')->where('codeCurrency', $currency)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();
        
        $data = compact('APs', 'since', 'until', 'currency', 'codePurchase');
        
        $pdf = PDF::loadView('pdf.printAPByCurrency', $data);
        
        return $pdf->stream();*/

        $APs = AP::join('purchases', 'a_p_s.codePurchase', '=', 'purchases.id')->
        join('providers', 'a_p_s.codeProvider', '=', 'providers.id')->
        join('payment_conditions', 'a_p_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_p_s.codeCurrency', '=', 'currencies.id')
        ->join('banks', 'a_p_s.codeBank', '=', 'banks.id')
        ->where('a_p_s.codeCurrency', $currency)
        ->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountDocument) as total'))->where('a_p_s.codeCurrency', $currency)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot2 = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountAP) as total'))->where('a_p_s.codeCurrency', $currency)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($APs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('APs','since','until','APsTot','APsTot2');
            $pdf = PDF::loadView('pdf.printAPByCurrency', $data);
            
            return $pdf->stream();
        }

    }

    public function byProvider(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $provider = $request->get('provider');
        //$APs = AP::where('codeProvider', $provider)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();
        $APs = AP::join('purchases', 'a_p_s.codePurchase', '=', 'purchases.id')->
        join('providers', 'a_p_s.codeProvider', '=', 'providers.id')->
        join('payment_conditions', 'a_p_s.codePayment', '=', 'payment_conditions.id')->
        join('currencies', 'a_p_s.codeCurrency', '=', 'currencies.id')
        ->join('banks', 'a_p_s.codeBank', '=', 'banks.id')
        ->where('a_p_s.codeProvider', $provider)
        ->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountDocument) as total'))->where('a_p_s.codeProvider', $provider)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        $APsTot2 = DB::table('a_p_s')
                ->select(DB::raw('SUM(amountAP) as total'))->where('a_p_s.codeProvider', $provider)->whereRaw("(a_p_s.updated_at >= ? AND a_p_s.updated_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();     

        if (count($APs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('APs','since','until','APsTot','APsTot2');
            $pdf = PDF::loadView('pdf.printAPByProvider', $data);
            
            return $pdf->stream();
        }
    }
}
