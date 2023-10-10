<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//------------------------------------------------//
use App\Models\ArticleDependencies\Line;
use App\Models\ArticleDependencies\Subline;
use App\Models\ArticleDependencies\Group;
use App\Models\ArticleDependencies\Origin;
use App\Models\ArticleDependencies\Type;
use App\Models\Provider;
use App\Models\Article;
use App\Models\Stock;
use App\Models\Price;

class ArticlesController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get("search");
        $filterSearch = $request->get("filterSearch");

        $lines = Line::all();
        $sublines = Subline::all();
        $groups = Group::all();
        $origins = Origin::all();
        $types = Type::all();
        $providers = Provider::all();
        
        $articles = DB::table('articles')
            ->join('lines', 'articles.lineArticle', '=', 'lines.id')
            ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
            ->join('groups', 'articles.groupArticle', '=', 'groups.id')
            ->join('origins', 'articles.originArticle', '=', 'origins.id')
            ->join('types', 'articles.typeArticle', '=', 'types.id')
            ->join('providers', 'articles.providerArticle', '=', 'providers.id')
            ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'articles.modelArticle', 'articles.referenceArticle', 'articles.weightArticle', 'articles.locationArticle', 'lines.nameLine', 'sublines.nameSubline', 'groups.nameGroup', 'origins.nameOrigin', 'types.nameType', 'providers.nameProvider', 'articles.created_at')->where('statusArticle', '1')->orderBy('id', 'ASC')->paginate(10);

        if ($search && $filterSearch) {
            //echo "Hay datos, y son: ". $search .", ".$filterSearch;

            $articles = DB::table('articles')
            ->join('lines', 'articles.lineArticle', '=', 'lines.id')
            ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
            ->join('groups', 'articles.groupArticle', '=', 'groups.id')
            ->join('origins', 'articles.originArticle', '=', 'origins.id')
            ->join('types', 'articles.typeArticle', '=', 'types.id')
            ->join('providers', 'articles.providerArticle', '=', 'providers.id')
            ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'articles.modelArticle', 'articles.referenceArticle', 'articles.weightArticle', 'articles.locationArticle', 'lines.nameLine', 'sublines.nameSubline', 'groups.nameGroup', 'origins.nameOrigin', 'types.nameType', 'providers.nameProvider', 'articles.created_at')->where('statusArticle', '1')->where($filterSearch, 'LIKE', "%$search%")->orderBy('id', 'ASC')->paginate(10);

            return view('articles')->with('lines', $lines)->with('sublines', $sublines)->with('groups', $groups)->with('origins', $origins)->with('types', $types)->with('providers', $providers)->with('articles', $articles)->with('search', $search);
        }

        return view('articles')->with('lines', $lines)->with('sublines', $sublines)->with('groups', $groups)->with('origins', $origins)->with('types', $types)->with('providers', $providers)->with('articles', $articles)->with('search', $search);
    }

    public function additionalQuery(Request $request)
    {
        $idArticle = $request->get('idArticle');

        $prices = DB::table('prices')
        ->select('prices.currentPrice', 'prices.updated_at')
        ->where('codePrice', $idArticle)
        ->get();

        $stocks = DB::table('stocks')
        ->select('stocks.currentStock', 'stocks.committedStock', 'stocks.dispatchStock', 'stocks.arriveStock')
        ->where('codeStock', $idArticle)
        ->get();

        return response()->json(['prices'=>$prices, 'stocks'=>$stocks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newArticle = new Article();
        $newArticle->codeArticle = $request->codeArticle;
        $newArticle->typeArticle = $request->typeArticle;
        $newArticle->nameArticle = $request->nameArticle;
        $newArticle->modelArticle = $request->modelArticle;
        $newArticle->lineArticle = $request->lineArticle;
        $newArticle->sublineArticle = $request->sublineArticle;
        $newArticle->groupArticle = $request->groupArticle;
        $newArticle->referenceArticle = $request->referenceArticle;
        $newArticle->weightArticle = $request->weightArticle;
        $newArticle->providerArticle = $request->providerArticle;
        $newArticle->originArticle = $request->originArticle;
        $newArticle->locationArticle = $request->locationArticle;
        $newArticle->statusArticle = '1';
        $newArticle->save();

        $id = Article::orderBy('id', 'DESC')->first();

        $newStock = new Stock();
        $newStock->codeStock = $id->id;
        $newStock->currentStock = '0';
        $newStock->committedStock = '0';
        $newStock->dispatchStock = '0';
        $newStock->arriveStock = '0';
        $newStock->save();

        $newPrice = new Price();
        $newPrice->codePrice = $id->id;
        $newPrice->currentPrice = '0';
        $newPrice->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        //
    }

    public function desactiveArticle(Request $request)
    {
        $id = $request->get('id');
        $updateArticle = Article::where('id', $id)->update(['statusArticle' => 0]);
        return $updateArticle;
    }
}
