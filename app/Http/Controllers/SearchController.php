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
        return $this->searchService->showSearchList($request);
    }
    public function submitSearch(Request $request)
    {
        $result = $this->searchService->fuzzySearch($request);
//        if ($result > 0) {
//            return redirect('/brands/' . $result);
//        }
        return $result;
    }
}
