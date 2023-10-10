<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    /*public function scopeGeneralQuery($query, $filterSearch, $search) 
    {
    	if ($filterSearch) {
    		$articles = DB::table('articles')
	        ->join('lines', 'articles.lineArticle', '=', 'lines.id')
	        ->join('sublines', 'articles.sublineArticle', '=', 'sublines.id')
	        ->join('groups', 'articles.groupArticle', '=', 'groups.id')
	        ->join('origins', 'articles.originArticle', '=', 'origins.id')
	        ->join('types', 'articles.typeArticle', '=', 'types.id')
	        ->join('providers', 'articles.providerArticle', '=', 'providers.id')
	        ->select('articles.id', 'articles.codeArticle', 'articles.nameArticle', 'articles.modelArticle', 'articles.referenceArticle', 'articles.weightArticle', 'articles.locationArticle', 'lines.nameLine', 'sublines.nameSubline', 'groups.nameGroup', 'origins.nameOrigin', 'types.nameType', 'providers.nameProvider', 'articles.created_at')->where($filterSearch, 'LIKE', "%$search%");
    		return $query;
    	}
    }*/
}
