<div class="card" style="width: 18rem;">
    <h4 class="card-title">{{ $address->name }}</h4>
    <div class="default-status">
        <span>@lang('shop::admin.registered_users.default')</span>
        @if($address->is_default)
            <span class="default"><i class="far fa-check-circle fa-2x"></i></span>
        @else
            <span><i class="far fa-times-circle fa-2x"></i></span>
        @endif
    </div>
    <div class="card-body">
        <p class="card-text">
        <table>
            <thead>
            <th></th>
            <th></th>
            </thead>
            <tbody>
            <tr>
                <td>@lang('shop::admin.registered_users.country')</td>
                <td>{{ $address->country->name }}</td>
            </tr>
            <tr>
                <td>@lang('shop::admin.registered_users.city')</td>
                <td>{{ $address->city->name }}</td>
            </tr>
            <tr>
                <td>@lang('shop::admin.registered_users.zip_code_only')</td>
                <td>{{ $address->zip_code }}</td>
            </tr>
            <tr>
                <td>@lang('shop::admin.registered_users.street')</td>
                <td>{{ $address->street }}</td>
            </tr>
            <tr>
                <td>@lang('shop::admin.registered_users.street_number')</td>
                <td>{{ $address->street_number }}</td>
            </tr>

            </tbody>
        </table>
        </p>
        <div class="buttons-wrapper">
            @if(!$address->is_default)
                <a href="{{ route('admin.shop.registered-users.'.$type.'-addresses.make-default', ['id' => $registeredUser->id, 'address_id' => $address->id]) }}" class="btn-sm btn-mark-as-default tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="Маркирай по подразбиране"><i class="far fa-check-circle fa-2x"></i></a>
            @endif
            <a href="https://www.google.bg/maps/place/{{ $address->country->name .' '. $address->city->name . ' ' . $address->street . ' ' . $address->street_number }}" class="btn-sm btn-blue tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="Покажи адреса на картата" target="_blank"><i class="fas fa-map-marked-alt fa-2x"></i></a>
            <a href="{{ route('admin.shop.registered-users.'.$type.'-addresses.edit', ['id' => $registeredUser->id, 'address_id' => $address->id]) }}" class="btn green tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.edit') }}"><i class="fas fa-pencil-alt"></i></a>
            <a href="{{ route('admin.shop.registered-users.'.$type.'-addresses.delete', ['id' => $registeredUser->id, 'address_id' => $address->id]) }}" class="btn red btn-delete-confirm tooltips" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.delete') }}" aria-describedby="tooltip96384"><i class="fas fa-trash-alt"></i></a>
        </div>
    </div>
</div>
