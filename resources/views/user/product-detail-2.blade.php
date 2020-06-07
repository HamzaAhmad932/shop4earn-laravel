@extends('layout.app')
@section('title', 'Product Detail')

@section('page_content')
    <!--product details start-->
    <div class="product_details mt-60 mb-60">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="product-details-tab">
                        <div id="img-1" class="zoomWrapper single-zoom">
                            <a href="#">
                                @if(!empty($product->featured_img))
                                    <img id="zoom1" src="/storage/{{urlopt($product->featured_img)}}" data-zoom-image="/storage/{{urlopt($product->featured_img)}}" alt="big-1">
                                @endif
                            </a>
                        </div>
                        <div class="single-zoom-thumb">
                            <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                @if(!empty($product->featured_img))
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="/storage/{{urlopt($product->featured_img)}}" data-zoom-image="/storage/{{urlopt($product->featured_img)}}">
                                            <img src="/storage/{{urlopt($product->featured_img)}}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($product->img_1))
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="/storage/{{urlopt($product->img_1)}}" data-zoom-image="/storage/{{urlopt($product->img_1)}}">
                                            <img src="/storage/{{urlopt($product->img_1)}}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($product->img_2))
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="/storage/{{urlopt($product->img_2)}}" data-zoom-image="/storage/{{urlopt($product->img_2)}}">
                                            <img src="/storage/{{urlopt($product->img_2)}}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($product->img_3))
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="/storage/{{urlopt($product->img_3)}}" data-zoom-image="/storage/{{urlopt($product->img_3)}}">
                                            <img src="/storage/{{urlopt($product->img_3)}}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endif
                                @if(!empty($product->img_4))
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="/storage/{{urlopt($product->img_4)}}" data-zoom-image="/storage/{{urlopt($product->img_4)}}">
                                            <img src="/storage/{{urlopt($product->img_4)}}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="product_d_right">
                        <form action="#">

                            <h1>{{$product->product_name}}</h1>
                            <div class="product_nav">
                                <ul>
                                    <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                    <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            </div>
                            <div class=" product_ratting">
                                <ul>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li class="review"><a href="#"> (customer review ) </a></li>
                                </ul>

                            </div>
                            <div class="price_box">
                                <span class="current_price">Rs.{{$product->product_price}}</span>
{{--                                <span class="old_price">$80.00</span>--}}

                            </div>
                            <div class="product_desc">
                                <p>{{$product->short_description}}</p>
                            </div>
{{--                            <div class="product_variant color">--}}
{{--                                <h3>Available Options</h3>--}}
{{--                                <label>color</label>--}}
{{--                                <ul>--}}
{{--                                    <li class="color1"><a href="#"></a></li>--}}
{{--                                    <li class="color2"><a href="#"></a></li>--}}
{{--                                    <li class="color3"><a href="#"></a></li>--}}
{{--                                    <li class="color4"><a href="#"></a></li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
                            <div class="product_variant quantity">
                                <label>quantity</label>
                                <input min="1" max="100" value="1" type="number">
                                <button class="button" type="submit">add to cart</button>

                            </div>
                            <div class=" product_d_action">
                                <ul>
                                    <li><a href="#" title="Add to wishlist">+ Add to Wishlist</a></li>
{{--                                    <li><a href="#" title="Add to wishlist">+ Compare</a></li>--}}
                                </ul>
                            </div>
                            <div class="product_meta">
                                <span>Category:
                                    @foreach($all_categories as $cat)
                                        <a href="{{route('shop.category', $cat->id)}}">{{$cat->category_name}}</a>
                                    @endforeach
                                </span>
                            </div>
                        </form>
                        <div class="priduct_social">
                            <ul>
                                <li><a class="facebook" href="#" title="facebook"><i class="fa fa-facebook"></i> Like</a></li>
                                <li><a class="twitter" href="#" title="twitter"><i class="fa fa-twitter"></i> tweet</a></li>
                                <li><a class="pinterest" href="#" title="pinterest"><i class="fa fa-pinterest"></i> save</a></li>
                                <li><a class="google-plus" href="#" title="google +"><i class="fa fa-google-plus"></i> share</a></li>
                                <li><a class="linkedin" href="#" title="linkedin"><i class="fa fa-linkedin"></i> linked</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product details end-->

    <!--product info start-->
    <div class="product_d_info mb-58">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product_d_inner">
                        <div class="product_info_button">
                            <ul class="nav" role="tablist">
                                <li >
                                    <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">Specification</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                <div class="product_info_content">
                                    {!! $product->description !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="sheet" role="tabpanel" >
                                <div class="product_info_content">
                                    {!! $product->specification !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--product info end-->

    <!--product area start-->
    <section class="product_area related_products">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="product_carousel product_column4 owl-carousel">
                    @foreach($products as $k=> $product)
                        <div class="col-lg-3">
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
                                <figcaption class="product_content">
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
                                        {{--                                <span class="old_price"></span>--}}
                                        <span class="current_price">Rs. {{$product->product_price}}</span>
                                    </div>

                                </figcaption>
                            </figure>
                        </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!--product area end-->
@endsection
