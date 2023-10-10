<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Provider;
use App\Models\PaymentCondition;
use App\Models\Stock;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use PDF;

class ReceiptNoteController extends Controller
{
    public function index(Request $request)
    {
		$paymentConditions = PaymentCondition::all();
        $providers = Provider::all();
    	$receiptNotes = DB::table('purchases')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->select('purchases.id', 'purchases.codePurchase', 'providers.nameProvider', 'payment_conditions.namePayment', 'purchases.typePurchase', 'purchases.descriptionPurchase', 'users.name', 'purchases.created_at')->orderBy('id', 'DESC')->paginate(10);

        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");
        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $receiptNotes = DB::table('purchases')
            ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
            ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
            ->join('users', 'purchases.userPurchase', '=', 'users.id')
            ->select('purchases.id', 'purchases.codePurchase', 'providers.nameProvider', 'payment_conditions.namePayment', 'purchases.typePurchase', 'purchases.descriptionPurchase', 'users.name', 'purchases.created_at')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'DESC')->paginate(10);

            return view('receiptNote')->with('providers', $providers)->with('paymentConditions', $paymentConditions)->with('receiptNotes', $receiptNotes)->with('search', $search);
        }
        
        return view('receiptNote')->with('receiptNotes', $receiptNotes)->with('paymentConditions', $paymentConditions)->with('providers', $providers)->with('search', $search);
    }

    public function selectPurchaseOrder(Request $request)
    {
    	$codePurchase = $request->get('codePurchase');

    	$purchaseOrder = DB::table('purchases')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->select('purchases.id', 'purchases.codePurchase', 'purchases.providerPurchase', 'purchases.paymentPurchase', 'purchases.descriptionPurchase', 'users.name', 'purchases.created_at')
        ->where('codePurchase', $codePurchase)->get();

    	return $purchaseOrder;
    }

    public function loadArticles(Request $request)
    {
    	$idPurchase = $request->get('idPurchase');

    	$purchaseOrder = DB::table('purchase_details')
    	->join('articles', 'purchase_details.codeArticle', '=', 'articles.id')
    	->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'purchase_details.amountArticle', 'purchase_details.unitPriceArticle', 'purchase_details.pendingAmountArticle', 'purchase_details.created_at')
        ->where('codePurchase', $idPurchase)->get();

        $sum = DB::select('SELECT sum(unitPriceArticle*amountArticle) as sum FROM purchase_details WHERE codePurchase = '. $idPurchase);

        return response()->json(['success'=>$purchaseOrder, 'success2'=>$sum]);

    	//return $purchaseOrder;
    }

    public function confirmStock(Request $request)
    {
    	$inputStock = $request->get('inputStock');
    	$idArticle = $request->get('idArticle');
        $created_at = $request->get('created_at');

        $pendingAmountArticle = DB::table('purchase_details')
            ->select('pendingAmountArticle')
            ->where('created_at', $created_at)->get();

        if ($pendingAmountArticle[0]->pendingAmountArticle > 0) {

            $newPendingAmountArticle = $pendingAmountArticle[0]->pendingAmountArticle - $inputStock;
            
            $updatePendingAmountArticle = PurchaseDetail::where('created_at', $created_at)
                ->update(['pendingAmountArticle' => $newPendingAmountArticle]); 

            // -------------------------------------------------------------------------------- //

            $currentArriveStock = DB::table('stocks')
                ->select('arriveStock')
                ->where('codeStock', $idArticle)->get();
            
            $newArriveStock = $currentArriveStock[0]->arriveStock - $inputStock;
            
            $updateArriveStock = Stock::where('codeStock', $idArticle)
                ->update(['arriveStock' => $newArriveStock]);

            if ($updateArriveStock == 1 || $updateArriveStock == '') {
                $currentStock = DB::table('stocks')
                    ->select('currentStock')
                    ->where('codeStock', $idArticle)->get();
                
                $newCurrentStock = $currentStock[0]->currentStock + $inputStock;
                
                $updateCurrentStock = Stock::where('codeStock', $idArticle)
                    ->update(['currentStock' => $newCurrentStock]); 

                //16621
                $updateReceiptNotePurchase = PurchaseDetail::where('created_at', $created_at)
                    ->update(['recNotePurchase' => 1]);  
                
                return $updateCurrentStock;
            }

        } 


    }

    public function cancelStock(Request $request)
    {
        $inputStock = $request->get('inputStock');
        $idArticle = $request->get('idArticle');
        $created_at = $request->get('created_at');

        $pendingAmountArticle = DB::table('purchase_details')
            ->select('pendingAmountArticle')
            ->where('created_at', $created_at)->get();

        if ($pendingAmountArticle[0]->pendingAmountArticle >= 0) {

            $newPendingAmountArticle = $pendingAmountArticle[0]->pendingAmountArticle + $inputStock;
            
            $updatePendingAmountArticle = PurchaseDetail::where('created_at', $created_at)
                ->update(['pendingAmountArticle' => $newPendingAmountArticle]); 

            // -------------------------------------------------------------------------------- //

            $currentArriveStock = DB::table('stocks')
                ->select('arriveStock')
                ->where('codeStock', $idArticle)->get();
            
            $newArriveStock = $currentArriveStock[0]->arriveStock + $inputStock;
            
            $updateArriveStock = Stock::where('codeStock', $idArticle)
                ->update(['arriveStock' => $newArriveStock]);

            if ($updateArriveStock == 1 || $updateArriveStock == '') {
                $currentStock = DB::table('stocks')
                    ->select('currentStock')
                    ->where('codeStock', $idArticle)->get();
                
                $newCurrentStock = $currentStock[0]->currentStock - $inputStock;
                
                $updateCurrentStock = Stock::where('codeStock', $idArticle)
                    ->update(['currentStock' => $newCurrentStock]); 
                
                return $updateCurrentStock;
            }

        } 
    }

    public function saveReceiptNote(Request $request)
    {
    	$idPurchase = $request->get('idPurchase');

        $amounts = DB::table('purchase_details')
            ->select('amountArticle', 'pendingAmountArticle')
            ->where('codePurchase', $idPurchase)->get();

        if ($amounts[0]->pendingAmountArticle == $amounts[0]->amountArticle || $amounts[0]->pendingAmountArticle > 0) {
            return '1';
        } else {

            if ($amounts[0]->pendingAmountArticle == 0) {
                
                $updatePurchase = Purchase::where('id', $idPurchase)
                    ->update(['typePurchase' => 2, 'recNoteDatePurchase' => now()]); 
                return '2';

            }

        }

    	//return $updatePurchase;
        //return redirect()->back();
    }

    public function print(Request $request)
    {
        $idPurchase = $request->get('idPurchase');
        
        $receiptNote = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
                            ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
                            ->join('users', 'purchases.userPurchase', '=', 'users.id')->find($idPurchase);
        
        $receiptDat = Purchase::where('id', $idPurchase)->get();

        $receiptDet = PurchaseDetail::join('articles', 'purchase_details.codeArticle', '=', 'articles.id')->where('codePurchase', $idPurchase)->get();

        $receiptTot = DB::table('purchase_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codePurchase', $idPurchase)->get();
        
        $data = compact('receiptNote', 'receiptDet', 'receiptDat', 'receiptTot');
        
        $pdf = PDF::loadView('pdf.printReceiptNote', $data);
        
        return $pdf->stream();
    }

    public function deleteOnUnload(Request $request)
    {   
        $codesArray = $request->get('codesArray');
        $y = 0;
        while ($y < (count($codesArray))) {
            /*echo $codesArray[$y];*/
            /*echo $idSale." "; <-anterior*/
            $updateSale = PurchaseDetail::join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
                ->where('purchases.codePurchase', $codesArray[$y])
                ->update(['recNotePurchase' => NULL]);
            /*echo $updateSale." ";*/
            $infoPurchase = PurchaseDetail::join('purchases', 'purchase_details.codePurchase', '=', 'purchases.id')
                ->where('purchases.codePurchase', $codesArray[$y])
                ->get();
            /*echo $infoPurchase." ";*/
            /*echo count($infoPurchase)." <-COUNT ";*/

            $i = 0;
            while ($i < (count($infoPurchase))) {
                /*echo $i." es menor que ".count($infoPurchase)." ";*/
                
                $updateAmount = DB::update('update purchase_details set pendingAmountArticle = amountArticle where codePurchase = '. $infoPurchase[$i]->id);
                
                /*if ($updateAmount == 0){ echo "no modifico nada, porque está igual en details "; } else { echo $updateAmount." "; }*/
                
                $select = DB::table('purchase_details')->whereNull('recNotePurchase')->where('codeArticle', $infoPurchase[$i]->codeArticle)->sum('pendingAmountArticle');
                
                /*echo "esto es la cant. de los no null de delnote: ".$select." ";*/
                
                $updateArriveStock = DB::update('update stocks set arriveStock = '.$select.' where codeStock = '. $infoPurchase[$i]->codeArticle);
                /*if ($updateArriveStock == 0){ echo "no modifico nada porque no hay cambios "; } else {echo $updateArriveStock." ";}*/

                $twoSelect = DB::table('purchase_details')->where('invoicePurchase', 1)->where('pendingAmountArticle', 0)->where('codeArticle', $infoPurchase[$i]->codeArticle)->sum('amountArticle');
                $threeSelect = DB::table('sale_details')->where('billSale', 1)->where('pendingAmountArticle', 0)->where('codeArticle', $infoPurchase[$i]->codeArticle)->sum('amountArticle');

                //echo "esto es la cant. de purchase_details: ".$twoSelect." ";
                //echo "esto es la cant. de sale_details: ".$threeSelect." ";

                $newCurrentStock = intval($twoSelect) - intval($threeSelect);

                $updateCurrentStock = DB::update('update stocks set currentStock = '.$newCurrentStock.' where codeStock = '. $infoPurchase[$i]->codeArticle);

                $i++;
                /*echo $i." ya no";*/
            }

            $y++;
        }
    }
}
