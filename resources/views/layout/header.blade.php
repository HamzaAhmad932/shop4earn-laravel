<!--header area start-->

<!--Offcanvas menu area start-->
<div class="off_canvars_overlay">

</div>
<div class="Offcanvas_menu Offcanvas_four">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="canvas_open">
                    <a href="javascript:void(0)"><i class="ion-navicon"></i></a>
                </div>
                <div class="Offcanvas_menu_wrapper">
                    <div class="canvas_close">
                        <a href="javascript:void(0)"><i class="ion-android-close"></i></a>
                    </div>

                    <div class="header_right_info">
                        <ul>
                            <li class="search_box"><a href="javascript:void(0)"><i class="zmdi zmdi-search zmdi-hc-fw"></i></a>
                                <div class="search_widget">
                                    <form action="#">
                                        <input placeholder="Search our catalog" type="text">
                                        <button type="submit"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                                    </form>
                                </div>
                            </li>
{{--                            <li class="header-wishlist"><a href="wishlist.html"><i class="zmdi zmdi-favorite-outline"></i> <span class="item_count">3</span></a></li>--}}
                            <li class="mini_cart_wrapper"><a href="javascript:void(0)"><i class="zmdi zmdi-shopping-cart zmdi-hc-fw"></i> <span class="item_count">{{Cart::instance('shopping')->count()}}</span></a>
                                <!--mini cart-->
                                <div class="mini_cart">
                                    <div class="cart_gallery">
                                        @forelse(Cart::instance('shopping')->content() as $item)
                                            <div class="cart_item">
                                                <div class="cart_img">
                                                    <a href="{{route('shop.product', $item->id)}}"><img src="{{$item->options->image_path}}" alt=""></a>
                                                </div>
                                                <div class="cart_info">
                                                    <a href="{{route('shop.product', $item->id)}}">{{$item->name}}</a>
                                                    <p><span> {{$item->price}} </span> X {{$item->qty}}</p>
                                                </div>
                                                {{--                                                    <div class="cart_remove">--}}
                                                {{--                                                        <a href="#"><i class="ion-android-close"></i></a>--}}
                                                {{--                                                    </div>--}}
                                            </div>
                                        @empty
                                            <div class="cart_item">
                                                <p>Cart is empty!</p>
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="mini_cart_table">
                                        <div class="cart_table_border">
                                            <div class="cart_total">
                                                <span>Sub total:</span>
                                                <span class="price">Rs.{{Cart::instance('shopping')->subtotal()}}</span>
                                            </div>
                                            <div class="cart_total mt-10">
                                                <span>total:</span>
                                                <span class="price">Rs.{{Cart::instance('shopping')->total()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mini_cart_footer">
                                        <div class="cart_button">
                                            <a href="{{route('cart.show')}}">View cart</a>
                                        </div>
                                        @if(Cart::instance('shopping')->count() > 0)
                                            <div class="cart_button">
                                                <a href="{{route('checkout')}}"> Checkout</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!--mini cart end-->
                            </li>
                        </ul>
                    </div>

                    <div id="menu" class="text-left">
                        <ul class="offcanvas_main_menu">
                            <li><a href="#">Earn with Us</a></li>
                            <li><a href="#">about Us</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="/portal">Login</a></li>
                        </ul>
                    </div>

                    <div class="Offcanvas_footer">
                        <span><a href="#"><i class="fa fa-envelope-o"></i> info@yourdomain.com</a></span>
                        <ul>
                            <li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li class="pinterest"><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                            <li class="google-plus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li class="linkedin"><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Offcanvas menu area end-->

<header>
    <div class="main_header header_four">
        <div class="header_middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="logo">
                            <a href="/"><img src="{{asset('shop_logo_2.png')}}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="heder_middle_right">
                            <div class="search-container search_four">
                                <form action="#">
                                    <div class="hover_category">
                                        <select class="select_option" name="select" id="categori">
                                            <option selected value="1">All Categories</option>
                                            @foreach($navbar as $nav)
                                                <option value="{{$nav->id}}">{{$nav->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="search_box_three">
                                        <input placeholder="Search product..." type="text">
                                        <button type="submit"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="header_right_info right_info_three">
                                <ul>
{{--                                    <li class="header-wishlist"><a href="wishlist.html"><i class="zmdi zmdi-favorite-outline"></i> <span class="item_count">3</span></a></li>--}}
                                    <li class="mini_cart_wrapper"><a href="javascript:void(0)"><i class="zmdi zmdi-shopping-cart zmdi-hc-fw"></i> <span class="item_count">{{Cart::instance('shopping')->count()}}</span> Rs.{{Cart::instance('shopping')->total()}} <i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
                                        <!--mini cart-->
                                        <div class="mini_cart mini_cart_four">
                                            <div class="cart_gallery">
                                                @forelse(Cart::instance('shopping')->content() as $item)
                                                <div class="cart_item">
                                                    <div class="cart_img">
                                                        <a href="{{route('shop.product', $item->id)}}"><img src="{{$item->options->image_path}}" alt=""></a>
                                                    </div>
                                                    <div class="cart_info">
                                                        <a href="{{route('shop.product', $item->id)}}">{{$item->name}}</a>
                                                        <p><span> {{$item->price}} </span> X {{$item->qty}}</p>
                                                    </div>
{{--                                                    <div class="cart_remove">--}}
{{--                                                        <a href="#"><i class="ion-android-close"></i></a>--}}
{{--                                                    </div>--}}
                                                </div>
                                                @empty
                                                    <div class="cart_item">
                                                        <p>Cart is empty!</p>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <div class="mini_cart_table">
                                                <div class="cart_table_border">
                                                    <div class="cart_total">
                                                        <span>Sub total:</span>
                                                        <span class="price">Rs.{{Cart::instance('shopping')->subtotal()}}</span>
                                                    </div>
                                                    <div class="cart_total mt-10">
                                                        <span>total:</span>
                                                        <span class="price">Rs.{{Cart::instance('shopping')->total()}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mini_cart_footer">
                                                <div class="cart_button">
                                                    <a href="{{route('cart.show')}}">View cart</a>
                                                </div>
                                                @if(Cart::instance('shopping')->count() > 0)
                                                    <div class="cart_button">
                                                        <a href="{{route('checkout')}}"> Checkout</a>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        <!--mini cart end-->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header_bottom sticky-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3">
                        <div class="categories_menu categories_four">
                            <div class="categories_title">
                                <h2 class="categori_toggle">SHOP</h2>
                            </div>
                            <div class="categories_menu_toggle">
                                <ul>
                                    @foreach($navbar as $nav)
                                        @if(!$nav->sub_categories->isEmpty())
                                            <li class="menu_item_children categorie_list">
                                                <a href="{{route('shop.category', $nav->id)}}">
                                                    {{$nav->category_name}}
                                                    <i class="fa fa-angle-right"></i>
                                                </a>
                                                <ul class="categories_mega_menu">
                                                    @foreach($nav->sub_categories as $sub_nav)
                                                        <ul class="categorie_sub_menu">
                                                            <li><a href="{{route('shop.category', $sub_nav->id)}}">{{$sub_nav->category_name}}</a></li>
                                                        </ul>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{route('shop.category', $nav->id)}}">
                                                    {{$nav->category_name}}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
{{--                                    <li id="cat_toggle" class="has-sub"><a href="#"> More Categories</a>--}}
{{--                                        <ul class="categorie_sub">--}}
{{--                                            <li><a href="#">Hide Categories</a></li>--}}
{{--                                        </ul>--}}

{{--                                    </li>--}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="main_menu menu_four menu_position">
                            <nav class="float-left">
                                <ul>
                                    <li><a href="#">Earn with Us</a></li>
                                    <li><a href="#">about Us</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </nav>
                            <nav class="float-right">
                                <ul>
                                    <li><a href="/portal">Login</a></li>
                                </ul>
                            </nav>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="header_social social_four  text-right">
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!--header area end-->
