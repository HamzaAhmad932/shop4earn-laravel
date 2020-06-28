@extends('layout.app')
@section('title', 'Product Detail')

@section('page_content')
    <main class="main">
{{--        <nav aria-label="breadcrumb" class="breadcrumb-nav">--}}
{{--            <div class="container">--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>--}}
{{--                    <li class="breadcrumb-item"><a href="#">Electronics</a></li>--}}
{{--                    <li class="breadcrumb-item active" aria-current="page">Headsets</li>--}}
{{--                </ol>--}}
{{--            </div><!-- End .container -->--}}
{{--        </nav>--}}
        <div class="mb-lg-4"></div><!-- margin -->
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-single-container product-single-default">
                        <div class="row">
                            <div class="col-lg-7 col-md-6">
                                <div class="product-single-gallery">
                                    <div class="product-slider-container product-item">
                                        <div class="product-single-carousel owl-carousel owl-theme">
                                                @if(!empty($product->featured_img))
                                                    <div class="product-item">
                                                        <img class="product-single-image" src="/storage/{{$product->featured_img}}" data-zoom-image="/storage/{{$product->featured_img}}"/>
                                                    </div>
                                                @endif
                                                @if(!empty($product->img_1))
                                                    <div class="product-item">
                                                        <img class="product-single-image" src="/storage/{{$product->img_1}}" data-zoom-image="/storage/{{$product->img_1}}"/>
                                                    </div>
                                                @endif
                                                @if(!empty($product->img_2))
                                                    <div class="product-item">
                                                        <img class="product-single-image" src="/storage/{{$product->img_2}}" data-zoom-image="/storage/{{$product->img_2}}"/>
                                                    </div>
                                                @endif
                                                @if(!empty($product->img_3))
                                                    <div class="product-item">
                                                        <img class="product-single-image" src="/storage/{{$product->img_3}}" data-zoom-image="/storage/{{$product->img_3}}"/>
                                                    </div>
                                                @endif
                                                @if(!empty($product->img_4))
                                                    <div class="product-item">
                                                        <img class="product-single-image" src="/storage/{{$product->img_4}}" data-zoom-image="/storage/{{$product->img_4}}"/>
                                                    </div>
                                                @endif
                                        </div>
                                        <!-- End .product-single-carousel -->
                                        <span class="prod-full-screen">
                                                <i class="icon-plus"></i>
                                            </span>
                                    </div>
                                    <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                            @if(!empty($product->featured_img))
                                            <div class="col-3 owl-dot">
                                                <img src="/storage/{{$product->featured_img}}"/>
                                            </div>
                                            @endif
                                            @if(!empty($product->img_1))
                                                <div class="col-3 owl-dot">
                                                    <img src="/storage/{{$product->img_1}}"/>
                                                </div>
                                            @endif
                                            @if(!empty($product->img_2))
                                                <div class="col-3 owl-dot">
                                                    <img src="/storage/{{$product->img_2}}"/>
                                                </div>
                                            @endif
                                            @if(!empty($product->img_3))
                                                <div class="col-3 owl-dot">
                                                    <img src="/storage/{{$product->img_3}}"/>
                                                </div>
                                            @endif
                                            @if(!empty($product->img_4))
                                                <div class="col-3 owl-dot">
                                                    <img src="/storage/{{$product->img_4}}"/>
                                                </div>
                                            @endif
                                    </div>
                                </div><!-- End .product-single-gallery -->
                            </div><!-- End .col-lg-7 -->

                            <div class="col-lg-5 col-md-6">
                                <div class="product-single-details">
                                    <h1 class="product-title">{{$product->product_name}}</h1>

                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                        </div><!-- End .product-ratings -->

{{--                                        <a href="#" class="rating-link">( 6 Reviews )</a>--}}
                                    </div><!-- End .product-container -->

                                    <div class="price-box">
{{--                                        <span class="old-price">$81.00</span>--}}
                                        <span class="product-price">Rs.{{$product->product_price}}</span>
                                    </div><!-- End .price-box -->

                                    <div class="product-desc">
                                        <p>{{$product->short_description}}</p>
                                    </div><!-- End .product-desc -->
                                    <div style="min-height: 200px;">

                                    </div>

