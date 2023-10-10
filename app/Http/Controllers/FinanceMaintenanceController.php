<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\PaymentCondition;

class FinanceMaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        $banks = Bank::all();
        $currencies = Currency::all();
        $paymentConditions = PaymentCondition::all();

        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

        	if ($filterSearch == "codeBank" || $filterSearch == "nameBank") {
        		$banks = DB::table('banks')
	            ->select('banks.id', 'banks.codeBank', 'banks.nameBank')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->get();

	            return view('financeMaintenance')->with('banks', $banks)->with('currencies', $currencies)->with('paymentConditions', $paymentConditions)->with('search', $search)->with('filterSearch', $filterSearch);
        	}

        	if ($filterSearch == "codeCurrency" || $filterSearch == "nameCurrency") {
        		$currencies = DB::table('currencies')
	            ->select('currencies.id', 'currencies.codeCurrency', 'currencies.nameCurrency')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->get();

	            return view('financeMaintenance')->with('banks', $banks)->with('currencies', $currencies)->with('paymentConditions', $paymentConditions)->with('search', $search)->with('filterSearch', $filterSearch);
        	}

        	if ($filterSearch == "codePayment" || $filterSearch == "namePayment") {
        		$paymentConditions = DB::table('payment_conditions')
	            ->select('payment_conditions.id', 'payment_conditions.codePayment', 'payment_conditions.namePayment')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->get();

	            return view('financeMaintenance')->with('banks', $banks)->with('currencies', $currencies)->with('paymentConditions', $paymentConditions)->with('search', $search)->with('filterSearch', $filterSearch);
        	}
        }

        return view('financeMaintenance')->with('banks', $banks)->with('currencies', $currencies)->with('paymentConditions', $paymentConditions)->with('search', $search)->with('filterSearch', $filterSearch);
    }

    public function checkBank(Request $request)
    {
        $newBank = new Bank();
        $newBank->codeBank = $request->codeBank;
        $newBank->nameBank = $request->nameBank;
        $newBank->save();
    }

    public function checkCurrency(Request $request)
    {
        $newCurrency = new Currency();
        $newCurrency->codeCurrency = $request->codeCurrency;
        $newCurrency->nameCurrency = $request->nameCurrency;
        $newCurrency->save();
    }

    public function checkPayment(Request $request)
    {
        $newPayment = new PaymentCondition();
        $newPayment->codePayment = $request->codePayment;
        $newPayment->namePayment = $request->namePayment;
        $newPayment->save();
    }
}
