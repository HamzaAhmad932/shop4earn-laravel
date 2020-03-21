@extends('layout.app')
@section('title', 'Home')

@section('page_content')

    <main class="main">

{{--        <nav aria-label="breadcrumb" class="breadcrumb-nav">--}}
{{--            <div class="container">--}}
{{--                <ol class="breadcrumb">--}}
{{--                    <li class="breadcrumb-item"><a href="index-2.html">Home</a></li>--}}
{{--                    <li class="breadcrumb-item"><a href="#">Men</a></li>--}}
{{--                    <li class="breadcrumb-item active" aria-current="page">Accessories</li>--}}
{{--                </ol>--}}
{{--            </div><!-- End .container -->--}}
{{--        </nav>--}}

        <div class="container">
            <div class="mt-4"></div>
            <div class="row">
                <div class="col-lg-9">
{{--                    <nav class="toolbox">--}}
{{--                        <div class="toolbox-left">--}}
{{--                            <div class="toolbox-item toolbox-sort">--}}
{{--                                <div class="select-custom">--}}
{{--                                    <select name="orderby" class="form-control">--}}
{{--                                        <option value="menu_order" selected="selected">Default Sorting</option>--}}
{{--                                        <option value="popularity">Sort by popularity</option>--}}
{{--                                        <option value="rating">Sort by average rating</option>--}}
{{--                                        <option value="date">Sort by newness</option>--}}
{{--                                        <option value="price">Sort by price: low to high</option>--}}
{{--                                        <option value="price-desc">Sort by price: high to low</option>--}}
{{--                                    </select>--}}
{{--                                </div><!-- End .select-custom -->--}}

{{--                                <a href="#" class="sorter-btn" title="Set Ascending Direction"><span class="sr-only">Set Ascending Direction</span></a>--}}
{{--                            </div><!-- End .toolbox-item -->--}}
{{--                        </div><!-- End .toolbox-left -->--}}

{{--                        <div class="toolbox-item toolbox-show">--}}
{{--                            <label>Showing 1–9 of 60 results</label>--}}
{{--                        </div><!-- End .toolbox-item -->--}}

