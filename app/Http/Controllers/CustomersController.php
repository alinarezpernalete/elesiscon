<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
		$customers = Customer::where('statusCustomer', 1)->paginate(10);
    	
    	$search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        if ($search && $filterSearch) {
            $customers = DB::table('customers')
            ->select('customers.id', 'customers.codeCustomer', 'customers.nameCustomer', 'customers.addressCustomer', 'customers.phoneCustomer', 'customers.emailCustomer')->where($filterSearch, 'LIKE', "%$search%")->where('statusCustomer', 1)->orderBy('id', 'DESC')->paginate(10);

            return view('customers')->with('customers', $customers)->with('search', $search);
        }
        
        return view('customers')->with('customers', $customers)->with('search', $search);
    }

    public function store(Request $request)
    {
        $newCustomer = new Customer();
        $newCustomer->codeCustomer = $request->codeCustomer;
        $newCustomer->nameCustomer = $request->nameCustomer;
        $newCustomer->addressCustomer = $request->addressCustomer;
        $newCustomer->phoneCustomer = $request->phoneCustomer;
        $newCustomer->emailCustomer = $request->emailCustomer;
        $newCustomer->statusCustomer = 1;
        $newCustomer->save();
        return $newCustomer;
    }

    public function desactiveCustomer(Request $request)
    {
        $id = $request->get('id');
        $updateCustomer = Customer::where('id', $id)->update(['statusCustomer' => 0]);
        return $updateCustomer;
    }
}
