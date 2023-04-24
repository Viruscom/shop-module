@extends('layouts.front.app')

@section('content')
    <div class="page-wrapper">
        @include('shop::basket.breadcrumbs')

        <div class="cart-wrapper">
            <div class="shell">
                @include('front.notify')
                <div class="form-wrapper form-wrapper-alt">
                    <form method="post" enctype="multipart/form-data" id="payment-form-unregistered" action="{{route('basket.order.store')}}">
                        @csrf
                        <input type="hidden" name="total" value="{{$basket->total}}">
                        <input type="hidden" name="total_discounted" value="{{$basket->total_discounted}}">
                        <input type="hidden" name="total_free_delivery" value="{{$basket->total_free_delivery ? 1:0}}">
                        <div class="cart-cols">
                            <div class="col col-2of3">
                                <h3 class="title-main title-border">@lang('shop::front.basket.checkout')</h3>
                                <div class="col-inner">
                                    @if(!\Illuminate\Support\Facades\Auth::guard('shop')->check())
                                        <div class="top-actions">
                                            <a href="{{ route('shop.login', ['languageSlug' => $languageSlug]) }}" class="btn btn-black">@lang('shop::front.login.login_submit')</a>

                                            <a href="{{ route('shop.register', ['languageSlug' => $languageSlug]) }}" class="btn btn-outline">@lang('shop::front.login.create_account')</a>
                                        </div>
                                    @endif

                                    @include('shop::basket.partials.contact_info')

                                    @include('shop::basket.partials.deliveries')

                                    @include('shop::basket.partials.payments')

                                    @include('shop::basket.partials.invoice_details')
                                </div>
                            </div>

                            <div class="col col-1of3">
                                @include('shop::basket.partials.basket_summary')
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">


                    <div class="card-body">

                        <form method="POST" action="">


                            <div>{{__('Products')}}</div>
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <td>Product ID</td>
                                    <td>Quantity</td>
                                    <td>Single Price</td>
                                    <td>Single Quantity Price</td>
                                    <td>VAT</td>
                                    <td>Single VAT Price</td>
                                    <td>Single VAT Discounted Price</td>
                                    <td>End Price</td>
                                    <td>End Discounted Price</td>
                                    <td>Free delivery</td>
                                </tr>
                                </thead>
                                <tbody>
                                @if(is_null($basket) || $basket->basket_products->count()<1)
                                    <tr>
                                        <td colspan="11">{{__("No data")}}</td>
                                    </tr>
                                @else
                                    @foreach($basket->calculated_basket_products as $basket_product)
                                        <tr>
                                            <td>{{$basket_product->product->id}}</td>
                                            <td>{{$basket_product->product_quantity}}</td>
                                            <td>{{$basket_product->product->price}}</td>
                                            <td>{{$basket_product->price}}</td>
                                            <td>{{$basket_product->vat}}</td>
                                            <td>{{$basket_product->vat_applied_price}}</td>
                                            <td>{{$basket_product->vat_applied_discounted_price}}</td>
                                            <td>{{$basket_product->end_price}}</td>
                                            <td>{{$basket_product->end_discounted_price}}</td>
                                            <td>{{$basket_product->free_delivery ? 'Yes':'No'}}</td>

                                    @endforeach
                                    <tr>
                                        <td colspan="11">{{__("Total")}}: {{$basket->total}} / {{__("Total Discounted")}}: {{$basket->total_discounted}} / {{__('Free delivery')}}: {{$basket->total_free_delivery ? 'Yes':'No'}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <hr>
                            <div class="col-12">
                                <div class="@error('delivery_id') is-invalid @enderror">{{__('Delivery Method')}}
                                    @error('delivery_id')
                                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                    @enderror
                                </div>
                                @foreach($deliveryMethods as $deliveryMethod)
                                    <input type="radio" name="delivery_id" value="{{$deliveryMethod->id}}">
                                    <label>{{$deliveryMethod->type}}</label><br>
                                @endforeach
                            </div>
                            <hr>
                            <div class="col-12">
                                <div class="@error('payment_id') is-invalid @enderror">{{__('Payment Method')}}
                                    @error('payment_id')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                @foreach($paymentMethods as $paymentMethod)
                                    <input type="radio" name="payment_id" value="{{$paymentMethod->id}}" required>
                                    <label>{{$paymentMethod->type}}</label><br>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary float-left">{{ __('Finish') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function hasInvoice(el) {
            if ($(el).val() == 1) {
                $('#invoice_data').css('display', 'block');
                $('.invoice-required').attr('required', 'required');
            } else {
                $('#invoice_data').css('display', 'none');
                $('.invoice-required').removeAttr('required');
            }
        }
    </script>
@endsection