{{--                                    <div class="product-filters-container">--}}
{{--                                        <div class="product-single-filter">--}}
{{--                                            <label>Colors:</label>--}}
{{--                                            <ul class="config-swatch-list">--}}
{{--                                                <li class="active">--}}
{{--                                                    <a href="#" style="background-color: #6085a5;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #ab6e6e;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #b19970;"></a>--}}
{{--                                                </li>--}}
{{--                                                <li>--}}
{{--                                                    <a href="#" style="background-color: #11426b;"></a>--}}
{{--                                                </li>--}}
{{--                                            </ul>--}}
{{--                                        </div><!-- End .product-single-filter -->--}}

{{--                                        <div class="product-single-filter">--}}
{{--                                            <label>Sizes:</label>--}}
{{--                                            <ul class="config-size-list">--}}
{{--                                                <li class="active"><a href="#">S</a></li>--}}
{{--                                                <li><a href="#">M</a></li>--}}
{{--                                                <li><a href="#">L</a></li>--}}
{{--                                                <li><a href="#">XL</a></li>--}}
{{--                                            </ul>--}}
{{--                                        </div><!-- End .product-single-filter -->--}}
{{--                                    </div><!-- End .product-filters-container -->--}}

{{--                                    <div class="product-action">--}}
{{--                                        <div class="product-single-qty">--}}
{{--                                            <input class="horizontal-quantity form-control" type="text">--}}
{{--                                        </div><!-- End .product-single-qty -->--}}

{{--                                        <a href="cart.html" class="paction add-cart" title="Add to Cart">--}}
{{--                                            <span>Add to Cart</span>--}}
{{--                                        </a>--}}

{{--                                        <a href="#" class="paction add-wishlist" title="Add to Wishlist">--}}
{{--                                            <span>Add to Wishlist</span>--}}
{{--                                        </a>--}}
{{--                                    </div><!-- End .product-action -->--}}

