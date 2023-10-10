<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use PDF;

class provReportController extends Controller
{
    public function index(Request $request)
    {
        return view('provReport');
    }
	public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');

        $provider = DB::table('providers')
        ->whereRaw("(providers.created_at >= ? AND providers.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->orderBy('providers.created_at', 'DESC')->get();

        if (count($provider) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('provider', 'since', 'until');
            $pdf = PDF::loadView('pdf.printProvByDate', $data);
            
            return $pdf->stream();
        }
    }
    public function byStatus(Request $request)
    {
        $status = $request->get('status');
    	$provider = Provider::where('statusProvider', $status)->get();
    	
        if (count($provider) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('provider');
            $pdf = PDF::loadView('pdf.printProvByStatus', $data);
            
            return $pdf->stream();
        }
    }
}
