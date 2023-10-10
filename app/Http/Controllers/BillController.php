<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\PaymentCondition;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Sale;
use App\Models\AR;
use PDF;

class BillController extends Controller
{
    public function index(Request $request)
    {
    	$customers = Customer::all();
    	$paymentConditions = PaymentCondition::all();
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

    	$bills = DB::table('sales')
        ->join('customers', 'sales.customerSale', '=', 'customers.id')
        ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->orderBy('id', 'DESC')->paginate(10);
    	
        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $bills = DB::table('sales')
                ->join('customers', 'sales.customerSale', '=', 'customers.id')
                ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                ->join('users', 'sales.userSale', '=', 'users.id')
                ->select('sales.id', 'sales.codeSale', 'customers.nameCustomer', 'payment_conditions.namePayment', 'sales.descriptionSale', 'sales.typeSale', 'users.name', 'sales.created_at')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->paginate(10);

            return view('bill')->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('bills', $bills)->with('search', $search);
        }

    	return view('bill')->with('bills', $bills)->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('search', $search);
    }

    public function selectDeliveryNote(Request $request)
    {
    	$codeSale = $request->get('codeSale');

    	$deliveryNote = DB::table('sales')
        ->join('users', 'sales.userSale', '=', 'users.id')
        ->select('sales.id', 'sales.codeSale', 'sales.customerSale', 'sales.paymentSale', 'sales.descriptionSale', 'users.name', 'sales.created_at')
        ->where('codeSale', $codeSale)->get();

    	return $deliveryNote;
    }

    public function loadArticles(Request $request)
    {
    	$idSale = $request->get('idSale');

    	$deliveryNote = DB::table('sale_details')
    	->join('articles', 'sale_details.codeArticle', '=', 'articles.id')
    	->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'sale_details.amountArticle', 'sale_details.unitPriceArticle')
        ->where('codeSale', $idSale)->get();

        $sum = DB::select('SELECT sum(unitPriceArticle*amountArticle) as sum FROM sale_details WHERE codeSale = '. $idSale);

        return response()->json(['success'=>$deliveryNote, 'success2'=>$sum]);

    	//return $deliveryNote;
    }

    public function saveBill(Request $request)
    {
        $idSale = $request->get('idSale');

        $updateTypeSale = Sale::where('id', $idSale)
           ->update(['typeSale' => 4, 'billDateSale' => now()]);
        $updateDetails = SaleDetail::where('codeSale', $idSale)
           ->update(['billSale' => 1]);

        ////////////////////////////////////////

        if ($updateTypeSale == 1) {
            $select = DB::table('sale_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codeSale', $idSale)->get();
            $sale = DB::table('sales')
                ->select('sales.customerSale', 'sales.paymentSale')
                ->where('id', $idSale)->get();
            
            //return response()->json(['success'=>$select, 'success2'=>$sale]);
            
            $codeARType = '1';
            $codeCurrency = '1';
            $codeBank = '1';

            $newAR = new AR();
            $newAR->codeSale = $idSale;
            $newAR->codeARType = $codeARType;
            $newAR->codeCustomer = $sale[0]->customerSale;
            $newAR->codePayment = $sale[0]->paymentSale;
            $newAR->codeCurrency = $codeCurrency;
            $newAR->codeBank = $codeBank;
            $newAR->amountDocument = $select[0]->total;
            $newAR->amountAR = $select[0]->total;
            $newAR->save();

            return $updateTypeSale;
        }
    }

    public function print(Request $request)
    {
        $idSale = $request->get('idSale');
        
        $bill = Sale::join('customers', 'sales.customerSale', '=', 'customers.id')
                            ->join('payment_conditions', 'sales.paymentSale', '=', 'payment_conditions.id')
                            ->join('users', 'sales.userSale', '=', 'users.id')->find($idSale);
        
        $billDat = Sale::where('id', $idSale)->get();

        $billDet = SaleDetail::join('articles', 'sale_details.codeArticle', '=', 'articles.id')->where('codeSale', $idSale)->get();

        $billTot = DB::table('sale_details')
                ->select(DB::raw('SUM(unitPriceArticle*amountArticle) as total'))
                ->where('codeSale', $idSale)->get();
        
        $data = compact('bill', 'billDet', 'billDat','billTot');
        
        $pdf = PDF::loadView('pdf.printBill', $data);
        
        return $pdf->stream();
    }
}
