<?php

namespace App\Services;

use App\Enums\DefaultType;
use App\Enums\ESIndexType;
use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;

class SearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function autoCompleteSearch($key, $from, $size)
    {
        $params = [
            'from' => $from,
            'size' => $size,
            'index' => 'products', //search in all indexes
            'body'  => [
                'query' => [
                    "match_phrase_prefix" => [
                        "name" => $key
                    ]
                ],
            ]
        ];
        return $this->client->search($params);
    }

    public function multiMatchSearch($key, $from, $size)
    {

        $params = [
            'from' => $from,
            'size'   => $size,
            'index' => ESIndexType::ProductIndex, //search in all indexes
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query' => $key,
                        'type' => 'bool_prefix',
                        'fields' => ['name','brand_name','cate_name']
                    ],
                ],
            ]
        ];
        return $this->client->search($params);
    }

    public function fuzzySearch($key, $from, $size)
    {
        $params = [
            'from' => $from,
            'size'   => $size,
            'index' => 'products',
            'body'  => [
                'query' => [
                    'bool' => [
                        'should' => [
                            ['fuzzy' => ['name' => ['value' =>   $key, 'fuzziness' => 'AUTO']]],
                            ['fuzzy' => ['brand_name' => ['value' =>   $key, 'fuzziness' => 'AUTO']]],
                            ['fuzzy' => ['cate_name' => ['value' =>   $key, 'fuzziness' => 'AUTO']]],
                        ]
                    ]
                ],
            ]
        ];
        return $this->client->search($params);
    }

    public function preprocessSearchResult($results, $key)
    {
        $search_list = collect();
        $highlight = '';
        foreach ($results['hits']['hits'] as $item) {
            $name = $item['_source']['name'];
            if (stripos($name, $key) !== false) {
                $highlight = str_ireplace($key, '<b>' . $key . '</b>', $name);
            }
            $search_list->push([
                'id' => $item['_id'],
                'index' => $item['_index'],
                'name' => $item['_source']['name'],
                'highlight' => $highlight,
                'image' => $item['_source']['image'],
                'price' => $item['_source']['price'],
                'cate_id' => $item['_source']['cate_id'],
                'brand_id' => $item['_source']['brand_id'],
                'amount' => $item['_source']['amount'],
                'selling' => $item['_source']['selling'],
                'review' => $item['_source']['review'],
                'brand_name' => $item['_source']['brand_name'],
                'cate_name' => $item['_source']['cate_name'],
            ]);
        }
        return $search_list;
    }

    public function generateAttribute(Request $request)
    {
        $page = 1;
        $size = DefaultType::default_limit; //size attribute of Elastic Search
        if (isset($request['sort'])) {
            $sort = $request['sort'];
        }
        if (isset($request['limit'])) {
            $size = $request['limit'];
        }
        if (isset($request['page'])) {
            $page = $request['page'];
        }
        $from = ($page - 1) * $size; //from attribute of Elastic Search
        $key = $request['q'];
        $attribute = [
            'page' => $page,
            'from' => $from,
            'size' => $size,
            'key' => $key
        ];
        return $attribute;
    }

    public function showSuggestList($result, Request $request)
    {
        $key = $request['q'];
        $search_list = $this->preprocessSearchResult($result, $key);
        $search_list = $this->getFilter($request, $search_list);
        $output = '';
        if (count($search_list) > 0) {
            // concatenate output to the array
            $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
            // loop through the result array
            foreach ($search_list as $row) {
                // concatenate output to the array
                $output .= '<li class="list-group-item">
                                <a href="/search?q=' . $row['name'] . '">'
                                    . $row['highlight'] .
                                '</a></li>';
            }
            // end of output
            $output .= '</ul>';
        } else {
            // if there's no matching results according to the input
            $output .= '<li class="list-group-item">
                        <a href="/search?q=' . $key . '">
                                Search for: <b>' . $key .
                        '</b></a></li>';
        }
        return $output;
    }

    public function getSearchList($attribute)
    {
        $key = $attribute['key'];
        $from = $attribute['from'];
        $size = $attribute['size'];
        $result = $this->fuzzySearch($key, $from, $size);
        if ($result['hits']['total']['value'] === 0) {
            $result = $this->autoCompleteSearch($key, $from, $size);
        }
        if ($result['hits']['total']['value'] === 0) {
            $result = $this->multiMatchSearch($key, $from, $size);
        }
        return $result;
    }

    public function generateSearchList(Request $request, $result)
    {
        $products = $this->preprocessSearchResult($result, $request['q']);
        return $this->getFilter($request, $products);
    }

    public function generatePaginate($attribute, $totalProduct)
    {
        $page = $attribute['page'];
        $perPage = $attribute['size'];
        $totalPage = strval(ceil($totalProduct / $perPage));
        $paginateCollection = collect([
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => $totalPage
        ]);
        return $paginateCollection;
    }



    protected function getFilter(Request $request, $searchCollection)
    {
        if (isset($request['min_price'])) {
            $searchCollection = $searchCollection->filter(function ($value, $key) use ($request) {
                return $request['max_price'] >= $value['price'] && $value['price'] >= $request['min_price'];
            });
        }
        if ($request['cate_id'] !== null) {
            $searchCollection = $searchCollection->filter(function ($value, $key) use ($request) {
                return $value['cate_id'] == $request['cate_id'];
            });
        }
        $searchCollection = $searchCollection->sortBy([
            ['selling','desc'],
            ['review','desc'],
            ['price','asc']
        ]);
        return $searchCollection;
    }
}
