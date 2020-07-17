@extends('layout.app')
@section('title', 'Home')

@section('page_content')

    <!--slider area start-->
    <section class="slider_section slider_s_four mt-23" style="margin-bottom: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="slider_area owl-carousel">
                        @foreach($slider as $s)
                        <div class="single_slider d-flex align-items-center" data-bgimg="{{Voyager::image(urlopt($s->url))}}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--slider area end-->

    <!--our services area-->
    <div class="our_services mb-15">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="services_title">
                        <h2>OUR PRODUCTS</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--our services area end-->

    <!--services section area-->
    <div class="unlimited_services">
        <div class="container">
            @foreach($our_products as $k=> $product)
                <div class="row align-items-center mb-15">
                    <div class="col-lg-6 col-md-12">
                        @if($k % 2 == 0)
                            <div class="unlimited_services_content">
                                <h1><a href="{{route('shop.product', $product->id)}}">{{$product->product_name}}</a></h1>
                                <h4><span class="current_price">Rs. {{$product->product_price}}</span></h4>
                                <p>{{$product->short_description}}</p>
                                <div class="view__work">
                                    <a href="{{route('shop.product', $product->id)}}">MORE INFO  <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        @else
                            <div class="services_section_thumb">
                                @if(!empty($product->featured_img))
                                    <img src="{{Voyager::image($product->featured_img)}}" alt="">
                                @else
                                    <img src="{{asset('assets/images/no-image-png-2.png')}}" alt="">
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-12">
                        @if($k % 2 != 0)
                            <div class="unlimited_services_content">
                                <h1><a href="{{route('shop.product', $product->id)}}">{{$product->product_name}}</a></h1>
                                <h4><span class="current_price">Rs. {{$product->product_price}}</span></h4>
                                <p>{{$product->short_description}}</p>
                                <div class="view__work">
                                    <a href="{{route('shop.product', $product->id)}}">MORE INFO  <i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        @else
                            <div class="services_section_thumb">
                                @if(!empty($product->featured_img))
                                    <img src="{{Voyager::image($product->featured_img)}}" alt="">
                                @else
                                    <img src="{{asset('assets/images/no-image-png-2.png')}}" alt="">
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!--services section end-->

    <!--product area start-->
    <div class="product_area product_style4 color_three mb-70">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section_title section_title_style4">
                        <h2>TOP Products</h2>
                    </div>
                </div>
            </div>
            <div class="product_carousel4 product_column4 owl-carousel">
                @foreach($our_products as $k=> $product)
                    <article class="single_product">
                    <figure>
                        <div class="product_thumb">
                            <a class="primary_img" href="{{route('shop.product', $product->id)}}">
                                @if(!empty($product->featured_img))
                                    <img src="{{Voyager::image($product->featured_img)}}" alt="">
                                @else
                                    <img src="{{asset('assets/images/no-image-png-2.png')}}" alt="">
                                @endif
                            </a>
                            <a class="secondary_img" href="{{route('shop.product', $product->id)}}">
                                @if(!empty($product->img_1))
                                    <img src="{{Voyager::image($product->img_1)}}" alt="">
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
                @endforeach
            </div>
        </div>
    </div>
    <!--product area end-->

    <!--banner area start-->
    <div class="banner_area banner_four mb-68">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            @if(!empty($banners[0]))
                                <img src="{{Voyager::image($banners[0]->url)}}" alt="">
                            @else
                                Banner 1 not attached
                            @endif
                        </div>
                    </figure>
                </div>
                <div class="col-lg-6 col-md-6">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            @if(!empty($banners[1]))
                                <img src="{{Voyager::image($banners[1]->url)}}" alt="">
                            @else
                                Banner 2 not attached
                            @endif
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->

    <!--deals section three start-->
    <div class="deals_section_three mb-68">
        <div class="container">
            <div class="row">
                <div class="deals_carousel_three deals_product_column1 owl-carousel">
                    @foreach($our_products as $k=> $product)
                        <div class="col-12">
                        <article class="single_product">
                            <figure>
                                <div class="product_thumb">
                                    <a class="primary_img" href="{{route('shop.product', $product->id)}}">
                                        @if(!empty($product->featured_img))
                                            <img src="{{Voyager::image($product->featured_img)}}" alt="">
                                        @else
                                            <img src="{{asset('assets/images/no-image-png-2.png')}}" alt="">
                                        @endif
                                    </a>
                                    <a class="secondary_img" href="{{route('shop.product', $product->id)}}">
                                        @if(!empty($product->img_1))
                                            <img src="{{Voyager::image($product->img_1)}}" alt="">
                                        @else
                                            <img src="{{asset('assets/images/no-image-png-2.png')}}" alt="">
                                        @endif
                                    </a>
{{--                                    <div class="product_timing">--}}
{{--                                        <div data-countdown="2022/12/15"></div>--}}
{{--                                    </div>--}}
                                </div>
                                <figcaption class="product_content">
                                    <div class="deals_title">
                                        <h2>Deals of the day</h2>
                                    </div>
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
                                    <div class="product_desc">
                                        <p>{{$product->short_description}}</p>
                                    </div>
                                    <div class="price_box">
{{--                                        <span class="old_price">$190.00</span>--}}
                                        <span class="current_price">Rs. {{$product->product_price}}</span>
                                    </div>
                                    <div class="cart_link_button">
                                        <a href="#" title="Add to cart"><i class="zmdi zmdi-shopping-cart"></i> Add to Cart</a>
                                    </div>
                                </figcaption>
                            </figure>
                        </article>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!--deals section three end-->

    <!--banner area start-->
    <div class="banner_area banner_four mb-68">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <figure class="single_banner">
                        <div class="banner_thumb">
                            <a href="#">
                                @if(!empty($banners[2]))
                                    <img src="{{Voyager::image($banners[2]->url)}}" alt="">
                                @else
                                    Banner 3 not attached
                                @endif
                            </a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
    </div>
    <!--banner area end-->

@endsection
