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
        $result = $this->searchService->autoCompleteSearch($key);
        return $this->searchService->showSuggestList($result, $key);
    }
    public function submitSearch(Request $request)
    {
        return redirect('/search?q=' . $request['q']);
    }
}
