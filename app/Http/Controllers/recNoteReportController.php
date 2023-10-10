<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Purchase;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use PDF;

class recNoteReportController extends Controller
{
    public function index(Request $request)
    {
    	$users = User::all();
    	$providers = Provider::all();
        return view('recNoteReport')->with('users', $users)->with('providers', $providers);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        /*$recNotes = Purchase::join('users', 'purchases.userPurchase', '=', 'users.id')
        		->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/

        $recNotes = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.recNoteDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.recNoteDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $recNotesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();

        if (count($recNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('recNotes','recNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printRecNoteByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byUser(Request $request)
    {
        $user = $request->get('user');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$recNotes = Purchase::join('users', 'purchases.userPurchase', '=', 'users.id')
        		->where('userPurchase', $user)
        		->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $recNotes = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.recNoteDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('userPurchase', $user)
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.recNoteDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $recNotesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('userPurchase', $user)->get();

        if (count($recNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('recNotes','recNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printRecNoteByUser', $data);
            
            return $pdf->stream();
        }
    }

    public function byProvider(Request $request)
    {
        $provider = $request->get('provider');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$recNotes = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        		->where('providerPurchase', $provider)
        		->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        $recNotes = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.recNoteDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('providerPurchase', $provider)
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.recNoteDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $recNotesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('providerPurchase', $provider)->get();

        if (count($recNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('recNotes','recNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printRecNoteByProvider', $data);
            
            return $pdf->stream();
        }
    }

    public function byCancel(Request $request)
    {
        $typePurchase = $request->get('typePurchase');
        $since = $request->get('since');
        $until = $request->get('until');
        /*$recNotes = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        		->where('typePurchase', $typePurchase)
        		->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])->get();*/
        
        $recNotes = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->select(DB::raw('purchases.codePurchase, payment_conditions.namePayment, purchases.descriptionPurchase, purchases.recNoteDatePurchase, users.name, providers.nameProvider, providers.codeProvider, (case when COUNT(purchases.codePurchase) >= 1 then sum(unitpricearticle) end) as unitpricearticle'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('typePurchase', $typePurchase)
        ->groupBy('purchases.codePurchase', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.recNoteDatePurchase', 'users.name', 'providers.nameProvider', 'providers.codeProvider')
        ->havingRaw('COUNT(purchases.codePurchase) >= 1')->get();

        $recNotesTotal = DB::table('purchase_details')
        ->join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
        ->select(DB::raw('SUM(unitPriceArticle) as total'))
        ->whereRaw("(purchases.recNoteDatePurchase >= ? AND purchases.recNoteDatePurchase <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->where('typePurchase', $typePurchase)->get();

        if (count($recNotes) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('recNotes','recNotesTotal','since','until');
            $pdf = PDF::loadView('pdf.printRecNoteByCancel', $data);
            
            return $pdf->stream();
        }
    }
}