{{--                        <div class="layout-modes">--}}
{{--                            <a href="category.html" class="layout-btn btn-grid active" title="Grid">--}}
{{--                                <i class="icon-mode-grid"></i>--}}
{{--                            </a>--}}
{{--                            <a href="category-list.html" class="layout-btn btn-list" title="List">--}}
{{--                                <i class="icon-mode-list"></i>--}}
{{--                            </a>--}}
{{--                        </div><!-- End .layout-modes -->--}}
{{--                    </nav>--}}

                    <div class="row row-sm">
                        @foreach($products as $product)
                            <div class="col-6 col-md-4 col-xl-3">
                                <div class="product-default inner-quickview inner-icon">
                                    <figure>
                                        <a href="#">
                                            @if(!empty($product->productImages[0]))
                                                <img src="{{asset('storage/'.$product->productImages[0]->url)}}">
                                            @else
                                                <img src="{{asset('assets/images/no-image-png-2.png')}}">
                                            @endif
                                        </a>
                                        <div class="btn-icon-group">
                                            <button class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal"><i class="icon-bag"></i></button>
                                        </div>
                                        <a href="#" class="btn-quickview" title="Quick View">Quick View</a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="category-wrap">
                                            <div class="category-list">
    {{--                                            <a href="category.html" class="product-category">category</a>--}}
                                            </div>
                                            <a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>
                                        </div>
                                        <h2 class="product-title">
                                            <a href="product.html">{{$product->product_name}}</a>
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
                            </div>
                        @endforeach
                    </div>

                    <nav class="toolbox toolbox-pagination">
                        <div class="toolbox-item toolbox-show">
                            <label>Showing 1–9 of 60 results</label>
                        </div><!-- End .toolbox-item -->

                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><span>...</span></li>
                            <li class="page-item"><a class="page-link" href="#">15</a></li>
                            <li class="page-item">
                                <a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div><!-- End .col-lg-9 -->

                <aside class="sidebar-shop col-lg-3 order-lg-first">
                    <div class="sidebar-wrapper">
                        <div class="widget">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="false" aria-controls="widget-body-1" class="collapsed">Categories</a>
                            </h3>

                            <div class="collapse hide" id="widget-body-1">
                                <div class="widget-body">
                                    <ul class="cat-list">
                                        @foreach($all_categories as $cat)
                                            <li><a href="{{route('shop.category', $cat->id)}}">{{$cat->category_name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

{{--                        <div class="widget">--}}
{{--                            <h3 class="widget-title">--}}
{{--                                <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Men</a>--}}
{{--                            </h3>--}}

{{--                            <div class="collapse show" id="widget-body-2">--}}
{{--                                <div class="widget-body">--}}
{{--                                    <ul class="cat-list">--}}
{{--                                        <li><a href="#">Accessories</a></li>--}}
{{--                                        <li><a href="#">Watch Fashion</a></li>--}}
{{--                                        <li><a href="#">Tees, Knits & Polos</a></li>--}}
{{--                                        <li><a href="#">Pants & Denim</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div><!-- End .widget-body -->--}}
{{--                            </div><!-- End .collapse -->--}}
{{--                        </div><!-- End .widget -->--}}

{{--                        <div class="widget">--}}
{{--                            <h3 class="widget-title">--}}
{{--                                <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true" aria-controls="widget-body-3">Price</a>--}}
{{--                            </h3>--}}

{{--                            <div class="collapse show" id="widget-body-3">--}}
{{--                                <div class="widget-body">--}}
{{--                                    <form action="#">--}}
{{--                                        <div class="price-slider-wrapper">--}}
{{--                                            <div id="price-slider"></div><!-- End #price-slider -->--}}
{{--                                        </div><!-- End .price-slider-wrapper -->--}}

{{--                                        <div class="filter-price-action">--}}
{{--                                            <div class="filter-price-text">--}}
{{--                                                Price:--}}
{{--                                                <span id="filter-price-range"></span>--}}
{{--                                            </div><!-- End .filter-price-text -->--}}

{{--                                            <button type="submit" class="btn btn-primary">Filter</button>--}}
{{--                                        </div><!-- End .filter-price-action -->--}}
{{--                                    </form>--}}
{{--                                </div><!-- End .widget-body -->--}}
{{--                            </div><!-- End .collapse -->--}}
{{--                        </div><!-- End .widget -->--}}

{{--                        <div class="widget">--}}
{{--                            <h3 class="widget-title">--}}
{{--                                <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true" aria-controls="widget-body-4">Size</a>--}}
{{--                            </h3>--}}

{{--                            <div class="collapse show" id="widget-body-4">--}}
{{--                                <div class="widget-body">--}}
{{--                                    <ul class="cat-list">--}}
{{--                                        <li><a href="#">Small</a></li>--}}
{{--                                        <li><a href="#">Medium</a></li>--}}
{{--                                        <li><a href="#">Large</a></li>--}}
{{--                                        <li><a href="#">Extra Large</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div><!-- End .widget-body -->--}}
{{--                            </div><!-- End .collapse -->--}}
{{--                        </div><!-- End .widget -->--}}

{{--                        <div class="widget">--}}
{{--                            <h3 class="widget-title">--}}
{{--                                <a data-toggle="collapse" href="#widget-body-5" role="button" aria-expanded="true" aria-controls="widget-body-5">Brand</a>--}}
{{--                            </h3>--}}

{{--                            <div class="collapse show" id="widget-body-5">--}}
{{--                                <div class="widget-body">--}}
{{--                                    <ul class="cat-list">--}}
{{--                                        <li><a href="#">Adidas</a></li>--}}
{{--                                        <li><a href="#">Calvin Klein (26)</a></li>--}}
{{--                                        <li><a href="#">Diesel (3)</a></li>--}}
{{--                                        <li><a href="#">Lacoste (8)</a></li>--}}
{{--                                    </ul>--}}
{{--                                </div><!-- End .widget-body -->--}}
{{--                            </div><!-- End .collapse -->--}}
{{--                        </div><!-- End .widget -->--}}

{{--                        <div class="widget">--}}
{{--                            <h3 class="widget-title">--}}
{{--                                <a data-toggle="collapse" href="#widget-body-6" role="button" aria-expanded="true" aria-controls="widget-body-6">Color</a>--}}
{{--                            </h3>--}}

{{--                            <div class="collapse show" id="widget-body-6">--}}
{{--                                <div class="widget-body">--}}
{{--                                    <ul class="config-swatch-list">--}}
{{--                                        <li class="active">--}}
{{--                                            <a href="#">--}}
{{--                                                <span class="color-panel" style="background-color: #1645f3;"></span>--}}
{{--                                                <span>Blue</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#">--}}
{{--                                                <span class="color-panel" style="background-color: #f11010;"></span>--}}
{{--                                                <span>Red</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#">--}}
{{--                                                <span class="color-panel" style="background-color: #fe8504;"></span>--}}
{{--                                                <span>Orange</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#">--}}
{{--                                                <span class="color-panel" style="background-color: #2da819;"></span>--}}
{{--                                                <span>Green</span>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div><!-- End .widget-body -->--}}
{{--                            </div><!-- End .collapse -->--}}
{{--                        </div><!-- End .widget -->--}}
                    </div><!-- End .sidebar-wrapper -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
    </main><!-- End .main -->
@endsection
