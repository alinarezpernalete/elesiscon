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

class QuotationController extends Controller
{
    public function index(Request $request)
    {
    	$customers = Customer::all();
    	$paymentConditions = PaymentCondition::all();
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        // -----------------------------------------------------------------------------------------------------------  //
        $articles = DB::table('articles')
        ->join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')
        ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'articles.modelArticle', 'articles.referenceArticle', 'articles.weightArticle', 'articles.locationArticle', 'lines.nameLine', 'sublines.nameSubline', 'groups.nameGroup', 'origins.nameOrigin', 'types.nameType', 'providers.nameProvider', 'articles.created_at', 'articles.statusArticle')->where('articles.statusArticle', 1)->orderBy('id', 'ASC')->paginate(3);
        // -----------------------------------------------------------------------------------------------------------  //

        $quotations = DB::table('sales')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->orderBy('id', 'DESC')->paginate(10);

        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $quotations = DB::table('sales')
                ->join('customers', 'sales.customerSale', '=', 'customers.id')
                ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                ->join('users', 'sales.userSale', '=', 'users.id')
                ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->paginate(10);

            return view('quotation')->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('articles', $articles)->with('quotations', $quotations)->with('search', $search);
        }

    	return view('quotation')->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('articles', $articles)->with('quotations', $quotations)->with('search', $search);
    }

    public function findArticle(Request $request)
    {
        $nameArticle = $request->get('nameArticle');
        $articles = DB::table('articles')
        ->join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')
        ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'articles.modelArticle', 'articles.referenceArticle', 'articles.weightArticle', 'articles.locationArticle', 'lines.nameLine', 'sublines.nameSubline', 'groups.nameGroup', 'origins.nameOrigin', 'types.nameType', 'providers.nameProvider', 'articles.created_at', 'articles.statusArticle')->where('articles.statusArticle', 1)->where('articles.nameArticle', 'LIKE', "%$nameArticle%")->orderBy('id', 'ASC')->paginate(20);

        return $articles;
    }

    public function checkCustomer(Request $request)
    {
        $newCustomer = new Customer();
        $newCustomer->codeCustomer = $request->codeCustomer;
        $newCustomer->nameCustomer = $request->nameCustomer;
        $newCustomer->addressCustomer = $request->addressCustomer;
        $newCustomer->phoneCustomer = $request->phoneCustomer;
        $newCustomer->emailCustomer = $request->emailCustomer;
        $newCustomer->statusCustomer = 1;
        $newCustomer->save();
    }

    public function findDetail(Request $request)
    {
        $idSale = $request->get('idSale');
        
        $idDetail = DB::table('sale_details')
            ->join('articles', 'sale_details.codeArticle', '=', 'articles.id')
            ->select('sale_details.id', 'articles.codeArticle', 'articles.nameArticle', 'sale_details.amountArticle', 
                'sale_details.pendingAmountArticle', 'sale_details.unitPriceArticle')
            ->where('codeSale', $idSale)->get();

        //$sum = SaleDetail::where('codeSale', $idSale)->sum('unitPriceArticle*amountArticle');
        $sum = DB::select('SELECT sum(unitPriceArticle*amountArticle) as sum FROM sale_details WHERE codeSale = '. $idSale);

        //return $idDetail;
        return response()->json(['success'=>$idDetail, 'success2'=>$sum]);
    }

    public function cancelDetail(Request $request)
    {
        $idSale = $request->get('idSale');
        
        $infoDetail = SaleDetail::where('codeSale', $idSale)->get();

        $i = (count($infoDetail))-1;
        while ($i >= 0) {
            echo $infoDetail[$i]->codeArticle;
            echo $infoDetail[$i]->amountArticle;
            
            $committedStock = DB::table('stocks')
                ->select('stocks.committedStock')
                ->where('codeStock', $infoDetail[$i]->codeArticle)
                ->get();
            
            $deletedStock = $committedStock[0]->committedStock - $infoDetail[$i]->amountArticle;

            $updateStock = Stock::where('codeStock', $infoDetail[$i]->codeArticle)
                ->update(['committedStock' => $deletedStock]);  

            $currentStock = DB::table('stocks')
                ->select('stocks.currentStock')
                ->where('codeStock', $infoDetail[$i]->codeArticle)
                ->get();

            $newCurrentStock = $currentStock[0]->currentStock + $infoDetail[$i]->amountArticle;

            $updateStock = Stock::where('codeStock', $infoDetail[$i]->codeArticle)
                ->update(['currentStock' => $newCurrentStock]);  
            
            $i--;
        }






        $updateSale = Sale::where('id', $idSale)
            ->update(['typeSale' => 5]);

        return $updateSale;
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
        } else {
            return "No hay";
        }
    }

    public function addArticle(Request $request)
    {
        $idArticle = $request->get('idArticle');
        $amountArticle = $request->get('amountArticle');
        $unitPriceArticle = $request->get('unitPriceArticle');

        $queryCurrentStock = DB::table('stocks')
            ->select('stocks.currentStock')
            ->where('codeStock', $idArticle)->get();
        
        if ($amountArticle > $queryCurrentStock[0]->currentStock) {
            
            return '0';

        } else {

            if ($amountArticle > 0 && $amountArticle <= $queryCurrentStock[0]->currentStock) {
                
                //$currentStock = substr(json_encode($queryCurrentStock), 17, -2);
            
                $newCurrentStock = $queryCurrentStock[0]->currentStock-$amountArticle;

                $updateCurrentStock = Stock::where('codeStock', $idArticle)
                    ->update(['currentStock' => $newCurrentStock]);

                // --------------------------------------------------------- //

                $queryCommittedStock = DB::table('stocks')
                ->select('stocks.committedStock')
                ->where('codeStock', $idArticle)->get();

                //$committedStock = substr(json_encode($queryCommittedStock), 19, -2);

                $newCommittedStock = $queryCommittedStock[0]->committedStock+$amountArticle;

                $updateCommittedStock = Stock::where('codeStock', $idArticle)
                    ->update(['committedStock' => $newCommittedStock]);

                // --------------------------------------------------------- // 

                $newSaleDetail = new SaleDetail();
                $newSaleDetail->codeArticle = $idArticle;
                $newSaleDetail->amountArticle = $amountArticle;
                $newSaleDetail->unitPriceArticle = $unitPriceArticle;
                $newSaleDetail->pendingAmountArticle = $amountArticle;
                $newSaleDetail->quoSale = '1';
                
                $newSaleDetail->save();

                // --------------------------------------------------------- //        
                
                $idDetail = DB::table('sale_details')
                ->select('sale_details.id')
                ->where('codeArticle', $idArticle)
                ->where('amountArticle', $amountArticle)
                ->where('unitPriceArticle', $unitPriceArticle)->get()->last();
                return response()->json(['success'=>$idDetail]);
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

        $deletedDetail = DB::table('sale_details')->where('id', '=', $idDetail)->delete();

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

    public function store(Request $request)
    {
        $typeSale = '1';

        $newQuotation = new Sale();
        $newQuotation->codeSale = $request->codeSale;
        $newQuotation->customerSale = $request->customerSale;
        $newQuotation->paymentSale = $request->paymentSale;
        $newQuotation->descriptionSale = $request->descriptionSale;
        $newQuotation->typeSale = $typeSale;
        $newQuotation->userSale = $request->userSale;
        $newQuotation->quoDateSale = now();

        $newQuotation->save();

        // ----------------------------------------------------------------------- //

        $idSale = Sale::orderBy('id', 'DESC')->first();

        $updateDetail = SaleDetail::where('codeSale', NULL)
            ->update(['codeSale' => $idSale->id]);
        
        return $idSale->id;

        // ----------------------------------------------------------------------- //

        //return redirect()->back();
    }

    public function print(Request $request)
    {
        $idSale = $request->get('idSale');
        
        $quotation = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
                            ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                            ->join('users', 'sales.userSale', '=', 'users.id')->find($idSale);
        
        $quotationDat = Sale::where('id', $idSale)->get();

        $quotationDet = SaleDetail::join('articles', 'sale_details.codeArticle', '=', 'articles.id')->where('codeSale', $idSale)->get();

        $quotationTot = DB::table('sale_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codeSale', $idSale)->get();
        
        $data = compact('quotation', 'quotationDet', 'quotationDat', 'quotationTot');
        
        $pdf = PDF::loadView('pdf.printQuotation', $data);
        
        return $pdf->stream();
    }

    public function deleteOnUnload(Request $request)
    {
        $infoDetail = DB::table('sale_details')->where('codeSale', NULL)->get();

        $i = (count($infoDetail))-1;
        while ($i >= 0) {
            echo $infoDetail[$i]->codeArticle;
            echo $infoDetail[$i]->amountArticle;
            
            $committedStock = DB::table('stocks')
                ->select('stocks.committedStock')
                ->where('codeStock', $infoDetail[$i]->codeArticle)
                ->get();
            
            $deletedStock = $committedStock[0]->committedStock - $infoDetail[$i]->amountArticle;

            $updateStock = Stock::where('codeStock', $infoDetail[$i]->codeArticle)
                ->update(['committedStock' => $deletedStock]);  

            $currentStock = DB::table('stocks')
                ->select('stocks.currentStock')
                ->where('codeStock', $infoDetail[$i]->codeArticle)
                ->get();

            $newCurrentStock = $currentStock[0]->currentStock + $infoDetail[$i]->amountArticle;

            $updateStock = Stock::where('codeStock', $infoDetail[$i]->codeArticle)
                ->update(['currentStock' => $newCurrentStock]);  
            
            $i--;
        }

        $deletedDetail = DB::table('sale_details')->where('codeSale', NULL)->delete();
        return $deletedDetail;

    }

}
