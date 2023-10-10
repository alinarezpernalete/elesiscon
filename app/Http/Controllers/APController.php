<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AP;
use App\Models\APType;
use App\Models\PaymentCondition;
use App\Models\Provider;
use App\Models\Currency;
use App\Models\Bank;

class APController extends Controller
{
    public function index(Request $request)
    {
    	$APTypes = APType::all();
        $providers = Provider::all();
        $paymentConditions = PaymentCondition::all();
        $currencies = Currency::all();
        $banks = Bank::all();
    	$APs = DB::table('a_p_s')
        ->join('purchases', 'a_p_s.codePurchase', '=', 'purchases.id')
        ->join('a_p_types', 'a_p_s.codeAPType', '=', 'a_p_types.id')
        ->join('providers', 'a_p_s.codeProvider', '=', 'providers.id')
        ->join('payment_conditions', 'a_p_s.codePayment', '=', 'payment_conditions.id')
        ->join('currencies', 'a_p_s.codeCurrency', '=', 'currencies.id')
        ->join('banks', 'a_p_s.codeBank', '=', 'banks.id')
        ->select('a_p_s.id', 'purchases.codePurchase', 'a_p_s.codeAP', 'a_p_types.nameAPType', 'providers.codeProvider', 'providers.nameProvider', 'payment_conditions.codePayment', 'payment_conditions.namePayment', 'currencies.codeCurrency', 'currencies.nameCurrency', 'banks.nameBank', 'banks.codeBank', 'a_p_s.amountDocument', 'a_p_s.amountAP')->orderBy('id', 'DESC')->paginate(10);

        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        if ($search && $filterSearch) {

            $APs = DB::table('a_p_s')
            ->join('purchases', 'a_p_s.codePurchase', '=', 'purchases.id')
            ->join('a_p_types', 'a_p_s.codeAPType', '=', 'a_p_types.id')
            ->join('providers', 'a_p_s.codeProvider', '=', 'providers.id')
            ->join('payment_conditions', 'a_p_s.codePayment', '=', 'payment_conditions.id')
            ->join('currencies', 'a_p_s.codeCurrency', '=', 'currencies.id')
            ->join('banks', 'a_p_s.codeBank', '=', 'banks.id')
            ->select('a_p_s.id', 'purchases.codePurchase', 'a_p_s.codeAP', 'a_p_types.nameAPType', 'providers.codeProvider', 'providers.nameProvider', 'payment_conditions.codePayment', 'payment_conditions.namePayment', 'currencies.codeCurrency', 'currencies.nameCurrency', 'banks.nameBank', 'banks.codeBank', 'a_p_s.amountDocument', 'a_p_s.amountAP')
            ->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'DESC')->paginate(10);

            return view('AP')->with('APs', $APs)->with('APTypes', $APTypes)->with('providers', $providers)->with('paymentConditions', $paymentConditions)->with('currencies', $currencies)->with('banks', $banks);
        }

    	return view('AP')->with('APs', $APs)->with('APTypes', $APTypes)->with('providers', $providers)->with('paymentConditions', $paymentConditions)->with('currencies', $currencies)->with('banks', $banks);
    }

    public function saveAP(Request $request)
    {
        $idAP = $request->get('idAP');
        $amountAP = $request->get('amountAP');
        $currencyAP = $request->get('currencyAP');
        $bankAP = $request->get('bankAP');
        
        ////////////////////////////////////////////////////////

        $select = DB::table('a_p_s')
            ->select('amountAP', 'amountDocument')
            ->where('id', $idAP)->get();

        $newAmountAP = (float)$select[0]->amountAP - (float)$amountAP;

        $updateAmountAP = AP::where('id', $idAP)
            ->update(['amountAP' => $newAmountAP]);

        if ($updateAmountAP == 1) {

            $insertCurrency = AP::where('id', $idAP)
                ->update(['codeCurrency' => $currencyAP]); 
            /////////////////////////////////////////////////////
            $insertBank = AP::where('id', $idAP)
                ->update(['codeBank' => $bankAP]);

            if ($insertCurrency == 1 && $insertBank == 1) {
                return $updateAmountAP;
            }

        }
    }

}
