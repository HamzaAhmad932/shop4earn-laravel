@extends('layout.app')
@section('title', 'Cart')
@push('below_style')
<style>
    @media only screen and (max-width: 767px) {
        .error_form h1 {
            font-size: 115px;
            line-height: 120px;
            letter-spacing: 4px;
            margin: 0 0 40px;
        }
    }
</style>
@endpush

@section('page_content')
    <div id="app">
        <!--error section area start-->
        <div class="error_section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="error_form">
                            <h1>Thanks</h1>
                            <h2>Your order has been placed successfully</h2>
                            <p>You have provided a special customer PORTAL to keep record of your team and earnings.</p>
                            <a href="/portal">Login to Portal</a>
                            <a href="/">Back to home page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--error section area end-->
    </div>
@endsection