{{--                                    <div class="product-single-share">--}}
{{--                                        <label>Share:</label>--}}
{{--                                        <!-- www.addthis.com share plugin-->--}}
{{--                                        <div class="addthis_inline_share_toolbox"></div>--}}
{{--                                    </div><!-- End .product single-share -->--}}
                                </div><!-- End .product-single-details -->
                            </div><!-- End .col-lg-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-single-container -->

                    <div class="product-single-tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="false">Description</a>
                            </li>
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" id="product-tab-size" data-toggle="tab" href="#product-size-content" role="tab" aria-controls="product-size-content" aria-selected="true">Size Guide</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-tags-content" role="tab" aria-controls="product-tags-content" aria-selected="false">Tags</a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews</a>--}}
{{--                            </li>--}}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                <div class="product-desc-content">
                                    {!! $product->description !!}
                                </div><!-- End .product-desc-content -->
                            </div><!-- End .tab-pane -->

                            <div class="tab-pane fade" id="product-size-content" role="tabpanel" aria-labelledby="product-tab-size">
                                <div class="product-size-content">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img src="assets/images/products/single/body-shape.png" alt="body shape">
                                        </div><!-- End .col-md-4 -->

                                        <div class="col-md-8">
                                            <table class="table table-size">
                                                <thead>
                                                <tr>
                                                    <th>SIZE</th>
                                                    <th>CHEST (in.)</th>
                                                    <th>WAIST (in.)</th>
                                                    <th>HIPS (in.)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>XS</td>
                                                    <td>34-36</td>
                                                    <td>27-29</td>
                                                    <td>34.5-36.5</td>
                                                </tr>
                                                <tr>
                                                    <td>S</td>
                                                    <td>36-38</td>
                                                    <td>29-31</td>
                                                    <td>36.5-38.5</td>
                                                </tr>
                                                <tr>
                                                    <td>M</td>
                                                    <td>38-40</td>
                                                    <td>31-33</td>
                                                    <td>38.5-40.5</td>
                                                </tr>
                                                <tr>
                                                    <td>L</td>
                                                    <td>40-42</td>
                                                    <td>33-36</td>
                                                    <td>40.5-43.5</td>
                                                </tr>
                                                <tr>
                                                    <td>XL</td>
                                                    <td>42-45</td>
                                                    <td>36-40</td>
                                                    <td>43.5-47.5</td>
                                                </tr>
                                                <tr>
                                                    <td>XLL</td>
                                                    <td>45-48</td>
                                                    <td>40-44</td>
                                                    <td>47.5-51.5</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div><!-- End .row -->
                                </div><!-- End .product-size-content -->
                            </div><!-- End .tab-pane -->

                            <div class="tab-pane fade" id="product-tags-content" role="tabpanel" aria-labelledby="product-tab-tags">
                                <div class="product-tags-content">
                                    <form action="#">
                                        <h4>Add Your Tags:</h4>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm" required>
                                            <input type="submit" class="btn btn-primary" value="Add Tags">
                                        </div><!-- End .form-group -->
                                    </form>
                                    <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>
                                </div><!-- End .product-tags-content -->
                            </div><!-- End .tab-pane -->

                            <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                <div class="product-reviews-content">
                                    <div class="collateral-box">
                                        <ul>
                                            <li>Be the first to review this product</li>
                                        </ul>
                                    </div><!-- End .collateral-box -->

                                    <div class="add-product-review">
                                        <h3 class="text-uppercase heading-text-color font-weight-semibold">WRITE YOUR OWN REVIEW</h3>
                                        <p>How do you rate this product? *</p>

                                        <form action="#">
                                            <table class="ratings-table">
                                                <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>1 star</th>
                                                    <th>2 stars</th>
                                                    <th>3 stars</th>
                                                    <th>4 stars</th>
                                                    <th>5 stars</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Quality</td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_1" value="1" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_2" value="2" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_3" value="3" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_4" value="4" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="ratings[1]" id="Quality_5" value="5" class="radio">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Value</td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_1" value="1" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_2" value="2" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_3" value="3" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_4" value="4" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="value[1]" id="Value_5" value="5" class="radio">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Price</td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_1" value="1" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_2" value="2" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_3" value="3" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_4" value="4" class="radio">
                                                    </td>
                                                    <td>
                                                        <input type="radio" name="price[1]" id="Price_5" value="5" class="radio">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>

                                            <div class="form-group">
                                                <label>Nickname <span class="required">*</span></label>
                                                <input type="text" class="form-control form-control-sm" required>
                                            </div><!-- End .form-group -->
                                            <div class="form-group">
                                                <label>Summary of Your Review <span class="required">*</span></label>
                                                <input type="text" class="form-control form-control-sm" required>
                                            </div><!-- End .form-group -->
                                            <div class="form-group mb-2">
                                                <label>Review <span class="required">*</span></label>
                                                <textarea cols="5" rows="6" class="form-control form-control-sm"></textarea>
                                            </div><!-- End .form-group -->

                                            <input type="submit" class="btn btn-primary" value="Submit Review">
                                        </form>
                                    </div><!-- End .add-product-review -->
                                </div><!-- End .product-reviews-content -->
                            </div><!-- End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-single-tabs -->
                </div><!-- End .col-lg-9 -->

                <div class="sidebar-overlay"></div>
                <div class="sidebar-toggle"><i class="icon-sliders"></i></div>
                <aside class="sidebar-product col-lg-3 padding-left-lg mobile-sidebar">
                    <div class="sidebar-wrapper">
                        <div class="widget widget-collapse">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true" aria-controls="widget-body-1">Categories</a>
                            </h3>

                            <div class="collapse show" id="widget-body-1">
                                <div class="widget-body">
                                    <ul class="cat-list">
                                        @foreach($all_categories as $cat)
                                            <li><a href="{{route('shop.category', $cat->id)}}">{{$cat->category_name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <div class="widget widget-banner">
                            <div class="banner banner-image">
                                <a href="#">
                                    <img src="{{asset('assets/images/banners/banner-sidebar.jpg')}}" alt="Banner Desc">
                                </a>
                            </div><!-- End .banner -->
                        </div><!-- End .widget -->

{{--                        <div class="widget widget-featured">--}}
{{--                            <h3 class="widget-title">Featured Products</h3>--}}

{{--                            <div class="widget-body">--}}
{{--                                <div class="owl-carousel widget-featured-products" data-toggle="owl" data-owl-options="{--}}
{{--                                        'lazyLoad': true,--}}
{{--                                        'nav': true,--}}
{{--                                        'dots': false,--}}
{{--                                        'autoHeight': true--}}
{{--                                    }">--}}
{{--                                    <div class="featured-col">--}}
{{--                                        <div class="product-default left-details product-widget">--}}
{{--                                            <figure>--}}
{{--                                                <a href="product.html">--}}
{{--                                                    <img src="assets/images/products/product-1.jpg">--}}
{{--                                                </a>--}}
{{--                                            </figure>--}}
{{--                                            <div class="product-details">--}}
{{--                                                <h2 class="product-title">--}}
{{--                                                    <a href="product.html">Woo Album #2</a>--}}
{{--                                                </h2>--}}
{{--                                                <div class="ratings-container">--}}
{{--                                                    <div class="product-ratings">--}}
{{--                                                        <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                                        <span class="tooltiptext tooltip-top"></span>--}}
{{--                                                    </div><!-- End .product-ratings -->--}}
{{--                                                </div><!-- End .product-container -->--}}
{{--                                                <div class="price-box">--}}
{{--                                                    <span class="product-price">$9.00</span>--}}
{{--                                                </div><!-- End .price-box -->--}}
{{--                                            </div><!-- End .product-details -->--}}
{{--                                        </div>--}}
{{--                                        <div class="product-default left-details product-widget">--}}
{{--                                            <figure>--}}
{{--                                                <a href="product.html">--}}
{{--                                                    <img src="assets/images/products/product-2.jpg">--}}
{{--                                                </a>--}}
{{--                                            </figure>--}}
{{--                                            <div class="product-details">--}}
{{--                                                <h2 class="product-title">--}}
{{--                                                    <a href="product.html">Luxury bag</a>--}}
{{--                                                </h2>--}}
{{--                                                <div class="ratings-container">--}}
{{--                                                    <div class="product-ratings">--}}
{{--                                                        <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                                        <span class="tooltiptext tooltip-top"></span>--}}
{{--                                                    </div><!-- End .product-ratings -->--}}
{{--                                                </div><!-- End .product-container -->--}}
{{--                                                <div class="price-box">--}}
{{--                                                    <span class="product-price">$350.00</span>--}}
{{--                                                </div><!-- End .price-box -->--}}
{{--                                            </div><!-- End .product-details -->--}}
{{--                                        </div>--}}
{{--                                        <div class="product-default left-details product-widget">--}}
{{--                                            <figure>--}}
{{--                                                <a href="product.html">--}}
{{--                                                    <img src="assets/images/products/product-3.jpg">--}}
{{--                                                </a>--}}
{{--                                            </figure>--}}
{{--                                            <div class="product-details">--}}
{{--                                                <h2 class="product-title">--}}
{{--                                                    <a href="product.html">Patient Ninja</a>--}}
{{--                                                </h2>--}}
{{--                                                <div class="ratings-container">--}}
{{--                                                    <div class="product-ratings">--}}
{{--                                                        <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                                        <span class="tooltiptext tooltip-top"></span>--}}
{{--                                                    </div><!-- End .product-ratings -->--}}
{{--                                                </div><!-- End .product-container -->--}}
{{--                                                <div class="price-box">--}}
{{--                                                    <span class="old-price">$35.00</span>--}}
{{--                                                    <span class="product-price">$30.00</span>--}}
{{--                                                </div><!-- End .price-box -->--}}
{{--                                            </div><!-- End .product-details -->--}}
{{--                                        </div>--}}
{{--                                    </div><!-- End .featured-col -->--}}

{{--                                    <div class="featured-col">--}}
{{--                                        <div class="product-default left-details product-widget">--}}
{{--                                            <figure>--}}
{{--                                                <a href="product.html">--}}
{{--                                                    <img src="assets/images/products/product-4.jpg">--}}
{{--                                                </a>--}}
{{--                                            </figure>--}}
{{--                                            <div class="product-details">--}}
{{--                                                <h2 class="product-title">--}}
{{--                                                    <a href="product.html">Woo Album #2</a>--}}
{{--                                                </h2>--}}
{{--                                                <div class="ratings-container">--}}
{{--                                                    <div class="product-ratings">--}}
{{--                                                        <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                                        <span class="tooltiptext tooltip-top"></span>--}}
{{--                                                    </div><!-- End .product-ratings -->--}}
{{--                                                </div><!-- End .product-container -->--}}
{{--                                                <div class="price-box">--}}
{{--                                                    <span class="product-price">$9.00</span>--}}
{{--                                                </div><!-- End .price-box -->--}}
{{--                                            </div><!-- End .product-details -->--}}
{{--                                        </div>--}}
{{--                                        <div class="product-default left-details product-widget">--}}
{{--                                            <figure>--}}
{{--                                                <a href="product.html">--}}
{{--                                                    <img src="assets/images/products/product-5.jpg">--}}
{{--                                                </a>--}}
{{--                                            </figure>--}}
{{--                                            <div class="product-details">--}}
{{--                                                <h2 class="product-title">--}}
{{--                                                    <a href="product.html">Luxury bag</a>--}}
{{--                                                </h2>--}}
{{--                                                <div class="ratings-container">--}}
{{--                                                    <div class="product-ratings">--}}
{{--                                                        <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                                        <span class="tooltiptext tooltip-top"></span>--}}
{{--                                                    </div><!-- End .product-ratings -->--}}
{{--                                                </div><!-- End .product-container -->--}}
{{--                                                <div class="price-box">--}}
{{--                                                    <span class="product-price">$350.00</span>--}}
{{--                                                </div><!-- End .price-box -->--}}
{{--                                            </div><!-- End .product-details -->--}}
{{--                                        </div>--}}
{{--                                        <div class="product-default left-details product-widget">--}}
{{--                                            <figure>--}}
{{--                                                <a href="product.html">--}}
{{--                                                    <img src="assets/images/products/product-6.jpg">--}}
{{--                                                </a>--}}
{{--                                            </figure>--}}
{{--                                            <div class="product-details">--}}
{{--                                                <h2 class="product-title">--}}
{{--                                                    <a href="product.html">Patient Ninja</a>--}}
{{--                                                </h2>--}}
{{--                                                <div class="ratings-container">--}}
{{--                                                    <div class="product-ratings">--}}
{{--                                                        <span class="ratings" style="width:0%"></span><!-- End .ratings -->--}}
{{--                                                        <span class="tooltiptext tooltip-top"></span>--}}
{{--                                                    </div><!-- End .product-ratings -->--}}
{{--                                                </div><!-- End .product-container -->--}}
{{--                                                <div class="price-box">--}}
{{--                                                    <span class="old-price">$35.00</span>--}}
{{--                                                    <span class="product-price">$30.00</span>--}}
{{--                                                </div><!-- End .price-box -->--}}
{{--                                            </div><!-- End .product-details -->--}}
{{--                                        </div>--}}
{{--                                    </div><!-- End .featured-col -->--}}
{{--                                </div><!-- End .widget-featured-slider -->--}}
{{--                            </div><!-- End .widget-body -->--}}
{{--                        </div><!-- End .widget -->--}}
                    </div>
                </aside><!-- End .col-md-3 -->
            </div><!-- End .row -->

            <div class="featured-section">
                <div class="container">
                    <h2 class="carousel-title">Featured Products</h2>

                    <div class="featured-products owl-carousel owl-theme mb-2">
                        @foreach($products as $product)
                            <div class="product-default inner-quickview inner-icon">
                                <figure>
                                    <a href="{{route('shop.product', $product->id)}}">
                                        @if(!empty($product->featured_img))
                                            <img src="{{asset('storage/'.$product->featured_img)}}">
                                        @else
                                            <img src="{{asset('assets/images/no-image-png-2.png')}}">
                                        @endif
                                    </a>
{{--                                    <div class="btn-icon-group">--}}
{{--                                        <button class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal"><i class="icon-bag"></i></button>--}}
{{--                                    </div>--}}
                                    <a href="{{route('shop.product', $product->id)}}" class="btn-quickview" title="Quick View">Quick View</a>
                                </figure>
                                <div class="product-details">
                                    <div class="category-wrap">
                                        <div class="category-list">
                                            {{--                                            <a href="category.html" class="product-category">category</a>--}}
                                        </div>
                                        <a href="{{route('shop.product', $product->id)}}" class="btn-icon-wish"><i class="icon-heart"></i></a>
                                    </div>
                                    <h2 class="product-title">
                                        <a href="{{route('shop.product', $product->id)}}">{{$product->product_name}}</a>
                                    </h2>
                                    <div class="ratings-container">
                                        <div class="product-ratings">
                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                            <span class="tooltiptext tooltip-top">0</span>
                                        </div><!-- End .product-ratings -->
                                    </div><!-- End .product-container -->
                                    <div class="price-box">
                                        {{--                                            <span class="old-price">$59.00</span>--}}
                                        <span class="product-price">Rs.{{$product->product_price}}</span>
                                    </div><!-- End .price-box -->
                                </div><!-- End .product-details -->
                            </div>
                        @endforeach
                    </div>
                </div><!-- End .product-single-tabs -->
            </div><!-- End .container -->
        </div><!-- End .featured-section -->

        <div class="mb-lg-4"></div><!-- margin -->
        </div><!-- End .container -->
    </main><!-- End .main -->
@endsection
