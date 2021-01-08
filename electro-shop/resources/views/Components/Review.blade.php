
<div id="reviewID" class="active">
    <div class="row">
        <!-- Rating -->
        <div class="col-md-3">
            <div id="rating">
                <div class="rating-avg">
                    <span>4.5</span>
                    <div class="rating-stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                </div>
                <ul class="rating">
                    <li>
                        <div class="rating-stars">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="rating-progress">
                            <div style="width: 80%;"></div>
                        </div>
                        <span class="sum">3</span>
                    </li>
                    <li>
                        <div class="rating-stars">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <div class="rating-progress">
                            <div style="width: 60%;"></div>
                        </div>
                        <span class="sum">2</span>
                    </li>
                    <li>
                        <div class="rating-stars">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <div class="rating-progress">
                            <div></div>
                        </div>
                        <span class="sum">0</span>
                    </li>
                    <li>
                        <div class="rating-stars">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <div class="rating-progress">
                            <div></div>
                        </div>
                        <span class="sum">0</span>
                    </li>
                    <li>
                        <div class="rating-stars">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <div class="rating-progress">
                            <div></div>
                        </div>
                        <span class="sum">0</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Rating -->

        <!-- Reviews -->
        <div class="col-md-6">
            <div id="reviews">
                <ul class="reviews">
                    @foreach($reviews as $review)
                        <li>
                            <div class="review-heading">
                                <h5 class="name">{{$review->customer->username}}</h5>
                                <p class="date">{{$review->created_at}}</p>
                                <div class="review-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o empty"></i>
                                </div>
                            </div>
                            <div class="review-body">
                                <p>{{$review->content}}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <ul class="reviews-pagination">
                    @include('Components.Pagination', ['products'=>$reviews])
                </ul>
            </div>
        </div>
        <!-- /Reviews -->

        <!-- Review Form -->
        <div class="col-md-3">
            @if(session()->get('user') !== null)
            <div id="review-form">
                <form class="review-form" action="/reviews" method="post">
                    @csrf
                    <input class="input" type="text" name="product_id" value="{{$id}}" hidden>
                    <input class="input" type="text" name="customer_id" value="{{session()->get('user')}}" hidden>
                    <label for="">Submit your review here</label>
                    <textarea class="input" placeholder="Your Review" name="content" required></textarea>
                    <button class="primary-btn">Submit</button>
                </form>
            </div>
            @else
                <button data-toggle="modal" data-target="#exampleModal" class="primary-btn">Log in to submit review</button>
            @endif
        </div>
        <!-- /Review Form -->
    </div>
</div>


@push('scripts')
    <script>
        function changePage(page){
            current_page = page;
            filter()
        }
        function filter() {
            $.ajax({
                type: 'get',
                url: '/review-list/{{$id}}',
                data: {
                    'page': current_page,
                },
                success:function(data){
                    $('#reviewID').html(data);
                },
                error:function (data){
                    console.log(data);
                }
            })
        }
    </script>
@endpush
