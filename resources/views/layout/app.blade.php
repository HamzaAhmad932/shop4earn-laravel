<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Shop4Earn - @yield('title')</title>
    @include('layout.head')
    @stack('below_style')
</head>
<body>

    <div class="page-wrapper">
        @include('layout.header')
        @yield('page_content')
        @include('layout.footer')
    </div><!-- End .page-wrapper -->

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-retweet"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">

                    <li>
                        <a href="{{route('shop.category', '')}}">Shop</a>
                        <ul>
                            @foreach($navbar as $nav)
                            <li>
                                <a href="{{route('shop.category', $nav->id)}}">{{$nav->category_name}}</a>
                                <ul>
                                    @foreach($nav->sub_categories as $sub_nav)
                                    <li><a href="{{route('shop.category', $sub_nav->id)}}">{{$sub_nav->category_name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Add Cart Modal -->
    <div class="modal fade" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body add-cart-box text-center">
                    <p>You've just added this product to the<br>cart:</p>
                    <h4 id="productTitle"></h4>
                    <img src="#" id="productImage" width="100" height="100" alt="adding cart image">
                    <div class="btn-actions">
                        <a href="cart.html"><button class="btn-primary">Go to cart page</button></a>
                        <a href="#"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>
    @include('layout.footer_script')
    @stack('below_script')
</body>
</html>
