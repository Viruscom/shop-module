<h3>@lang('shop::front.basket.payments_type')</h3>

<div class="form-section form-section-alt">
    @foreach($paymentMethods as $paymentMethod)
        <div class="form-row-radio">
            <div class="form-row-inner">
                <label class="radio-label">{{ trans('shop::admin.payment_systems.' . $paymentMethod->type) }}
                    <strong>Плащането се извършва на куриера при получаване на поръчката.</strong>
                    <input type="radio" {{ $paymentMethod->type == 'cash_on_delivery' ? 'checked="checked"' : '' }} name="payment_id" value="{{$paymentMethod->id}}" required>
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
    @endforeach
</div>
