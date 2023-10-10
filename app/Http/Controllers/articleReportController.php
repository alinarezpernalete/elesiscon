<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use App\Models\ArticleDependencies\Line;
use App\Models\ArticleDependencies\Subline;
use App\Models\ArticleDependencies\Group;
use App\Models\ArticleDependencies\Origin;
use App\Models\ArticleDependencies\Type;
use App\Models\Provider;
use App\Models\SaleDetail;
use App\Models\PurchaseDetail;
use PDF;

class articleReportController extends Controller
{
    public function index(Request $request)
    {
    	$articles = Article::all();
    	$providers = Provider::all();
    	$lines = Line::all();
		$sublines = Subline::all();
		$groups = Group::all();
		$origins = Origin::all();
		$types = Type::all();
        return view('articleReport')->with('articles', $articles)->with('providers', $providers)->with('lines', $lines)->with('sublines', $sublines)->with('groups', $groups)->with('origins', $origins)->with('types', $types);
    }

    public function byDate(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');

        $sale_det = DB::table('sale_details')
        ->join('articles', 'sale_details.codeArticle', '=', 'articles.id')
        ->select(DB::raw('articles.codeArticle, articles.nameArticle, sale_details.amountArticle, sale_details.unitPriceArticle, sale_details.created_at'))
        ->whereRaw("(sale_details.created_at >= ? AND sale_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->orderBy('sale_details.created_at', 'DESC')->get();

        $purchase_det = DB::table('purchase_details')
        ->join('articles', 'purchase_details.codeArticle', '=', 'articles.id')
        ->select(DB::raw('articles.codeArticle, articles.nameArticle, purchase_details.amountArticle, purchase_details.unitPriceArticle, purchase_details.created_at'))
        ->whereRaw("(purchase_details.created_at >= ? AND purchase_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])
        ->orderBy('purchase_details.created_at', 'DESC')->get();

        if (count($sale_det) == 0 || count($purchase_det) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('sale_det', 'purchase_det', 'since', 'until');
            $pdf = PDF::loadView('pdf.printArticleByDate', $data);
            
            return $pdf->stream();
        }
    }

    public function byArticle(Request $request)
    {
        $since = $request->get('since');
        $until = $request->get('until');
        $article = $request->get('article');
		
		$sale_det = SaleDetail::where('codeArticle', $article)->whereRaw("(sale_details.created_at >= ? AND sale_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->orderBy('created_at', 'DESC')->get();

        $purchase_det = PurchaseDetail::where('codeArticle', $article)->whereRaw("(purchase_details.created_at >= ? AND purchase_details.created_at <= ?)", [$since." 00:00:00", $until." 23:59:59"])->orderBy('created_at', 'DESC')->get();

        $name_article = Article::where('id', $article)->get();

        if (count($sale_det) == 0 || count($purchase_det) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('sale_det', 'purchase_det', 'since', 'until', 'name_article');
            $pdf = PDF::loadView('pdf.printArticleByArticle', $data);
            
            return $pdf->stream();
        }
    }

    public function byLine(Request $request)
    {
        $line = $request->get('line');
		
		$lines = Article::join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')
        ->where('lineArticle', $line)->orderBy('articles.id', 'ASC')->get();

        if (count($lines) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('lines');
            $pdf = PDF::loadView('pdf.printArticleByLine', $data);
            
            return $pdf->stream();
        }
    }

    public function bySubline(Request $request)
    {
        $subline = $request->get('subline');
		
		$sublines = Article::join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')->where('sublineArticle', $subline)->orderBy('articles.id', 'ASC')->get();

        if (count($sublines) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('sublines');
            $pdf = PDF::loadView('pdf.printArticleBySubline', $data);
            
            return $pdf->stream();
        }
    }

    public function byGroup(Request $request)
    {
        $group = $request->get('group');
		
		$groups = Article::join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')->where('groupArticle', $group)->orderBy('articles.id', 'ASC')->get();

        if (count($groups) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('groups');
            $pdf = PDF::loadView('pdf.printArticleByGroup', $data);
            
            return $pdf->stream();
        }
    }

	public function byOrigin(Request $request)
    {
        $origin = $request->get('origin');
		
		$origins = Article::join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')->where('originArticle', $origin)->orderBy('articles.id', 'ASC')->get();

        $data = compact('origins');
        $pdf = PDF::loadView('pdf.printArticleByOrigin', $data);
        
        return $pdf->stream();
    }

   	public function byType(Request $request)
    {
        $type = $request->get('type');
		
		$types = Article::join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')->where('typeArticle', $type)->orderBy('articles.id', 'ASC')->get();

        if (count($types) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('types');
            $pdf = PDF::loadView('pdf.printArticleByType', $data);
            
            return $pdf->stream();
        }
    }

    public function byProvider(Request $request)
    {
        $provider = $request->get('provider');
		
		$providers = Article::join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')->where('providerArticle', $provider)->orderBy('articles.id', 'ASC')->get();

        if (count($providers) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('providers');
            $pdf = PDF::loadView('pdf.printArticleByProvider', $data);
            
            return $pdf->stream();
        }
    }

    public function byStatus(Request $request)
    {
        $status = $request->get('status');
		
		$articles = Article::join('lines', 'articles.lineArticle', '=', 'lines.id')
        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
        ->join('origins', 'articles.originArticle', '=', 'origins.id')
        ->join('types', 'articles.typeArticle', '=', 'types.id')
        ->join('providers', 'articles.providerArticle', '=', 'providers.id')->where('statusArticle', $status)->orderBy('articles.id', 'ASC')->get();

        if (count($articles) == 0) {
            echo '<script language="javascript">alert("No existen registros. Vuelva a la página anterior");</script>';
        } else {
            $data = compact('articles');
            $pdf = PDF::loadView('pdf.printArticleByStatus', $data);
            
            return $pdf->stream();
        }
    }
}
