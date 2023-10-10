<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Provider;

class ProvidersController extends Controller
{
    public function index(Request $request)
    {
		$providers = Provider::where('statusProvider', 1)->paginate(10);
    	
    	$search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        if ($search && $filterSearch) {
            $providers = DB::table('providers')
            ->select('providers.id', 'providers.codeProvider', 'providers.nameProvider', 'providers.addressProvider', 'providers.phoneProvider', 'providers.emailProvider')->where($filterSearch, 'LIKE', "%$search%")->where('statusProvider', 1)->orderBy('id', 'DESC')->paginate(10);

            return view('providers')->with('providers', $providers)->with('search', $search);
        }
        
        return view('providers')->with('providers', $providers)->with('search', $search);
    }

    public function store(Request $request)
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

    public function desactiveProvider(Request $request)
    {
        $id = $request->get('id');
        $updateProvider = Provider::where('id', $id)->update(['statusProvider' => 0]);
        return $updateProvider;
    }
}
