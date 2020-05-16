@extends('layout.app')
@section('title', 'Home')

@section('page_content')
    <main class="main home">
            <div class="home-top-container">
                <div class="home-slider owl-carousel owl-theme owl-carousel-lazy">
                    @foreach($slider as $image)
                    <div class="home-slide" style="background-image: url('{{asset('storage/'.$image->url)}}');">
                        <img class="owl-lazy" src="{{asset('storage/'.$image->url)}}" alt="slider image">
{{--                        <div class="home-slide-content container">--}}
{{--                            <div>--}}
{{--                                <h2 class="home-slide-subtitle">start the revolution</h2>--}}
{{--                                <h1 class="home-slide-title">--}}
{{--                                    drone pro 4--}}
{{--                                </h1>--}}
{{--                                <h2 class="home-slide-foot">from <span>$499</span></h2>--}}
{{--                                <button class="btn btn-dark btn-buy">BUY NOW</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- End .home-slide-content -->--}}
                    </div><!-- End .home-slide -->
                    @endforeach

{{--                    <div class="home-slide" style="background-image: url('assets/images/slider/slide2.jpg');">--}}
{{--                        <img class="owl-lazy" src="{{asset('assets/images/lazy.png')}}" alt="slider image">--}}
{{--                        <div class="home-slide-content container">--}}
{{--                            <div>--}}
{{--                                <h2 class="home-slide-subtitle">amazing deals</h2>--}}
{{--                                <h1 class="home-slide-title">--}}
{{--                                    smartphone--}}
{{--                                </h1>--}}
{{--                                <h2 class="home-slide-foot">from <span>$199</span></h2>--}}
{{--                                <button class="btn btn-dark btn-buy">BUY NOW</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- End .home-slide-content -->--}}
{{--                    </div><!-- End .home-slide -->--}}

{{--                    <div class="home-slide" style="background-image: url('assets/images/slider/slide3.jpg');">--}}
{{--                        <img class="owl-lazy" src="{{asset('assets/images/lazy.png')}}" alt="slider image">--}}
{{--                        <div class="home-slide-content container">--}}
{{--                            <div>--}}
{{--                                <h2 class="home-slide-subtitle">best price of the year</h2>--}}
{{--                                <h1 class="home-slide-title">--}}
{{--                                    top accessories--}}
{{--                                </h1>--}}
{{--                                <h2 class="home-slide-foot">from <span>$19</span></h2>--}}
{{--                                <button class="btn btn-dark btn-buy">BUY NOW</button>--}}
{{--                            </div>--}}
{{--                        </div><!-- End .home-slide-content -->--}}
{{--                    </div><!-- End .home-slide -->--}}
                </div>
                <div class="home-slider-sidebar">
                    <ul>
                        <li class="active"></li>
                        <li></li>
                        <li></li>
                    </ul>
                </div>
            </div><!-- End .home-slider -->

