@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    <section class="section-top-container section-top-container-cart">
        @include('shop::front.partials.choose_address_head')
        @include('shop::basket.breadcrumbs')
    </section>
    <div class="page-wrapper">
        @include('shop::basket.breadcrumbs')
        <div class="cart-wrapper">
            <div class="shell">
                @include('front.notify')
                <div class="form-wrapper form-wrapper-alt">
                    <form method="post" enctype="multipart/form-data" id="payment-form-unregistered" action="{{route('basket.order.store')}}">
                        @csrf
                        <input type="hidden" name="total" value="{{number_format($basket->total, 2, '.', '')}}">
                        <input type="hidden" name="total_discounted" value="{{number_format($basket->total_discounted, 2 ,'.', '')}}">
                        <input type="hidden" name="total_free_delivery" value="{{$basket->total_free_delivery ? 1:0}}">
                        <div class="cart-cols">
                            <div class="col col-2of3">
                                <h3 class="title-main title-border">@lang('shop::front.basket.checkout')</h3>
                                <div class="col-inner">
                                    @php
                                        $basketRegisteredUser = null;
                                        if (\Illuminate\Support\Facades\Auth::guard('shop')->check()) {
                                            $basketRegisteredUser = Auth::guard('shop')->user();
                                        }
                                    @endphp

                                    @include('shop::basket.partials.deliveries', ['countriesSale' => $countriesSale])

                                    @include('shop::basket.partials.contact_info')

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

        $(document).on('change', '.ru-bst-ch-sh-addr', function(){
            var selectedOption = $(this).find('option:selected');

            $('#address').val(selectedOption.attr('street'));
            $('#streetNumber').val(selectedOption.attr('street_number'));
            $('#postCode').val(selectedOption.attr('zip_code'));
        });

    </script>
@endsection
