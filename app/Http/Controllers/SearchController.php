<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;
    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    public function autoCompleteSearch(Request $request)
    {
        $key = $request['q'];
        $cate_id = $request['cate_id'];
        $result = $this->searchService->autoCompleteSearch($key, 0, 5);
        return $this->searchService->showSuggestList($result, $request);
    }
    public function submitSearch(Request $request)
    {
        return redirect('/search?q=' . $request['q'] . '&cate_id=' . $request['cate_id']);
    }
}
