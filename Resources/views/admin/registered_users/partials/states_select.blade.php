<div class="form-group">
    <label for="state_id" class="control-label">@lang('shop::admin.registered_users.states')</label>
    <select name="state_id" id="state_id" class="form-control select2">
        <option value="">@lang('admin.common.please_select')</option>
        @foreach($states as $state)
            <option value="{{ $state->id  }}">{{ $state->name }}</option>
        @endforeach
    </select>
</div>
