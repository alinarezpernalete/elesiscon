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

class DeliveryNoteController extends Controller
{
    public function index(Request $request)
    {
    	$customers = Customer::all();
    	$paymentConditions = PaymentCondition::all();
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");
        
        $deliveryNotes = DB::table('sales')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->orderBy('id', 'DESC')->paginate(10);
    	
        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $deliveryNotes = DB::table('sales')
                ->join('customers', 'sales.customerSale', '=', 'customers.id')
                ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                ->join('users', 'sales.userSale', '=', 'users.id')
                ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->paginate(10);

            return view('deliveryNote')->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('deliveryNotes', $deliveryNotes)->with('search', $search);
        }

    	return view('deliveryNote')->with('deliveryNotes', $deliveryNotes)->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('search', $search);
    }

    public function selectSaleOrder(Request $request)
    {
    	$codeSale = $request->get('codeSale');

    	$saleOrder = DB::table('sales')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->select('sales.id', 'sales.codeSale', 'sales.customerSale', 'sales.paymentSale', 'sales.descriptionSale', 'users.name', 'sales.created_at')
        ->where('codeSale', $codeSale)->get();

    	return $saleOrder;
    }

    public function loadArticles(Request $request)
    {
    	$idSale = $request->get('idSale');

    	$saleOrder = DB::table('sale_details')
    	->join('articles', 'sale_details.codeArticle', '=', 'articles.id')
    	->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'sale_details.amountArticle', 'sale_details.unitPriceArticle', 'sale_details.created_at', 'sale_details.pendingAmountArticle')
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

        $pendingAmountArticle = DB::table('sale_details')
            ->select('pendingAmountArticle')
            ->where('created_at', $created_at)->get();

        if ($pendingAmountArticle[0]->pendingAmountArticle > 0) {

            $newPendingAmountArticle = $pendingAmountArticle[0]->pendingAmountArticle - $inputStock;
            
            $updatePendingAmountArticle = SaleDetail::where('created_at', $created_at)
                ->update(['pendingAmountArticle' => $newPendingAmountArticle]); 

            // -------------------------------------------------------------------------------- //

            $committedStock = DB::table('stocks')
                ->select('committedStock')
                ->where('codeStock', $idArticle)->get();
            
            $newCommittedStock = $committedStock[0]->committedStock - $inputStock;
            
            $updateCommittedStock = Stock::where('codeStock', $idArticle)
                ->update(['committedStock' => $newCommittedStock]);

            if ($updateCommittedStock == 1 || $updateCommittedStock == '') {
                $dispatchStock = DB::table('stocks')
                    ->select('dispatchStock')
                    ->where('codeStock', $idArticle)->get();
                
                $newDispatchStock = $dispatchStock[0]->dispatchStock + $inputStock;
                
                $updateDispatchStock = Stock::where('codeStock', $idArticle)
                    ->update(['dispatchStock' => $newDispatchStock]); 

                /////////////////////////////////
                //13621
                $updateDelNoteSale = SaleDetail::where('created_at', $created_at)
                    ->update(['delNoteSale' => 1]);  
                
                return $updateDispatchStock;
            }

        } 


    }

    public function cancelStock(Request $request)
    {
        $inputStock = $request->get('inputStock');
        $idArticle = $request->get('idArticle');
        $created_at = $request->get('created_at');

        $pendingAmountArticle = DB::table('sale_details')
            ->select('pendingAmountArticle')
            ->where('created_at', $created_at)->get();

        if ($pendingAmountArticle[0]->pendingAmountArticle >= 0) {

            $newPendingAmountArticle = $pendingAmountArticle[0]->pendingAmountArticle + $inputStock;
            
            $updatePendingAmountArticle = SaleDetail::where('created_at', $created_at)
                ->update(['pendingAmountArticle' => $newPendingAmountArticle]); 

            // -------------------------------------------------------------------------------- //

            $committedStock = DB::table('stocks')
                ->select('committedStock')
                ->where('codeStock', $idArticle)->get();
            
            $newCommittedStock = $committedStock[0]->committedStock + $inputStock;
            
            $updateCommittedStock = Stock::where('codeStock', $idArticle)
                ->update(['committedStock' => $newCommittedStock]);

            if ($updateCommittedStock == 1 || $updateCommittedStock == '') {
                $dispatchStock = DB::table('stocks')
                    ->select('dispatchStock')
                    ->where('codeStock', $idArticle)->get();
                
                $newDispatchStock = $dispatchStock[0]->dispatchStock - $inputStock;
                
                $updateDispatchStock = Stock::where('codeStock', $idArticle)
                    ->update(['dispatchStock' => $newDispatchStock]); 
                
                return $updateDispatchStock;
            }

        } 
    }

    public function saveDeliveryNote(Request $request)
    {
        $idSale = $request->get('idSale');

        $amounts = DB::table('sale_details')
            ->select('amountArticle', 'pendingAmountArticle')
            ->where('codeSale', $idSale)->get();

        if ($amounts[0]->pendingAmountArticle == $amounts[0]->amountArticle || $amounts[0]->pendingAmountArticle > 0) {
            return '1';
        } else {

            if ($amounts[0]->pendingAmountArticle == 0) {
                
                $updatePurchase = Sale::where('id', $idSale)
                    ->update(['typeSale' => 3, 'delNoteDateSale' => now()]); 

                return '2';

            }

        }
    }

    public function print(Request $request)
    {
        $idSale = $request->get('idSale');
        
        $deliveryNote = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
                            ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                            ->join('users', 'sales.userSale', '=', 'users.id')->find($idSale);
        
        $deliveryDat = Sale::where('id', $idSale)->get();

        $deliveryDet = SaleDetail::join('articles', 'sale_details.codeArticle', '=', 'articles.id')->where('codeSale', $idSale)->get();

        $deliveryNoteTot = DB::table('sale_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codeSale', $idSale)->get();
        
        $data = compact('deliveryNote', 'deliveryDet', 'deliveryDat', 'deliveryNoteTot');
        
        $pdf = PDF::loadView('pdf.printDeliveryNote', $data);
        
        return $pdf->stream();
    }


    public function deleteOnUnload(Request $request)
    {   
        $codesArray = $request->get('codesArray');
        $y = 0;
        while ($y < (count($codesArray))) {
            /*echo $codesArray[$y];*/
            /*echo $idSale." "; <-anterior*/
            $updateSale = SaleDetail::join('sales', 'sale_details.codeSale', '=', 'sales.id')
                ->where('sales.codeSale', $codesArray[$y])
                ->update(['delNoteSale' => NULL]);
            /*echo $updateSale." ";*/
            $infoSale = SaleDetail::join('sales', 'sale_details.codeSale', '=', 'sales.id')
                ->where('sales.codeSale', $codesArray[$y])
                ->get();
            /*echo $infoSale." ";*/
            /*echo count($infoSale)." <-COUNT ";*/

            $i = 0;
            while ($i < (count($infoSale))) {
                /*echo $i." es menor que ".count($infoSale)." ";*/
                
                $updateAmount = DB::update('update sale_details set pendingAmountArticle = amountArticle where codeSale = '. $infoSale[$i]->id);
                
                /*if ($updateAmount == 0){ echo "no modifico nada, porque está igual en details "; } else { echo $updateAmount." "; }*/
                
                $select = DB::table('sale_details')->whereNotNull('delNoteSale')->where('codeArticle', $infoSale[$i]->codeArticle)->sum('pendingAmountArticle');
                
                /*echo "esto es la cant. de los no null de delnote: ".$select." ";*/
                
                $updateDispatchStock = DB::update('update stocks set dispatchStock = '.$select.' where codeStock = '. $infoSale[$i]->codeArticle);
                /*if ($updateDispatchStock == 0){ echo "no modifico nada porque no hay cambios "; } else {echo $updateDispatchStock." ";}*/

                $twoSelect = DB::table('sale_details')->whereNull('delNoteSale')->where('codeArticle', $infoSale[$i]->codeArticle)->sum('pendingAmountArticle');
                
                /*echo "esto es la cant. de los null de delnote: ".$twoSelect." ";*/

                $updateCommittedStock = DB::update('update stocks set committedStock = '.$twoSelect.' where codeStock = '. $infoSale[$i]->codeArticle);

                $i++;
                /*echo $i." ya no";*/
            }

            $y++;
        }
        //$idSale = $request->get('idSale');
        
        /*echo $idSale." ";*/
        //$updateSale = SaleDetail::join('sales', 'sale_details.codeSale', '=', 'sales.id')
            //->where('sales.codeSale', $idSale)
            //->update(['delNoteSale' => NULL]);
        /*echo $updateSale." ";*/
        //$infoSale = SaleDetail::join('sales', 'sale_details.codeSale', '=', 'sales.id')
            //->where('sales.codeSale', $idSale)
            //->get();
        /*echo $infoSale." ";*/
        /*echo count($infoSale)." <-COUNT ";*/

        //$i = 0;
        //while ($i < (count($infoSale))) {
            /*echo $i." es menor que ".count($infoSale)." ";*/
            
            //$updateAmount = DB::update('update sale_details set pendingAmountArticle = amountArticle where codeSale = '. $infoSale[$i]->id);
            
            /*if ($updateAmount == 0){ echo "no modifico nada, porque está igual en details "; } else { echo $updateAmount." "; }*/
            
            //$select = DB::table('sale_details')->whereNotNull('delNoteSale')->where('codeArticle', $infoSale[$i]->codeArticle)->sum('pendingAmountArticle');
            
            /*echo "esto es la cant. de los no null de delnote: ".$select." ";*/
            
            //$updateDispatchStock = DB::update('update stocks set dispatchStock = '.$select.' where codeStock = '. $infoSale[$i]->codeArticle);
            /*if ($updateDispatchStock == 0){ echo "no modifico nada porque no hay cambios "; } else {echo $updateDispatchStock." ";}*/

            //$twoSelect = DB::table('sale_details')->whereNull('delNoteSale')->where('codeArticle', $infoSale[$i]->codeArticle)->sum('pendingAmountArticle');
            
            /*echo "esto es la cant. de los null de delnote: ".$twoSelect." ";*/

            //$updateCommittedStock = DB::update('update stocks set committedStock = '.$twoSelect.' where codeStock = '. $infoSale[$i]->codeArticle);

            //$i++;
            /*echo $i." ya no";*/
        //}

        //Cuando se recargue volver a colocar las cantidades
        //No, no lo he terminado, 15 de junio 2021

        //return "otra cosa: ".$updateAmount;
    }
}
