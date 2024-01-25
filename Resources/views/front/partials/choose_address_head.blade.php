@php use Carbon\Carbon;use Modules\RetailObjectsRestourant\Services\WorkLoadService; @endphp
<div class="section-top-links hover-images">
    <a href="" class="top-link top-link-red btn-zones">
        <img src="{{ asset('front/assets/icons/pin.svg') }}" alt="">
        <img src="{{ asset('front/assets/icons/pin-light.svg') }}" alt="">

        <strong>Зони за доставка</strong>
    </a>

    <div class="top-link">
        <img src="{{ asset('front/assets/icons/clock.svg') }}" alt="">

        @php
            $workload = json_decode(WorkLoadService::getCurrentWorkloadStatus());
        @endphp

        @if($workload->status == 'error')
            {{ $workload->workLoadStatus }}
        @else
            <strong>от {{Carbon::parse($workload->workload->from_hour)->format('H:i')}} до {{Carbon::parse($workload->workload->to_hour)->format('H:i')}}</strong>  - {{$workload->workLoadStatus}}

        @endif
    </div>

    <a href="" class="top-link top-link-green btn-address">
        <img src="{{ asset('front/assets/icons/pen.svg') }}" alt="">

        <img src="{{ asset('front/assets/icons/pen-light.svg') }}" alt="">

        <strong>Вашият адрес</strong> : {{ !is_null(session()->get('validated_delivery_address')) ? $city->name .', '. session()->get('validated_delivery_address') . ' № '. session()->get('validated_street_number'): 'няма въведен' }}
    </a>
</div>
