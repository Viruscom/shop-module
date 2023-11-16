<!-- Bootstrap Modal for Adding Company -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addCompanyModalLabel">Промяна / Добавяне на фирма</h4>
            </div>
            <div class="modal-body">
                <form id="addCompanyForm" action="{{ route('admin.shop.orders.company-info-update', ['id' => $order->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="company_name">Фирма <span class="text-purple">*</span></label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required value="{{ $order->company_name }}">
                    </div>
                    <div class="form-group">
                        <label for="company_address">Адрес по регистрация <span class="text-purple">*</span></label>
                        <input type="text" class="form-control" id="company_address" name="company_address" required value="{{ $order->company_address }}">
                    </div>
                    <div class="form-group">
                        <label for="company_eik">ЕИК <span class="text-purple">*</span></label>
                        <input type="text" class="form-control" id="company_eik" name="company_eik" required value="{{ $order->company_eik }}">
                    </div>
                    <div class="form-group">
                        <label for="company_eik">ЕИК по ДДС</label>
                        <input type="text" class="form-control" id="company_vat_eik" name="company_vat_eik" required value="{{ $order->company_vat_eik }}">
                    </div>
                    <div class="form-group">
                        <label for="company_eik">М.О.Л. <span class="text-purple">*</span></label>
                        <input type="text" class="form-control" id="company_mol" name="company_mol" required value="{{ $order->company_mol }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email <span class="text-purple">*</span></label>
                        <input type="email" class="form-control" id="email" name="company_email" required value="{{ $order->email }}">
                    </div>
                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone">Телефон <span class="text-purple">*</span></label>
                        <input type="text" class="form-control" id="phone" name="company_phone" required value="{{ $order->phone }}">
                    </div>
                    <!-- Street -->
                    <div class="form-group hidden">
                        <label for="street">Street *</label>
                        <input type="text" class="form-control" id="street" name="street" required value="{{ $order->street }}">
                    </div>
                    <!-- Street Number -->
                    <div class="form-group hidden">
                        <label for="street_number">Street Number *</label>
                        <input type="text" class="form-control" id="street_number" name="street_number" required value="{{ $order->street_number }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('admin.common.back') }}</button>
                <button type="button" class="btn btn-success" id="submitCompany">{{ __('admin.save') }}</button>
            </div>
        </div>
    </div>
</div>
