@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')
    <div class="page-wrapper">
        @include('front.notify')
        {{--        @include('shop::front.registered_users.profile.breadcrumbs')--}}
        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content-shop">
                    <h3 class="page-title">{{ __('front.shipment_addresses.index') }}</h3>

                    <div class="page-top-actions">
                        <a href="{{ route('shop.registered_user.account.addresses.create', ['languageSlug' => $languageSlug]) }}" class="btn btn-black">{{ __('front.shipment_addresses.add') }}</a>
                    </div>

                    <h4 class="title-big">{{ __('front.firms.by_default') }}</h4>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            @if(!is_null($defaultAddress))
                                <div class="box-text">
                                    <div class="box-content">
                                        <h4>{{ __('front.firms.firm_info') }}</h4>

                                        <h3>{{ $defaultAddress->name }}</h3>

                                        <p>{{ $defaultAddress->street }} №{{ $defaultAddress->street_number }}</p>

                                        <p>{{ $defaultAddress->city->title }} {{ $defaultAddress->zip_code }}</p>

                                        <a href="{{ route('shop.registered_user.account.addresses.edit', ['languageSlug' => $languageSlug, 'id' => $defaultAddress->id]) }}" class="btn btn-outline">{{ __('front.companies.edit') }}</a>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger">{{ trans('shop::admin.registered_users.no_shipment_addresses') }}</div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h4 class="title-big">Други адреси</h4>

                    <div class="box-cols box-cols-alt">
                        @forelse($otherAddresses as $address)
                            <div class="col col-1of2">
                                <div class="cards-wrapper">
                                    <div class="box-text">
                                        <div class="box-content">
                                            <h3>{{ $address->name }}</h3>

                                            <p>{{ $address->street }} №{{ $address->street_number }}</p>

                                            <p>{{ $address->city->title }} {{ $address->zip_code }}</p>

                                            <label class="radio-label">
                                                {{ __('front.firms.choose_by_default') }}
                                                <input type="radio" class="default_company_radio" name="default_company" route="{{ route('shop.registered_user.account.addresses.set-as-default', ['languageSlug' => $languageSlug, 'id' => $address->id]) }}">
                                                <span class="checkmark"></span>
                                            </label>

                                            <div class="box-bottom">
                                                <a href="{{ route('shop.registered_user.account.addresses.edit', ['languageSlug' => $languageSlug, 'id' => $address->id]) }}" class="btn btn-outline">{{ __('front.companies.edit') }}</a>

                                                <a href="{{ route('shop.registered_user.account.addresses.delete', ['languageSlug' => $languageSlug, 'id' => $address->id]) }}" class="btn btn-outline">Изтрий</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="alert alert-danger">{{ trans('shop::admin.registered_users.no_shipment_addresses') }}</div>
                        @endforelse

                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('.default_company_radio').on('click', function() {
                $.ajax({
                    url: $(this).attr('route'),
                    type: 'GET',
                    success: function(response) {
                        window.location.reload();
                    },
                    error: function(error) {
                        alert('Възникна грешка. Моля, опитайте отново.');
                    }
                });
            });
        });
    </script>
@endsection
