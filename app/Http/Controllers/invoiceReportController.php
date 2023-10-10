<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Purchase;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use PDF;

class invoiceReportController extends Controller
{
    public function index(Request $request)
    {
    	$users = User::all();
    	$providers = Provider::all();
        return view('invoiceReport')->with('users', $users)->with('providers', $providers);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        /*$invoices = Purchase::join('users', 'purchases.userPurchase', '=', 'users.id')
        		->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        $invoices = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.invoiceDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.invoiceDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $invoicesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($invoices) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('invoices','invoicesTotal','since','until');
            $pdf = PDF::loadView('pdf.printInvoiceByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byUser(Request $request)
    {
        $user = $request->get('user');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$invoices = Purchase::join('users', 'purchases.userPurchase', '=', 'users.id')
        		->where('userPurchase', $user)
        		->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $invoices = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.invoiceDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->where('userPurchase', $user)
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.invoiceDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $invoicesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->where('userPurchase', $user)
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($invoices) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('invoices','invoicesTotal','since','until');
            $pdf = PDF::loadView('pdf.printInvoiceByUser', $data);
            
            return $pdf->stream();
        }
    }

    public function byProvider(Request $request)
    {
        $provider = $request->get('provider');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$invoices = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        		->where('providerPurchase', $provider)
        		->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $invoices = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.invoiceDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->where('providerPurchase', $provider)
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.invoiceDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $invoicesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->where('providerPurchase', $provider)
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($invoices) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('invoices','invoicesTotal','since','until');
            $pdf = PDF::loadView('pdf.printInvoiceByProvider', $data);
            
            return $pdf->stream();
        }
    }

    public function byCancel(Request $request)
    {
        $typePurchase = $request->get('typePurchase');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$invoices = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        		->where('typePurchase', $typePurchase)
        		->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $invoices = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.invoiceDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->where('typePurchase', $typePurchase)
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.invoiceDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $invoicesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->where('typePurchase', $typePurchase)
        ->whereRaw("(purchases.invoiceDatePurchase >= ? AND purchases.invoiceDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($invoices) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('invoices','invoicesTotal','since','until');
            $pdf = PDF::loadView('pdf.printInvoiceByCancel', $data);
            
            return $pdf->stream();
        }
    }
}