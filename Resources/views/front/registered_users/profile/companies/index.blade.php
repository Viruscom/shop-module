@extends('layouts.front.app', ['headerShrink' => 'header-alt shrink'])

@section('content')
    @include('shop::front.partials.registered_user_head')
    <div class="page-wrapper">
        {{--        @include('shop::front.registered_users.profile.breadcrumbs')--}}
        <section class="settings-page">
            <div class="shell">
                @include('shop::front.registered_users.profile.partials.menu')

                <div class="page-content-shop">
                    <h3 class="page-title">{{ __('front.firms.index') }}</h3>

                    <div class="page-top-actions">
                        <a href="{{ route('shop.registered_user.account.companies.create', ['languageSlug' => $languageSlug]) }}" class="btn btn-black">{{ __('front.firms.add') }}</a>
                    </div>

                    <h4 class="title-big">{{ __('front.firms.by_default') }}</h4>

                    <div class="box-cols">
                        <div class="col col-1of2">
                            @if(!is_null($defaultCompany))
                                <div class="box-text">
                                    <div class="box-content">
                                        <h4>{{ __('front.firms.firm_info') }}</h4>

                                        <h3>{{ $defaultCompany->company_name }}</h3>

                                        <p>{{ $defaultCompany->company_mol }}</p>

                                        <p>{{ $defaultCompany->phone }}</p>

                                        <p>{{ $defaultCompany->company_address }}</p>

                                        <p>
                                            @if(!is_null($defaultCompany->city))
                                                {{ $defaultCompany->city->name }}
                                            @endif
                                            {{ $defaultCompany->zip_code }}</p>

                                        <a href="{{ route('shop.registered_user.account.companies.edit', ['languageSlug' => $languageSlug, 'id' => $defaultCompany->id]) }}" class="btn btn-outline">{{ __('front.companies.edit') }}</a>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger">{{ trans('shop::admin.registered_users.no_companies') }}</div>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h4 class="title-big">{{ __('front.firms.other_firms') }}</h4>

                    <div class="box-cols box-cols-alt">
                        @forelse($otherCompanies as $company)
                            <div class="col col-1of2">
                                <div class="cards-wrapper">
                                    <div class="box-text">
                                        <div class="box-content">
                                            <h3>{{ $company->company_name }}</h3>

                                            <p>{{ $company->company_mol }}</p>

                                            <p>{{ $company->phone }}</p>

                                            <p>{{ $company->company_address }}</p>

                                            <p>@if(!is_null($defaultCompany->city))
                                                    {{ $defaultCompany->city->title }}
                                                @endif {{ $company->zip_code }}</p>

                                            <label class="radio-label">
                                                {{ __('front.firms.choose_by_default') }}
                                                <input type="radio" class="default_company_radio" name="default_company" route="{{ route('shop.registered_user.account.companies.set-as-default', ['languageSlug' => $languageSlug, 'id' => $company->id]) }}">
                                                <span class="checkmark"></span>
                                            </label>

                                            <div class="box-bottom">
                                                <a href="{{ route('shop.registered_user.account.companies.edit', ['languageSlug' => $languageSlug, 'id' => $company->id]) }}" class="btn btn-outline">{{ __('front.companies.edit') }}</a>

                                                <a href="{{ route('shop.registered_user.account.companies.delete', ['languageSlug' => $languageSlug, 'id' => $company->id]) }}" class="btn btn-outline">Изтрий</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="alert alert-danger">{{ trans('shop::admin.registered_users.no_companies') }}</div>
                        @endforelse

                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function () {
            $('.default_company_radio').on('click', function () {
                $.ajax({
                    url: $(this).attr('route'),
                    type: 'GET',
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (error) {
                        alert('Възникна грешка. Моля, опитайте отново.');
                    }
                });
            });
        });
    </script>
@endsection
