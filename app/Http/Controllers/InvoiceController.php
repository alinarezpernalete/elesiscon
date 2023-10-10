<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Provider;
use App\Models\PaymentCondition;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\AP;
use PDF;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $providers = Provider::all();
        $paymentConditions = PaymentCondition::all();
        $invoices = DB::table('purchases')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->select('purchases.id', 'purchases.codePurchase', 'providers.nameProvider', 'payment_conditions.namePayment', 'purchases.descriptionPurchase', 'purchases.typePurchase', 'users.name', 'purchases.created_at')->orderBy('id', 'DESC')->paginate(10);

        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");
        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $invoices = DB::table('purchases')
            ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
            ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
            ->join('users', 'purchases.userPurchase', '=', 'users.id')
            ->select('purchases.id', 'purchases.codePurchase', 'providers.nameProvider', 'payment_conditions.namePayment', 'purchases.typePurchase', 'purchases.descriptionPurchase', 'users.name', 'purchases.created_at')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'DESC')->paginate(10);

            return view('invoice')->with('providers', $providers)->with('paymentConditions', $paymentConditions)->with('invoices', $invoices)->with('search', $search);
        }
     
    	return view('invoice')->with('invoices', $invoices)->with('providers', $providers)->with('paymentConditions', $paymentConditions)->with('search', $search);
    }

    public function selectReceiptNote(Request $request)
    {
        $codePurchase = $request->get('codePurchase');

        $receiptNote = DB::table('purchases')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->select('purchases.id', 'purchases.codePurchase', 'purchases.providerPurchase', 'purchases.paymentPurchase', 'purchases.descriptionPurchase', 'users.name', 'purchases.created_at')
        ->where('codePurchase', $codePurchase)->get();

        return $receiptNote;
    }

    public function loadArticles(Request $request)
    {
        $idPurchase = $request->get('idPurchase');

        $receiptNote = DB::table('purchase_details')
        ->join('articles', 'purchase_details.codeArticle', '=', 'articles.id')
        ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'purchase_details.amountArticle', 'purchase_details.unitPriceArticle', 'purchase_details.pendingAmountArticle')
        ->where('codePurchase', $idPurchase)->get();

        $sum = DB::select('SELECT sum(unitPriceArticle*amountArticle) as sum FROM purchase_details WHERE codePurchase = '. $idPurchase);

        return response()->json(['success'=>$receiptNote, 'success2'=>$sum]);

        //return $receiptNote;
    }

    public function saveInvoice(Request $request)
    {
        $idPurchase = $request->get('idPurchase');

        $updateTypePurchase = Purchase::where('id', $idPurchase)
           ->update(['typePurchase' => 3, 'invoiceDatePurchase' => now()]);
        $updateDetails = PurchaseDetail::where('codePurchase', $idPurchase)
           ->update(['invoicePurchase' => 1]);

        ////////////////////////////////////////

        //return $updateTypePurchase;

        if ($updateTypePurchase == 1) {
            $select = DB::table('purchase_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codePurchase', $idPurchase)->get();
            $purchase = DB::table('purchases')
                ->select('purchases.providerPurchase', 'purchases.paymentPurchase')
                ->where('id', $idPurchase)->get();

            $codeAPType = '1';
            $codeCurrency = '1';
            $codeBank = '1';

            $newAP = new AP();
            $newAP->codePurchase = $idPurchase;
            $newAP->codeAPType = $codeAPType;
            $newAP->codeProvider = $purchase[0]->providerPurchase;
            $newAP->codePayment = $purchase[0]->paymentPurchase;
            $newAP->codeCurrency = $codeCurrency;
            $newAP->codeBank = $codeBank;
            $newAP->amountDocument = $select[0]->total;
            $newAP->amountAP = $select[0]->total;
            $newAP->save();

            return $updateTypePurchase;
        }
    }

    public function print(Request $request)
    {
        $idPurchase = $request->get('idPurchase');
        
        $invoice = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
                            ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
                            ->join('users', 'purchases.userPurchase', '=', 'users.id')->find($idPurchase);
        
        $invoiceDat = Purchase::where('id', $idPurchase)->get();

        $invoiceDet = PurchaseDetail::join('articles', 'purchase_details.codeArticle', '=', 'articles.id')->where('codePurchase', $idPurchase)->get();

        $invoiceTot = DB::table('purchase_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codePurchase', $idPurchase)->get();
        
        $data = compact('invoice', 'invoiceDet', 'invoiceDat', 'invoiceTot');
        
        $pdf = PDF::loadView('pdf.printInvoice', $data);
        
        return $pdf->stream();
    }
}
