<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AR;
use App\Models\ARType;
use App\Models\PaymentCondition;
use App\Models\Customer;
use App\Models\Currency;
use App\Models\Bank;

class ARController extends Controller
{
    public function index(Request $request)
    {
    	$ARTypes = ARType::all();
        $customers = Customer::all();
        $paymentConditions = PaymentCondition::all();
        $currencies = Currency::all();
        $banks = Bank::all();
        $ARs = DB::table('a_r_s')
        ->join('sales', 'a_r_s.codeSale', '=', 'sales.id')
        ->join('a_r_types', 'a_r_s.codeARType', '=', 'a_r_types.id')
        ->join('customers', 'a_r_s.codeCustomer', '=', 'customers.id')
        ->join('payment_conditions', 'a_r_s.codePayment', '=', 'payment_conditions.id')
        ->join('currencies', 'a_r_s.codeCurrency', '=', 'currencies.id')
        ->join('banks', 'a_r_s.codeBank', '=', 'banks.id')
        ->select('a_r_s.id', 'sales.codeSale', 'a_r_s.codeAR', 'a_r_types.nameARType', 'customers.codeCustomer', 'customers.nameCustomer', 'payment_conditions.codePayment', 'payment_conditions.namePayment', 'currencies.codeCurrency', 'currencies.nameCurrency', 'banks.nameBank', 'banks.codeBank', 'a_r_s.amountDocument', 'a_r_s.amountAR')->orderBy('id', 'DESC')->paginate(10);

        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        if ($search && $filterSearch) {

            $ARs = DB::table('a_r_s')
            ->join('sales', 'a_r_s.codeSale', '=', 'sales.id')
            ->join('a_r_types', 'a_r_s.codeARType', '=', 'a_r_types.id')
            ->join('customers', 'a_r_s.codeCustomer', '=', 'customers.id')
            ->join('payment_conditions', 'a_r_s.codePayment', '=', 'payment_conditions.id')
            ->join('currencies', 'a_r_s.codeCurrency', '=', 'currencies.id')
            ->join('banks', 'a_r_s.codeBank', '=', 'banks.id')
            ->select('a_r_s.id', 'sales.codeSale', 'a_r_s.codeAR', 'a_r_types.nameARType', 'customers.codeCustomer', 'customers.nameCustomer', 'payment_conditions.codePayment', 'payment_conditions.namePayment', 'currencies.codeCurrency', 'currencies.nameCurrency', 'banks.nameBank', 'banks.codeBank', 'a_r_s.amountDocument', 'a_r_s.amountAR')
            ->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'DESC')->paginate(10);

            return view('AR')->with('ARs', $ARs)->with('ARTypes', $ARTypes)->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('currencies', $currencies)->with('banks', $banks);
        }

    	return view('AR')->with('ARs', $ARs)->with('ARTypes', $ARTypes)->with('customers', $customers)->with('paymentConditions', $paymentConditions)->with('currencies', $currencies)->with('banks', $banks);
    }

    public function saveAR(Request $request)
    {
        $idAR = $request->get('idAR');
        $amountAR = $request->get('amountAR');
        $currencyAR = $request->get('currencyAR');
        $bankAR = $request->get('bankAR');
        
        ////////////////////////////////////////////////////////

        $select = DB::table('a_r_s')
            ->select('amountAR', 'amountDocument')
            ->where('id', $idAR)->get();

        $newAmountAR = (float)$select[0]->amountAR - (float)$amountAR;

        $updateAmountAR = AR::where('id', $idAR)
            ->update(['amountAR' => $newAmountAR]);

        if ($updateAmountAR == 1) {

            $insertCurrency = AR::where('id', $idAR)
                ->update(['codeCurrency' => $currencyAR]); 
            /////////////////////////////////////////////////////
            $insertBank = AR::where('id', $idAR)
                ->update(['codeBank' => $bankAR]);

            if ($insertCurrency == 1 && $insertBank == 1) {
                return $updateAmountAR;
            }

        }
    }
}
