<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Viewport-->
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<!-- Body-->
<body>
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <div class="col-md-12">
            <div id="payment-redirection" class="initial-hidden">
                <div class="loading--2">
                    <div class="text-center"><h1>{{translate('messages.Redirecting_to_the_payment_page')}}......</h1></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-5 pt-5">
            <center class="">
                <h1>Método de pago</h1>
            </center>
        </div>
        {{--@php($order=\App\Models\Order::find(session('order_id')))--}}
        <section class="col-lg-12">
            <div class="checkout_details mt-3">
                <div class="row">
                    <!-- Niubiz -->
{{--                    @if($config['status'])--}}
                    <div class="col-md-6 mb-4 cursor-pointer">
                        <div class="card">
                            <div class="card-body pt-1 h-70px">
{{--                                @php($order=\App\Models\Order::find(session('order_id')))--}}
{{--                                    <form action="{!!route('view-niubiz',['order_id'=>$order['id']])!!}">--}}
                                <form action="{!!route('view-niubiz', ['order_id' => 12])!!}">
                                        @csrf
                                        <button class="btn btn-block click-if-alone" type="submit">
                                            <img width="100"
                                                 src="{{asset('assets/img/payment/niubiz.png')}}" alt=""/>
                                        </button>
                                    </form>
                            </div>
                        </div>
                    </div>
{{--                    @endif--}}
                </div>
            </div>
        </section>
    </div>
</div>

{{--{!! Toastr::message() !!}--}}



<script>
    setTimeout(function () {
        $('.stripe-button-el').hide();
        $('.razorpay-payment-button').hide();
    }, 10)
</script>


<script>
    function click_if_alone() {
        let total = $('.checkout_details .click-if-alone').length;
        if (Number.parseInt(total) == 1) {
            $('.click-if-alone')[0].click()
            $('#payment-redirection').show();
        }
    }
    @if(!Session::has('toastr::messages'))
        click_if_alone();
    @endif
</script>
</body>
</html>
