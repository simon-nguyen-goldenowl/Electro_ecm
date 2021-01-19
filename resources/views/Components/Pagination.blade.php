
<div class="store-filter clearfix">
    <ul class="store-pagination">
        @if($products->lastPage()>5)
            <li class="page-item">
                <p href="#" class="page-link" tabindex="-1" onclick="changePage(1)">
                    <span aria-hidden="true"><<</span>
                </p>
            </li>
        @endif
        @if($products->currentPage() > 1)
            <li class="page-item" >
                <p href="#" class="page-link" tabindex="-1" onclick="changePage({{$products->currentPage()-1}})">
                    <span aria-hidden="true"><</span>
                </p>
            </li>
        @endif
        @for($i = 1; $i <= $products->lastPage(); $i++)
            <li class="page-item">
                <p href="15" class="page-link" id="page{{$i}}" onclick="changePage({{$i}})">{{$i}}</p>
            </li>
        @endfor
        @if($products->currentPage()<$products->lastPage())
            <li class="page-item">
                <p href="#" class="page-link" onclick="changePage({{$products->currentPage()+1}})" >
                    <span aria-hidden="true">></span>
                </p>
            </li>
        @endif
        @if($products->lastPage()>3)
            <li class="page-item">
                <p href="#" class="page-link" id="hh" tabindex="-1" onclick="changePage({{$products->lastPage()}})">
                    <span aria-hidden="true">>></span>
                </p>
            </li>
        @endif
    </ul>
</div>
<style>
    .page-item p {
        cursor: pointer;
    }
</style>
<!-- /store bottom filter -->
@push('scripts')
    <script>
        $("a.page-link").click(function (e){
            e.preventDefault();
        })
    </script>
@endpush

