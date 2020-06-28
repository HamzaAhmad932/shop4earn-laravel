@extends('layout.app')
@section('title', 'Product List')

@section('page_content')
    <!--shop  area start-->
    <div class="shop_area shop_fullwidth mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!--shop wrapper start-->
                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper">
                        <div class="shop_toolbar_btn">

                            <button data-role="grid_3" type="button" class=" btn-grid-3" data-toggle="tooltip" title="3"></button>

                            <button data-role="grid_4" type="button"  class="active btn-grid-4" data-toggle="tooltip" title="4"></button>

                            <button data-role="grid_list" type="button"  class="btn-list" data-toggle="tooltip" title="List"></button>
                        </div>
{{--                        <div class=" niceselect_option">--}}
{{--                            <form class="select_option" action="#">--}}
{{--                                <select name="orderby" id="short">--}}

{{--                                    <option selected value="1">Sort by average rating</option>--}}
{{--                                    <option  value="2">Sort by popularity</option>--}}
{{--                                    <option value="3">Sort by newness</option>--}}
{{--                                    <option value="4">Sort by price: low to high</option>--}}
{{--                                    <option value="5">Sort by price: high to low</option>--}}
{{--                                    <option value="6">Product Name: Z</option>--}}
{{--                                </select>--}}
{{--                            </form>--}}
{{--                        </div>--}}
                        <div class="page_amount">
                            <p>Showing 1–9 of 21 results</p>
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <div class="row shop_wrapper grid_4">
                        @foreach($products as $product)
                            <div class="col-lg-3 col-md-4 col-12 ">
                            <article class="single_product">
                                <figure>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{route('shop.product', $product->id)}}">
                                            @if(!empty($product->featured_img))
                                                <img src="{{asset('storage/'.$product->featured_img)}}" alt="">
                                            @else
                                                <img src="{{asset('assets/images/no-image-png-2.png')}}" alt="">
                                            @endif
                                        </a>
                                        <a class="secondary_img" href="{{route('shop.product', $product->id)}}">
                                            @if(!empty($product->img_1))
                                                <img src="{{asset('storage/'.$product->img_1)}}" alt="">
                                            @else
                                                <img src="{{asset('assets/images/no-image-png-2.png')}}" alt="">
                                            @endif
                                        </a>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart"><a href="cart.html" title="Add to cart"><i class="zmdi zmdi-shopping-cart"></i></a></li>

                                                <li class="wishlist"><a href="wishlist.html"  title="Add to Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a></li>

                                                <li class="compare"><a href="#" title="Add to Compare"><i class="zmdi zmdi-shuffle"></i></a></li>

                                                <li class="quick_button"><a href="#" data-toggle="modal" data-target="#modal_box"  title="quick view"> <i class="zmdi zmdi-eye"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_content grid_content">
                                        <h4 class="product_name"><a href="{{route('shop.product', $product->id)}}">{{$product->product_name}}</a></h4>

                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
{{--                                            <span class="old_price">$420.00</span>--}}
                                            <span class="current_price">Rs. {{$product->product_price}}</span>
                                        </div>
                                    </div>
                                    <div class="product_content list_content">
                                        <h4 class="product_name"><a href="{{route('shop.product', $product->id)}}">{{$product->product_name}}</a></h4>
                                        <div class="product_rating">
                                            <ul>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </div>
                                        <div class="price_box">
{{--                                            <span class="old_price">$420.00</span>--}}
                                            <span class="current_price">Rs. {{$product->product_price}}</span>
                                        </div>
                                        <div class="product_desc">
                                            <p>{{$product->short_description}}</p>
                                        </div>
                                    </div>
                                </figure>
                            </article>
                        </div>
                        @endforeach
                    </div>

                    <div class="shop_toolbar t_bottom">
                        <div class="pagination">
                            <ul>
                                <li class="current">1</li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li class="next"><a href="#">next</a></li>
                                <li><a href="#">>></a></li>
                            </ul>
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <!--shop wrapper end-->
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->
@endsection
