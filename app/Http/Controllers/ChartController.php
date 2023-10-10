<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HourMgmtDetail;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Request $request)
    {
    	/*$x = HourMgmtDetail::all();
    	$datas = array(0,0,0,0,0,0,0);
    	foreach ($x as $index => $codeProject) {
    		$datas[0] = $codeProject;
    	}
        return view('pdf.exampleGraphic', compact('datas'));*/

        /*$datas = HourMgmtDetail::select(\DB::raw("hrsHourMgmt"))
                    ->whereDay('created_at', date('d'))
                    ->groupBy(\DB::raw("hrsHourMgmt"))
                    ->pluck('hrsHourMgmt');*/

        $project = $request->get('project');

        $datas = HourMgmtDetail::select(\DB::raw("hrsHourMgmt"))
                    ->whereDay('created_at', date('d'))
                    ->where('codeProject', $project)
                    ->pluck('hrsHourMgmt');
          
        return view('pdf.exampleGraphic', compact('datas'));
    }
}
