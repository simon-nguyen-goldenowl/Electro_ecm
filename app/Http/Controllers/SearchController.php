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
    public function autoComplete(Request $request)
    {
        return $this->searchService->showSuggestList($request);
    }
    public function submitSearch(Request $request)
    {
        return redirect('/search?q=' . $request['q']);
    }
}
