<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>test</title>
    <style type="text/css">
        .main-table {
            border:          1px solid black;
            border-collapse: collapse;
        }

        th {
            padding-right: 10px;
            padding-left:  10px;
        }

    </style>
</head>
<body>
<table width="100%">
    <tr>
        <td width="80%">
            <h2 style="margin-bottom: 5px;">{{ __('shop::admin.orders.virtual_note') }}</h2>
            @php
                use App\Models\Settings\ShopSetting;use Carbon\Carbon;
                $vrDate = Carbon::parse($order->vr_date);
                $orderDate = Carbon::parse($order->created_at);
            @endphp
            <strong>№ {{ str_pad($virtualReceiptNumber, 10, '0', STR_PAD_LEFT) }} {{ __('shop::admin.orders.virtual_note_from') }}
                {{ __('shop::admin.orders.virtual_note_date') }}: {{ $vrDate->format('d.m.Y') }} г.</strong>
        </td>
        <td>
            <span style="float: right; padding-top: 60px;">{!! QrCode::size(100)->generate(ShopSetting::where('key', 'unique_shop_number')->first()->value. '*' .$orderDate->format('Y-m-d') .'*'. $orderDate->format('H:i') .'*'. $order->vr_transaction_number.'*'.number_format(($order->total-$order->total_discounts), 2,',',' ') . '*' . $order->id) !!}</span>
        </td>
    </tr>
</table>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="100%">
    <tbody>
    <tr>
        <td style="border-right: 2px solid darkgray;">
            <strong>{{ __('shop::admin.orders.virtual_note_supplier') }}:</strong>
            <div><strong>Психотерапевтичен и обучителен център Алма ООД</strong></div>
            <div><span>ЕИК: </span><span>206893119</span></div>
            <div><span>Адрес: </span><span>гр. София, ул. ТИНТЯВА, 126, вх. Б, ет. 2</span></div>
            <div><span>Телефон: </span><span>+359 88833 11 73 </span></div>
            <div><span>Email: </span><span>info@almatherapy.bg</span></div>
            <div><span>&nbsp;</span><span></span></div>
        </td>
        <td style="padding-left: 10px;">
            <strong>Поръчка № {{ $order->id }}</strong>
            <div><span>VPOS №: </span><span>000000013082070</span></div>
            <div><span>Транзакция №: </span><span>{{ $order->vr_transaction_number }}</span></div>
            <div><span>Начин на плащане: </span><span>Виртуален POS терминал - MyPOS</span></div>
            <div><span>Наименование: </span><span>„Айкарт" АД</span></div>
            <div><span>Идент. № на ЮЛ: </span><span>175325806</span></div>
            {{--            <div><span>Електроенен адрес за кореспонденция: </span><span>tax.inquiries@icard.com</span></div>--}}
        </td>
    </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table class="main-table" border="1" bordercolor="#000000" cellspacing="0">
    <thead>
    <th>№</th>
    <th>Наименование на стоките и услугите</th>
    <th>К-во</th>
    <th>Мярка</th>
    <th>Д.група</th>
    <th width="120" style="text-align: right;">Ед.цена</th>
    <th width="120" style="text-align: right;">Стойност</th>
    </thead>
    <tbody>
    @php
        $i = 1;
        $grandTotalDiscounts = 0;
        $grandTotal = 0;
        $grandTotalWithDiscounts = 0;
    @endphp
    @if(count($order->order_products))
        @foreach($order->order_products as $product)
            <tr>
                <td style="text-align: center;">
                    <span>{{ $i }}</span>
                </td>
                <td>
                    <span>{{ $product->product->title }}</span>
                </td>
                <td style="text-align: center;">
                    <span>1</span>
                </td>
                <td style="text-align: center;">
                    <span>бр.</span>
                </td>
                <td style="text-align: center;">
                    <span>Б- 20%</span>
                </td>
                <td width="120" style="text-align: right;">
                    <span>{{ number_format($product->total, 2,',',' ') }} @lang('messages.bgn')</span>
                </td>
                <td width="120" style="text-align: right;">
                    <span>{{ number_format($product->total, 2,',',' ') }} @lang('messages.bgn')</span>
                </td>
            </tr>
            @php
                $grandTotalDiscounts+= $product->discounts;
                $grandTotal+= $product->total;
                $grandTotalWithDiscounts+= $product->total_with_discounts;
                $i++;
            @endphp
        @endforeach
    @endif
    </tbody>
</table>

<table width="100%">
    <tbody style="text-align: right;">
    <tr>
        <td style="text-align: right;"><strong>Обща сума:</strong></td>
        <td width="135">{{ number_format($order->total, 2,',',' ') }} {!! trans('messages.bgn') !!}</td>
    </tr>
    <tr>
        <td><strong>Отстъпка:</strong></td>
        <td>-{{ number_format($order->total_discounts, 2,',',' ') }} {!! trans('messages.bgn') !!}</td>
    </tr>
    <tr>
        <td><strong>Данъчна основа:</strong></td>
        <td>{{ number_format(($order->total-$order->total_discounts)/1.2, 2,',',' ') }} {!! trans('messages.bgn') !!}</td>
    </tr>
    <tr>
        <td><strong>ДДС (20%):</strong></td>
        <td>{{ number_format((($order->total-$order->total_discounts)/1.2)*0.2, 2,',',' ') }} {!! trans('messages.bgn') !!}</td>
    </tr>
    <tr>
        <td><strong>Обща сума за плащане:</strong></td>
        <td>{{ number_format($order->total-$order->total_discounts, 2,',',' ') }} {!! trans('messages.bgn') !!}</td>
    </tr>
    </tbody>
</table>

</body>
</html>
