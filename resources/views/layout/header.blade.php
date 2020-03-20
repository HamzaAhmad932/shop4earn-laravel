
<header class="header">
    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler" type="button">
                    <i class="icon-menu"></i>
                </button>
                <a href="/" class="logo">
                    <img src="{{asset('assets/images/logos/shop4earn_logo.png')}}" alt="Porto Logo">
                </a>
            </div><!-- End .header-left -->

            <div class="header-right">
{{--                <a href="#" class="top-nav-item"><i class="icon icon-doc"></i> Register</a>--}}
                <a href="/portal/login" class="top-nav-item"><i class="icon icon-user"></i> Login</a>

{{--                <div class="dropdown cart-dropdown">--}}
{{--                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">--}}
{{--                        <i class="minicart-icon"></i>--}}
{{--                        <span class="cart-count">2</span>--}}
{{--                    </a>--}}

{{--                    <div class="dropdown-menu" >--}}
{{--                        <div class="dropdownmenu-wrapper">--}}
{{--                            <div class="dropdown-cart-header">--}}
{{--                                <span>2 Items</span>--}}

{{--                                <a href="cart.html">View Cart</a>--}}
{{--                            </div><!-- End .dropdown-cart-header -->--}}
{{--                            <div class="dropdown-cart-products">--}}
{{--                                <div class="product">--}}
{{--                                    <div class="product-details">--}}
{{--                                        <h4 class="product-title">--}}
{{--                                            <a href="product.html">Woman Ring</a>--}}
{{--                                        </h4>--}}

{{--                                        <span class="cart-product-info">--}}
{{--                                                    <span class="cart-product-qty">1</span>--}}
{{--                                                    x $99.00--}}
{{--                                                </span>--}}
{{--                                    </div><!-- End .product-details -->--}}

{{--                                    <figure class="product-image-container">--}}
{{--                                        <a href="product.html" class="product-image">--}}
{{--                                            <img src="{{asset('assets/images/products/cart/product-1.jpg')}}" alt="product">--}}
{{--                                        </a>--}}
{{--                                        <a href="#" class="btn-remove" title="Remove Product"><i class="icon-retweet"></i></a>--}}
{{--                                    </figure>--}}
{{--                                </div><!-- End .product -->--}}

{{--                                <div class="product">--}}
{{--                                    <div class="product-details">--}}
{{--                                        <h4 class="product-title">--}}
{{--                                            <a href="product.html">Woman Necklace</a>--}}
{{--                                        </h4>--}}

{{--                                        <span class="cart-product-info">--}}
{{--                                                    <span class="cart-product-qty">1</span>--}}
{{--                                                    x $35.00--}}
{{--                                                </span>--}}
{{--                                    </div><!-- End .product-details -->--}}

{{--                                    <figure class="product-image-container">--}}
{{--                                        <a href="product.html" class="product-image">--}}
{{--                                            <img src="{{asset('assets/images/products/cart/product-2.jpg')}}" alt="product">--}}
{{--                                        </a>--}}
{{--                                        <a href="#" class="btn-remove" title="Remove Product"><i class="icon-retweet"></i></a>--}}
{{--                                    </figure>--}}
{{--                                </div><!-- End .product -->--}}
{{--                            </div><!-- End .cart-product -->--}}

{{--                            <div class="dropdown-cart-total">--}}
{{--                                <span>Total</span>--}}

{{--                                <span class="cart-total-price">$134.00</span>--}}
{{--                            </div><!-- End .dropdown-cart-total -->--}}

{{--                            <div class="dropdown-cart-action">--}}
{{--                                <a href="checkout-shipping.html" class="btn btn-block">Checkout</a>--}}
{{--                            </div><!-- End .dropdown-cart-total -->--}}
{{--                        </div><!-- End .dropdownmenu-wrapper -->--}}
{{--                    </div><!-- End .dropdown-menu -->--}}
{{--                </div><!-- End .dropdown -->--}}
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    <div class="header-bottom sticky-header">
        <div class="container">
            <nav class="main-nav">
                <ul class="menu sf-arrows">
                    <li class="megamenu-container">
                        <a href="{{route('shop.category', '')}}" class="sf-with-ul">Shop</a>
                        <div class="megamenu">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        @foreach($navbar as $nav)
                                            <div class="col-lg-4">
                                                <div class="menu-title">
                                                    <a href="{{route('shop.category', $nav->id)}}">{{$nav->category_name}}</a>
                                                </div>
                                                <ul>
                                                    @foreach($nav->sub_categories as $sub_nav)
                                                        <li><a href="{{route('shop.category', $sub_nav->id)}}">{{$sub_nav->category_name}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div><!-- End .col-lg-4 -->
                                        @endforeach
                                    </div><!-- End .row -->
                                </div><!-- End .col-lg-8 -->
                                <div class="col-lg-4">
                                    <div class="banner">
                                        <a href="#">
                                            <img src="{{asset('assets/images/menu-banner.jpg')}}" alt="Menu banner" class="product-promo">
                                        </a>
                                    </div><!-- End .banner -->
                                </div><!-- End .col-lg-4 -->
                            </div><!-- End .row -->
                        </div><!-- End .megamenu -->
                    </li>
{{--                    <li class="float-right buy-effect"><a href="https://1.envato.market/DdLk5" target="_blank"><span>buy Porto</span></a></li>--}}
{{--                    <li class="float-right special-effect"><a href="#">Special Offer</a></li>--}}
                </ul>
            </nav>
        </div><!-- End .header-bottom -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->
