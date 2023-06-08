<div class="card" style="width: 18rem;">
    <h4 class="card-title">{{ $company->company_name }}</h4>
    <div class="default-status">
        <span>По подразбиране</span>
        @if($company->is_default)
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
                <td>ЕИК</td>
                <td>{{ $company->company_eik }}</td>
            </tr>
            <tr>
                <td>ДДС №</td>
                <td>{{ $company->company_vat_eik }}</td>
            </tr>
            <tr>
                <td>М.О.Л.</td>
                <td>{{ $company->company_mol }}</td>
            </tr>
            <tr>
                <td>Адрес на регистрация</td>
                <td>{{ $company->company_address }}</td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td>{{ $company->phone }}</td>
            </tr>
            </tbody>
        </table>
        </p>
        <div class="buttons-wrapper">
            @if(!$company->is_default)
                <a href="{{ route('admin.shop.registered-users.companies.make-default', ['id' => $registeredUser->id, 'company_id' => $company->id]) }}" class="btn-sm btn-mark-as-default tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="Маркирай като фирма по подразбиране"><i class="far fa-check-circle fa-2x"></i></a>
            @endif
            <a href="https://www.google.bg/maps/place/#######" class="btn-sm btn-blue tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="Покажи адрес на доставка на картата" target="_blank"><i class="fas fa-map-marked-alt fa-2x"></i></a>
            <a href="{{ route('admin.shop.registered-users.companies.edit', ['id' => $registeredUser->id, 'company_id' => $company->id]) }}" class="btn green tooltips" role="button" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.edit') }}"><i class="fas fa-pencil-alt"></i></a>
            <a href="{{ route('admin.shop.registered-users.companies.delete', ['id' => $registeredUser->id, 'company_id' => $company->id]) }}" class="btn red btn-delete-confirm tooltips" data-toggle="tooltip" data-placement="auto" title="" data-original-title="{{ __('admin.delete') }}" aria-describedby="tooltip96384"><i class="fas fa-trash-alt"></i></a>
        </div>
    </div>
</div>
