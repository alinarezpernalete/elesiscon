<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Purchase;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use PDF;

class POReportController extends Controller
{
    public function index(Request $request)
    {
    	$users = User::all();
    	$providers = Provider::all();
        return view('POReport')->with('users', $users)->with('providers', $providers);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        /*$POs = Purchase::join('users', 'purchases.userPurchase', '=', 'users.id')
        		->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        $POs = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.PODatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.PODatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $POsTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($POs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('POs','POsTotal','since','until');
            $pdf = PDF::loadView('pdf.printPOByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byUser(Request $request)
    {
        $user = $request->get('user');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$POs = Purchase::join('users', 'purchases.userPurchase', '=', 'users.id')
        		->where('userPurchase', $user)
        		->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $POs = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.PODatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->where('userPurchase', $user)
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.PODatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $POsTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->where('userPurchase', $user)
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($POs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('POs','POsTotal','since','until');
            $pdf = PDF::loadView('pdf.printPOByUser', $data);
            
            return $pdf->stream();
        }
    }

    public function byProvider(Request $request)
    {
        $provider = $request->get('provider');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$POs = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        		->where('providerPurchase', $provider)
        		->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $POs = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.PODatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->where('providerPurchase', $provider)
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.PODatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $POsTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->where('providerPurchase', $provider)
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($POs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('POs','POsTotal','since','until');
            $pdf = PDF::loadView('pdf.printPOByProvider', $data);
            
            return $pdf->stream();
        }
    }

    public function byCancel(Request $request)
    {
        $typePurchase = $request->get('typePurchase');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$POs = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        		->where('typePurchase', $typePurchase)
        		->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $POs = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.PODatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->where('typePurchase', $typePurchase)
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.PODatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $POsTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->where('typePurchase', $typePurchase)
        ->whereRaw("(purchases.PODatePurchase >= ? AND purchases.PODatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($POs) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('POs','POsTotal','since','until');
            $pdf = PDF::loadView('pdf.printPOByProvider', $data);
            
            return $pdf->stream();
        }
    }
}
