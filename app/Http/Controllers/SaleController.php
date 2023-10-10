<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\PaymentCondition;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Sale;
use PDF;

class SaleController extends Controller
{
    public function index(Request $request)
    {
    	$customers = Customer::all();
    	$paymentConditions = PaymentCondition::all();
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

    	$saleOrders = DB::table('sales')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->orderBy('id', 'DESC')->paginate(10);

        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $saleOrders = DB::table('sales')
                ->join('customers', 'sales.customerSale', '=', 'customers.id')
                ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                ->join('users', 'sales.userSale', '=', 'users.id')
                ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->paginate(10);

            return view('saleOrder')->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('saleOrders', $saleOrders)->with('search', $search);
        }

    	return view('saleOrder')->with('saleOrders', $saleOrders)->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('search', $search);
    }

    public function selectQuotation(Request $request)
    {
    	$codeSale = $request->get('codeSale');

    	$saleOrder = DB::table('sales')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->select('sales.id', 'sales.codeSale', 'sales.customerSale', 'sales.paymentSale', 'sales.descriptionSale', 'users.name', 'sales.created_at')->where('codeSale', $codeSale)->get();

    	return $saleOrder;
    }

    public function loadArticles(Request $request)
    {
    	$idSale = $request->get('idSale');

    	$saleOrder = DB::table('sale_details')
    	->join('articles', 'sale_details.codeArticle', '=', 'articles.id')
    	->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'sale_details.codeSale', 'sale_details.amountArticle', 'sale_details.unitPriceArticle', 'sale_details.created_at')
        ->where('codeSale', $idSale)->get();

        $sum = DB::select('SELECT sum(unitPriceArticle*amountArticle) as sum FROM sale_details WHERE codeSale = '. $idSale);

        return response()->json(['success'=>$saleOrder, 'success2'=>$sum]);

    	//return $saleOrder;
    }

    public function confirmStock(Request $request)
    {
    	$inputStock = $request->get('inputStock');
    	$idArticle = $request->get('idArticle');
        $created_at = $request->get('created_at');
        //13621
        $idSale = $request->get('idSale');

        $saleOrder = DB::table('sale_details')
        ->select('sale_details.amountArticle')
        ->where('created_at', $created_at)->get();

        if ($inputStock > $saleOrder[0]->amountArticle) {
            $currentStock = DB::table('stocks')
            ->select('currentStock')
            ->where('codeStock', $idArticle)->get();   
            if ($inputStock > $currentStock[0]->currentStock){
                return "Input mayor";
            } else {
                $updateSaleOrder3 = SaleDetail::where('created_at', $created_at)
                ->update(['amountArticle' => $inputStock]);
                $updateSaleOrder4 = SaleDetail::where('created_at', $created_at)
                ->update(['pendingAmountArticle' => $inputStock]);

                // --------------------------------------------- //

                if ($updateSaleOrder4 >= 1) {
                    $committedStock = DB::table('stocks')
                    ->select('committedStock')
                    ->where('codeStock', $idArticle)->get();
                    // ************************************************* //
                    $lessCommitted = $committedStock[0]->committedStock - $inputStock;
                    // ************************************************* //
                    $currentStock = DB::table('stocks')
                    ->select('currentStock')
                    ->where('codeStock', $idArticle)->get();
                    // ************************************************* //
                    $toCurrent = $currentStock[0]->currentStock - (-$lessCommitted);
                    // ************************************************* //
                    $updateCurrentStock = Stock::where('codeStock', $idArticle)
                    ->update(['currentStock' => $toCurrent]);
                    // ************************************************* //
                    $newCommitted = $committedStock[0]->committedStock + (-$lessCommitted);
                    // ************************************************* //
                    $updateCommittedStock = Stock::where('codeStock', $idArticle)
                    ->update(['committedStock' => $newCommitted]);
                    ///13621
                    //$infoDetail = DB::table('sale_details')->where('codeSale', $idSale)->get();
                    //$i = (count($infoDetail))-1;
                    //while ($i >= 0) {
                        $updateSOSale = SaleDetail::where('created_at', $created_at)
                            ->update(['SOSale' => 1]);  
                        //$i--;
                    //}
                    return $updateCommittedStock;
                }
            }
        } else {
            if ($inputStock < $saleOrder[0]->amountArticle) {
                $updateSaleOrder = SaleDetail::where('created_at', $created_at)
                ->update(['amountArticle' => $inputStock]);
                $updateSaleOrder2 = SaleDetail::where('created_at', $created_at)
                ->update(['pendingAmountArticle' => $inputStock]);

                // --------------------------------------------- //

                if ($updateSaleOrder2 >= 1) {
                    $committedStock = DB::table('stocks')
                    ->select('committedStock')
                    ->where('codeStock', $idArticle)->get();
                    // ************************************************* //
                    $lessCommitted = $committedStock[0]->committedStock - $inputStock;
                    // ************************************************* //
                    $currentStock = DB::table('stocks')
                    ->select('currentStock')
                    ->where('codeStock', $idArticle)->get();
                    // ************************************************* //
                    $toCurrent = $currentStock[0]->currentStock + $lessCommitted;
                    // ************************************************* //
                    $updateCurrentStock = Stock::where('codeStock', $idArticle)
                    ->update(['currentStock' => $toCurrent]);
                    // ************************************************* //
                    $newCommitted = $committedStock[0]->committedStock - $lessCommitted;
                    // ************************************************* //
                    $updateCommittedStock = Stock::where('codeStock', $idArticle)
                    ->update(['committedStock' => $newCommitted]);
                    ///13621
                    ///13621
                    //$infoDetail = DB::table('sale_details')->where('codeSale', $idSale)->get();
                    //$i = (count($infoDetail))-1;
                    //while ($i >= 0) {
                        $updateSOSale = SaleDetail::where('created_at', $created_at)
                            ->update(['SOSale' => 1]);  
                        //$i--;
                    //}
                    return $updateCommittedStock;
                }
            } else {

                if ($inputStock == $saleOrder[0]->amountArticle) {
                    ///13621
                    //$infoDetail = DB::table('sale_details')->where('codeSale', $idSale)->get();
                    //$i = (count($infoDetail))-1;
                    //while ($i >= 0) {
                        $updateSOSale = SaleDetail::where('created_at', $created_at)
                            ->update(['SOSale' => 1]);  
                        //$i--;
                    //}
                    return "normal";
                }

            }
        }
    }

    public function deleteDetail(Request $request)
    {
        $created_at = $request->get('created_at');
        $amountArticle = $request->get('amountArticle');
        $idArticle = $request->get('idArticle');

        // --------------------------------------------------------- //     

        $deletedDetail = DB::table('sale_details')->where('created_at', '=', $created_at)->delete();

        // --------------------------------------------------------- //  

        $committedStock = DB::table('stocks')
        ->select('stocks.committedStock')
        ->where('codeStock', $idArticle)
        ->get();

        $deletedStock = $committedStock[0]->committedStock - $amountArticle;

        $updateStock = Stock::where('codeStock', $idArticle)
            ->update(['committedStock' => $deletedStock]);  

        // --------------------------------------------------------- //  

        $currentStock = DB::table('stocks')
        ->select('stocks.currentStock')
        ->where('codeStock', $idArticle)
        ->get();

        $newCurrentStock = $currentStock[0]->currentStock + $amountArticle;

        $updateStock = Stock::where('codeStock', $idArticle)
            ->update(['currentStock' => $newCurrentStock]);  

        // --------------------------------------------------------- // 

        return response()->json(['success'=>'Deleted detail and spare stock']);

    }

    public function deleteQuotation(Request $request)
    {
        $codeSale = $request->get('codeSale');

        // --------------------------------------------------------- //     

        $deleteQuotation = DB::table('sales')->where('codeSale', '=', $codeSale)->delete();

        return response()->json(['success'=>$deleteQuotation]);
    }

    public function saveSaleOrder(Request $request)
    {
    	$idSale = $request->get('idSale');

        $updateSale = Sale::where('id', $idSale)
            ->update(['typeSale' => 2, 'SODateSale' => now()]); 

    	return $updateSale;
    }

    public function print(Request $request)
    {
        $idSale = $request->get('idSale');
        
        $saleOrder = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
                            ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                            ->join('users', 'sales.userSale', '=', 'users.id')->find($idSale);
        
        $saleDat = Sale::where('id', $idSale)->get();

        $saleDet = SaleDetail::join('articles', 'sale_details.codeArticle', '=', 'articles.id')->where('codeSale', $idSale)->get();

        $saleTot = DB::table('sale_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codeSale', $idSale)->get();
        
        $data = compact('saleOrder', 'saleDet', 'saleDat', 'saleTot');
        
        $pdf = PDF::loadView('pdf.printSaleOrder', $data);
        
        return $pdf->stream();
    }

    public function deleteOnUnload(Request $request)
    {   
        $idSale = $request->get('idSale');
        
        $updateSale = SaleDetail::join('sales', 'sale_details.codeSale', '=', 'sales.id')
            ->where('sales.codeSale', $idSale)
            ->update(['SOSale' => NULL]);
        $idSale = SaleDetail::join('sales', 'sale_details.codeSale', '=', 'sales.id')
            ->where('sales.codeSale', $idSale)
            ->get();

        $i = 0;
        while ($i < (count($idSale)-1)) {
            $updateAmount = DB::update('update sale_details set pendingAmountArticle = amountArticle, SOSale = NULL where codeSale = '. $idSale[$i]->id);
            $i++;
        }

        return $updateAmount;
    }
}
