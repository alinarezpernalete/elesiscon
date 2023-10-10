<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Provider;
use App\Models\PaymentCondition;
use App\Models\PurchaseDetail;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Price;
use PDF;

class PurchaseController extends Controller
{

    public function index(Request $request)
    {
    	$paymentConditions = PaymentCondition::all();
        $providers = Provider::all();
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        $articles = DB::table('articles')
        ->join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')
        ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'articles.modelArticle', 'articles.referenceArticle', 'articles.weightArticle', 'articles.locationArticle', 'lines.nameLine', 'sublines.nameSubline', 'groups.nameGroup', 'origins.nameOrigin', 'types.nameType', 'providers.nameProvider', 'articles.created_at', 'articles.statusArticle')->where('articles.statusArticle', 1)->paginate(10);

        // ----------------------------------------------------------------------------------------------------------  //

        $purchaseOrders = DB::table('purchases')
        ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
        ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
        ->join('users', 'purchases.userPurchase', '=', 'users.id')
        ->select('purchases.id', 'purchases.codePurchase', 'providers.nameProvider', 'payment_conditions.namePayment', 'purchases.typePurchase', 'purchases.descriptionPurchase', 'users.name', 'purchases.created_at')->orderBy('id', 'DESC')->paginate(10);

        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $purchaseOrders = DB::table('purchases')
            ->join('providers', 'purchases.providerPurchase', '=', 'providers.id')
            ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
            ->join('users', 'purchases.userPurchase', '=', 'users.id')
            ->select('purchases.id', 'purchases.codePurchase', 'providers.nameProvider', 'payment_conditions.namePayment', 'purchases.typePurchase', 'purchases.descriptionPurchase', 'users.name', 'purchases.created_at')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'DESC')->paginate(10);

            return view('purchaseOrder')->with('providers', $providers)->with('paymentConditions', $paymentConditions)->with('purchaseOrders', $purchaseOrders)->with('articles', $articles)->with('search', $search);
        }
        
        return view('purchaseOrder')->with('paymentConditions', $paymentConditions)->with('providers', $providers)->with('articles', $articles)->with('purchaseOrders', $purchaseOrders)->with('search', $search);
    }

    public function checkProvider(Request $request)
    {
        $newProvider = new Provider();
        $newProvider->codeProvider = $request->codeProvider;
        $newProvider->nameProvider = $request->nameProvider;
        $newProvider->addressProvider = $request->addressProvider;
        $newProvider->phoneProvider = $request->phoneProvider;
        $newProvider->emailProvider = $request->emailProvider;
        $newProvider->statusProvider = 1;
        $newProvider->save();
        return $newProvider;
    }

    public function findDetail(Request $request)
    {
        $idPurchase = $request->get('idPurchase');
        
        $idDetail = DB::table('purchase_details')
            ->join('articles', 'purchase_details.codeArticle', '=', 'articles.id')
            ->select('purchase_details.id', 'articles.codeArticle', 'articles.nameArticle', 'purchase_details.amountArticle', 
                'purchase_details.pendingAmountArticle', 'purchase_details.unitPriceArticle')
            ->where('codePurchase', $idPurchase)->get();

        $sum = DB::select('SELECT sum(unitPriceArticle*amountArticle) as sum FROM purchase_details WHERE codePurchase = '. $idPurchase);

        //return $idDetail;
        return response()->json(['success'=>$idDetail, 'success2'=>$sum]);
    }

    public function cancelDetail(Request $request)
    {
        $idPurchase = $request->get('idPurchase');
        
        $updatePurchase = Purchase::where('id', $idPurchase)
            ->update(['typePurchase' => 4]);

        return $updatePurchase;
    }

    public function selectArticle(Request $request)
    {
        $input = $request->all();
        \Log::info($input);
        
        $articles = DB::table('articles')
        ->join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')
        ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'articles.modelArticle', 'articles.referenceArticle', 'articles.weightArticle', 'articles.locationArticle', 'lines.nameLine', 'sublines.nameSubline', 'groups.nameGroup', 'origins.nameOrigin', 'types.nameType', 'providers.nameProvider', 'articles.created_at')->where('codeArticle', $input)->where('articles.statusArticle', 1)->first();
        
        if ($articles != ""){
            $id = DB::table('articles')
            ->select('articles.id')->where('codeArticle', $input)->get();

            $idForTwo = $id[0]->id;

            $currentPrice = DB::table('prices')
            ->select('prices.currentPrice')->where('codePrice', $idForTwo)->get();
            $currentStock = DB::table('stocks')
            ->select('stocks.currentStock')->where('codeStock', $idForTwo)->get();
            
            return response()->json(['success'=>$articles, 'success2'=>$currentPrice, 'success3'=>$currentStock]);

            //return response()->json(['success'=>$articles]);
        } else {
            return "No hay";
        }

    }

    public function addArticle(Request $request)
    {
        $idArticle = $request->get('idArticle');
        $amountArticle = $request->get('amountArticle');
        $unitPriceArticle = $request->get('unitPriceArticle');
            
        // --------------------------------------------------------- //

        if ($amountArticle <= 0) {
            return '0';
        } else {

            $currentArriveStock = DB::table('stocks')
            ->select('arriveStock')
            ->where('codeStock', $idArticle)->get();

            if ($currentArriveStock[0]->arriveStock >= 0) {
                $newPurchaseDetail = new PurchaseDetail();
                $newPurchaseDetail->codeArticle = $idArticle;
                $newPurchaseDetail->amountArticle = $amountArticle;
                $newPurchaseDetail->unitPriceArticle = $unitPriceArticle;
                $newPurchaseDetail->pendingAmountArticle = $amountArticle;
                $newPurchaseDetail->POPurchase = '1';
                
                $newPurchaseDetail->save();   

                // --------------------------------------------------------- //

                $newArriveStock = $currentArriveStock[0]->arriveStock + $amountArticle;

                $updateArriveStock = Stock::where('codeStock', $idArticle)
                    ->update(['arriveStock' => $newArriveStock]);

                if ($updateArriveStock == 1) {
                    $updatePrice = Price::where('codePrice', $idArticle)
                    ->update(['currentPrice' => $unitPriceArticle]); 

                    /*if ($updatePrice == 1) {*/
                        /*$idDetail = DB::table('purchase_details')
                            ->select('purchase_details.id')
                            ->where('codeArticle', $idArticle)
                            ->where('amountArticle', $amountArticle)
                            ->where('unitPriceArticle', $unitPriceArticle)->get();*/

                        $idDetail = PurchaseDetail::where('codeArticle', $idArticle)
                            ->where('amountArticle', $amountArticle)
                            ->where('unitPriceArticle', $unitPriceArticle)->orderBy('id', 'DESC')->first();

                        return response()->json(['success'=>$idDetail]);
                    /*}*/
                }
            }

        }
    }

    public function deleteArticle(Request $request)
    {
        $idDetail = $request->get('idDetail');
        $idArticle = $request->get('idArticle');
        $amountArticle = $request->get('amountArticle');
        $unitPriceArticle = $request->get('unitPriceArticle');

        // --------------------------------------------------------- //     

        $deletedDetail = DB::table('purchase_details')->where('id', '=', $idDetail)->delete();

        // --------------------------------------------------------- //  

        $arriveStock = DB::table('stocks')
        ->select('stocks.arriveStock')
        ->where('codeStock', $idArticle)
        //->where('arriveStock', $amountArticle)
        ->get();

        $deletedStock = $arriveStock[0]->arriveStock - $amountArticle;

        $updateStock = Stock::where('codeStock', $idArticle)
            ->update(['arriveStock' => $deletedStock]);

        // --------------------------------------------------------- //  

        /*$currentPrice = DB::table('prices')
        ->select('prices.currentPrice')
        ->where('codePrice', $idArticle)
        ->where('currentPrice', $unitPriceArticle)
        ->get();

        $deletedPrice = $currentPrice[0]->currentPrice - $unitPriceArticle;

        $updatePrice = Price::where('codePrice', $idArticle)
            ->update(['currentPrice' => $deletedPrice]);*/

        // --------------------------------------------------------- //  

        return response()->json(['success'=>'Deleted detail, stock and price']);
    }

    public function store(Request $request)
    {
        $typePurchase = '1';

        $newPurchaseOrder = new Purchase();
        $newPurchaseOrder->codePurchase = $request->codePurchase;
        $newPurchaseOrder->providerPurchase = $request->providerPurchase;
        $newPurchaseOrder->paymentPurchase = $request->paymentPurchase;
        $newPurchaseOrder->descriptionPurchase = $request->descriptionPurchase;
        $newPurchaseOrder->typePurchase = $typePurchase;
        $newPurchaseOrder->userPurchase = $request->userPurchase;
        $newPurchaseOrder->PODatePurchase = now();
        $newPurchaseOrder->save();

        // ----------------------------------------------------------------------- //

        /*$idPurchase = Purchase::get('id')->last();

        $updateDetail = PurchaseDetail::where('codePurchase', NULL)
            ->update(['codePurchase' => $idPurchase->id]);
        
        return $updateDetail;*/

        $idPurchase = Purchase::orderBy('id', 'DESC')->first();

        $updateDetail = PurchaseDetail::where('codePurchase', NULL)
            ->update(['codePurchase' => $idPurchase->id]);
        
        return $updateDetail;
    }

    public function print(Request $request)
    {
        $idPurchase = $request->get('idPurchase');
        
        $purchaseOrder = Purchase::join('providers', 'purchases.providerPurchase', '=', 'providers.id')
                            ->join('payment_conditions', 'purchases.paymentPurchase', '=', 'payment_conditions.id')
                            ->join('users', 'purchases.userPurchase', '=', 'users.id')->find($idPurchase);
        
        $purchaseDat = Purchase::where('id', $idPurchase)->get();

        $purchaseDet = PurchaseDetail::join('articles', 'purchase_details.codeArticle', '=', 'articles.id')->where('codePurchase', $idPurchase)->get();

        $purchaseTot = DB::table('purchase_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codePurchase', $idPurchase)->get();
        
        $data = compact('purchaseOrder', 'purchaseDet', 'purchaseDat', 'purchaseTot');
        
        $pdf = PDF::loadView('pdf.printPurchaseOrder', $data);
        
        return $pdf->stream();
    }

    public function deleteOnUnload(Request $request)
    {
        $infoDetail = DB::table('purchase_details')->where('codePurchase', NULL)->get();

        $i = (count($infoDetail))-1;
        while ($i >= 0) {
            echo $infoDetail[$i]->codeArticle;
            echo $infoDetail[$i]->amountArticle;
            
            $arriveStock = DB::table('stocks')
                ->select('stocks.arriveStock')
                ->where('codeStock', $infoDetail[$i]->codeArticle)
                ->get();
            
            $deletedStock = $arriveStock[0]->arriveStock - $infoDetail[$i]->amountArticle;

            $updateStock = Stock::where('codeStock', $infoDetail[$i]->codeArticle)
                ->update(['arriveStock' => $deletedStock]);  

            /*$currentStock = DB::table('stocks')
                ->select('stocks.currentStock')
                ->where('codeStock', $infoDetail[$i]->codeArticle)
                ->get();

            $newCurrentStock = $currentStock[0]->currentStock + $infoDetail[$i]->amountArticle;

            $updateStock = Stock::where('codeStock', $infoDetail[$i]->codeArticle)
                ->update(['currentStock' => $newCurrentStock]);  */
            
            $i--;
        }

        $deletedDetail = DB::table('purchase_details')->where('codePurchase', NULL)->delete();
        return $deletedDetail;

    }
}