{{--            <section class="product-panel mt-5">--}}
{{--                <div class="container">--}}
{{--                    <div class="section-title">--}}
{{--                        <h2>Featured Products</h2>--}}
{{--                    </div>--}}
{{--                    <div class="product-intro divide-line mt-2 mb-8">--}}
{{--                        @foreach($featured_products as $product)--}}
{{--                            <div class="col-6 col-lg-2 col-md-3 col-sm-4 product-default inner-quickview inner-icon">--}}
{{--                                <figure>--}}
{{--                                    <a href="product.html">--}}
{{--                                        @if(!empty($product->productImages[0]))--}}
{{--                                            <img src="{{asset('storage/'.$product->productImages[0]->url)}}">--}}
{{--                                        @else--}}
{{--                                            <img src="{{asset('assets/images/no-image-png-2.png')}}">--}}
{{--                                        @endif--}}
{{--                                    </a>--}}
{{--                                    <div class="btn-icon-group">--}}
{{--                                        <button class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal"><i class="icon-bag"></i></button>--}}
{{--                                    </div>--}}
{{--                                    <a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View">Quick View</a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details">--}}
{{--                                    <div class="category-wrap">--}}
{{--                                        <div class="category-list">--}}
{{--                                            <a href="category.html" class="product-category">{{$product->category->category_name}}</a>--}}
{{--                                        </div>--}}
{{--                                        <a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>--}}
{{--                                    </div>--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">{{$product->product_name}}</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top">0</span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="old-price">$59.00</span>--}}
{{--                                        <span class="product-price">Rs.{{$product->product_price}}</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </section>--}}

{{--            <section class="categories-container">--}}
{{--                <div class="container categories-carousel owl-carousel owl-theme" data-toggle="owl" data-owl-options="{--}}
{{--                    'loop' : false,--}}
{{--                    'margin': 30,--}}
{{--                    'nav': false,--}}
{{--                    'dots': true,--}}
{{--                    'autoHeight': true,--}}
{{--                    'responsive': {--}}
{{--                      '0': {--}}
{{--                        'items': 2,--}}
{{--                        'margin': 0--}}
{{--                      },--}}
{{--                      '576': {--}}
{{--                        'items': 3--}}
{{--                      },--}}
{{--                      '768': {--}}
{{--                        'items': 4--}}
{{--                      },--}}
{{--                      '992': {--}}
{{--                        'items': 5--}}
{{--                      },--}}
{{--                      '1200': {--}}
{{--                        'items': 6--}}
{{--                      }--}}
{{--                    }--}}
{{--                }">--}}
{{--                    <div class="category">--}}
{{--                        <i class="icon-category-fashion"></i>--}}
{{--                        <span>Fashion</span>--}}
{{--                    </div>--}}
{{--                    <div class="category">--}}
{{--                        <i class="icon-category-electronics"></i>--}}
{{--                        <span>Electronics</span>--}}
{{--                    </div>--}}
{{--                    <div class="category">--}}
{{--                        <i class="icon-gift"></i>--}}
{{--                        <span>Gift</span>--}}
{{--                    </div>--}}
{{--                    <div class="category">--}}
{{--                        <i class="icon-category-garden"></i>--}}
{{--                        <span>Garden</span>--}}
{{--                    </div>--}}
{{--                    <div class="category">--}}
{{--                        <i class="icon-category-music"></i>--}}
{{--                        <span>Music</span>--}}
{{--                    </div>--}}
{{--                    <div class="category">--}}
{{--                        <i class="icon-category-motors"></i>--}}
{{--                        <span>Motors</span>--}}
{{--                    </div>--}}
{{--                </div><!-- End .categories-carousel -->--}}
{{--            </section><!-- End .categories-container -->--}}

            <section class="home-products-intro mt-3 mb-1">
                <div class="container">
                    <div class="row row-sm">
                        <div class="col-xl-6">
                            <div class="banner-product bg-grey">
                                @if(!empty($banners[0]))
                                    <img src="{{asset('storage/'.$banners[0]->url)}}" alt="">
                                @else
                                    Banner 1 not attached
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="banner-product bg-grey">
                                @if(!empty($banners[1]))
                                    <img src="{{asset('storage/'.$banners[1]->url)}}" alt="">
                                @else
                                    Banner 2 not attached
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="home-products-intro bg-grey" id="specialOffer" style="padding: 4.5rem 0 2rem;">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="section-title">
                                <h2>Special Offer</h2>
                            </div>
                            <div class="banner-product mt-3">
                                @if(!empty($banners[2]))
                                    <img src="{{asset('storage/'.$banners[2]->url)}}" alt="">
                                @else
                                    Banner 3 not attached
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="home-product-tabs">
                                <ul class="nav nav-tabs mb-3" role="tablist">
                                    @foreach($special_offers as $k=> $category)
                                    <li class="nav-item">
                                        <a class="nav-link @if($k == 0) active @endif}}" id="{{$category->slug}}-tab" data-toggle="tab" href="#{{$category->slug}}" role="tab" aria-controls="{{$category->slug}}" aria-selected="true">{{$category->category_name}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach($special_offers as $k=> $offer)
                                        <div class="tab-pane fade show @if($k == 0) active @endif}}" id="{{$offer->slug}}" role="tabpanel" aria-labelledby="{{$offer->slug}}-tab">
                                            <div class="row row-sm">
                                                @if(!$offer->products->isEmpty())
                                                    @foreach($offer->products as $product)
                                                        <div class="col-6 col-md-3">
                                                            <div class="product-default inner-quickview inner-icon">
                                                                <figure>
                                                                    <a href="{{route('shop.product', $product->id)}}">
                                                                        @if(!empty($product->featured_img))
                                                                            <img src="{{asset('storage/'.$product->featured_img)}}">
                                                                        @else
                                                                            <img src="{{asset('assets/images/no-image-png-2.png')}}">
                                                                        @endif
                                                                    </a>
                                                                    <a href="{{route('shop.product', $product->id)}}" class="btn-quickview" title="Quick View">Quick View</a>
                                                                </figure>
                                                                <div class="product-details">
                                                                    <div class="category-wrap">
                                                                        <div class="category-list">
                                                                            <a href="{{route('shop.category', $offer->id)}}" class="product-category">{{$offer->category_name}}</a>
                                                                        </div>
                                                                        <a href="{{route('shop.product', $product->id)}}" class="btn-icon-wish"><i class="icon-heart"></i></a>
                                                                    </div>
                                                                    <h2 class="product-title">
                                                                        <a href="{{route('shop.product', $product->id)}}">{{$product->product_name}}</a>
                                                                    </h2>
                                                                    <div class="price-box">
                                                                        <span class="product-price">Rs. {{$product->product_price}}</span>
                                                                    </div><!-- End .price-box -->
                                                                </div><!-- End .product-details -->
                                                            </div>
                                                        </div><!-- End .col-md-4 -->
                                                    @endforeach
                                                @endif
                                            </div><!-- End .row -->
                                        </div><!-- End .tab-pane -->
                                    @endforeach
                                </div><!-- End .tab-content -->
                            </div><!-- End .home-product-tabs -->
                        </div>
                    </div>
                </div>
            </section>

{{--            <section class="mt-3 mb-3">--}}
{{--                <div class="container">--}}
{{--                    <div class="owl-carousel owl-theme text-center" data-toggle="owl" data-owl-options="{--}}
{{--                        'loop' : false,--}}
{{--                        'nav': false,--}}
{{--                        'dots': true,--}}
{{--                        'margin': 20,--}}
{{--                        'autoHeight': true,--}}
{{--                        'autoplay': true,--}}
{{--                        'autoplayTimeout': 5000,--}}
{{--                        'responsive': {--}}
{{--                          '0': {--}}
{{--                            'items': 2--}}
{{--                          },--}}
{{--                          '570': {--}}
{{--                            'items': 2--}}
{{--                          },--}}
{{--                          '830': {--}}
{{--                            'items': 3--}}
{{--                          },--}}
{{--                          '1220': {--}}
{{--                            'items': 4--}}
{{--                          }--}}
{{--                        }--}}
{{--                    }">--}}
{{--                        <div class="home-product-list">--}}
{{--                            <img src="assets/images/products/small/product-white-1.jpg">--}}
{{--                            <div class="product-details">--}}
{{--                                <h4 class="product-title">--}}
{{--                                    <a href="product.html">Top Sharp <br>Knives</a>--}}
{{--                                </h4>--}}
{{--                                <button  class="btn btn-dark">SHOP NOW</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="home-product-list">--}}
{{--                            <img src="assets/images/products/small/product-white-2.jpg">--}}
{{--                            <div class="product-details">--}}
{{--                                <h4 class="product-title">--}}
{{--                                    <a href="product.html">HD Vision <br>Web Cameras</a>--}}
{{--                                </h4>--}}
{{--                                <button  class="btn btn-dark">SHOP NOW</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="home-product-list">--}}
{{--                            <img src="assets/images/products/small/product-white-3.jpg">--}}
{{--                            <div class="product-details">--}}
{{--                                <h4 class="product-title">--}}
{{--                                    <a href="product.html">Mobiles <br>And Tablets</a>--}}
{{--                                </h4>--}}
{{--                                <button  class="btn btn-dark">SHOP NOW</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="home-product-list">--}}
{{--                            <img src="assets/images/products/small/product-white-4.jpg">--}}
{{--                            <div class="product-details">--}}
{{--                                <h4 class="product-title">--}}
{{--                                    <a href="product.html">Smart <br> Watches</a>--}}
{{--                                </h4>--}}
{{--                                <button  class="btn btn-dark">SHOP NOW</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </section>--}}

            <section class="bg-grey">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="icon-shipping"></i>

                                <div class="info-box-content">
                                    <h4 class="info-title">FREE SHIPPING & RETURNS</h4>
                                    <h4 class="info-subtitle">For All Orders</h4>
{{--                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapibus.</p>--}}
                                </div><!-- End .info-box-content -->
                            </div><!-- End .info-box -->
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="icon-money"></i>

                                <div class="info-box-content">
                                    <h4 class="info-title">MONEY BACK GUARANTEE</h4>
                                    <h4 class="info-subtitle">Safe & Fast</h4>
{{--                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapibus.</p>--}}
                                </div><!-- End .info-box-content -->
                            </div><!-- End .info-box -->
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <i class="icon-support"></i>

                                <div class="info-box-content">
                                    <h4 class="info-title">ONLINE SUPPORT</h4>
                                    <h4 class="info-subtitle">Need Assistence?</h4>
{{--                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis nec vestibulum magna, et dapibus.</p>--}}
                                </div><!-- End .info-box-content -->
                            </div><!-- End .info-box -->
                        </div>
                    </div>
                </div><!-- End .container -->
            </section><!-- End .info-boxes-container -->

{{--            <section class="home-products-intro" id="topProducts" style="padding : 7rem 0 1rem;">--}}
{{--                <div class="container">--}}
{{--                    <div class="row row-sm">--}}
{{--                        <div class="col-sm-6 col-xl-3">--}}
{{--                            <div class="section-title mb-4">--}}
{{--                                <h4>Featured Products</h4>--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-1.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-2.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-3.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-6 col-xl-3">--}}
{{--                            <div class="section-title mb-4">--}}
{{--                                <h4>Top Selling Products</h4>--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-4.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-5.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-6.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-6 col-xl-3">--}}
{{--                            <div class="section-title mb-4">--}}
{{--                                <h4>On Sale Products</h4>--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-7.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-8.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                            <div class="product-default left-details row row-sm mb-0">--}}
{{--                                <figure class="col-4">--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-9.jpg">--}}
{{--                                    </a>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details col-8">--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">Product Short Name</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-6 col-xl-3">--}}
{{--                            <div class="product-default inner-quickview inner-icon center-details count-down">--}}
{{--                                <h2 class="product-name">Flash Deals</h2>--}}
{{--                                <figure>--}}
{{--                                    <a href="product.html">--}}
{{--                                        <img src="assets/images/products/product-deal.jpg">--}}
{{--                                    </a>--}}
{{--                                    <div class="label-group">--}}
{{--                                        <span class="product-label label-primary">SALE</span>--}}
{{--                                        <span class="product-label label-dark">- 90%</span>--}}
{{--                                    </div>--}}
{{--                                </figure>--}}
{{--                                <div class="product-details">--}}
{{--                                    <h2 class="product-title">--}}
{{--                                        <a href="product.html">1080p Wifi IP Camera</a>--}}
{{--                                    </h2>--}}
{{--                                    <div class="ratings-container">--}}
{{--                                        <div class="product-ratings">--}}
{{--                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->--}}
{{--                                            <span class="tooltiptext tooltip-top"></span>--}}
{{--                                        </div><!-- End .product-ratings -->--}}
{{--                                    </div><!-- End .product-container -->--}}
{{--                                    <div class="price-box">--}}
{{--                                        <span class="old-price">$59.00</span>--}}
{{--                                        <span class="product-price">$49.00</span>--}}
{{--                                    </div><!-- End .price-box -->--}}
{{--                                </div><!-- End .product-details -->--}}
{{--                                <div class="count-down-panel">--}}
{{--                                    <h4>OFFER ENDS IN:--}}
{{--                                        <span class="countdown" data-plugin-countdown data-plugin-options="{'date': '2020/06/10 12:00:00', 'numberClass': 'font-weight-extra-bold'}"></span>--}}
{{--                                    </h4>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </section>--}}

        </main><!-- End .main -->
@endsection
