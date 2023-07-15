<div class="form-group">
    <label for="cities" class="control-label">@lang('shop::admin.registered_users.cities')</label>
    <select name="city_id" id="cities" class="form-control select2">
        <option value="">@lang('admin.common.please_select')</option>
        @foreach($cities as $city)
            <option value="{{ $city->id  }}">{{ $city->name }}</option>
        @endforeach
    </select>
</div>
