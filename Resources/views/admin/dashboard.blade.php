@php use Carbon\Carbon; @endphp@extends('layouts.admin.app')

@section('styles')
    <link href="{{ asset('admin/assets/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
    <style>
        #example {
            font-size: 13px;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            var options = {
                withSortableRow: true,
                sortableRowFromColumn: 1,
                sortableRowToColumn: 9,
                withDynamicSort: true,
                dynamicSortFromColumn: 1,
                dynamicSortToColumn: 9,
                rowsPerPage: 50
            }
            initDatatable('example', options);

        });
    </script>
@endsection

@section('content')

    <div class="dashboard-order row">
        <div class="col-xs-12">
            <div class="dashboard-order-quick row vue">
                <div title="Total orders within the last seven days compared to the period before" class="quick order-quick-counttotal col-sm-6 col-xl-3">
                    <div class="box row done">
                        <div class="col quick-start">
                            <div class="quick-number">6</div>
                        </div>
                        <div class="col quick-end">
                            <div class="quick-percent positive">+600%</div>
                        </div>
                        <div class="col-xs-12"><h2 class="quick-header">Total orders</h2>
                            <div class="quick-progress">
                                <div class="quick-length" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div title="Completed orders within the last seven days compared to the period before" class="quick order-quick-countcompleted col-sm-6 col-xl-3">
                    <div class="box row done">
                        <div class="col quick-start">
                            <div class="quick-number">6</div>
                        </div>
                        <div class="col quick-end">
                            <div class="quick-percent positive">+600%</div>
                        </div>
                        <div class="col-xs-12"><h2 class="quick-header">Completed orders</h2>
                            <div class="quick-progress">
                                <div class="quick-length" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div title="Unfinished orders within the last seven days compared to the period before" class="quick order-quick-countunfinished col-sm-6 col-xl-3">
                    <div class="box row done">
                        <div class="col quick-start">
                            <div class="quick-number">0</div>
                        </div>
                        <div class="col quick-end">
                            <div class="quick-percent neutral">0%</div>
                        </div>
                        <div class="col-xs-12"><h2 class="quick-header">Unfinished orders</h2>
                            <div class="quick-progress">
                                <div class="quick-length" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div title="New customers within the last seven days" class="quick order-quick-countcustomer col-sm-6 col-xl-3">
                    <div class="box row done">
                        <div class="col quick-start">
                            <div class="quick-number">2</div>
                        </div>
                        <div class="col quick-end">
                            <div class="quick-percent"></div>
                        </div>
                        <div class="col-xs-12"><h2 class="quick-header">Customers</h2>
                            <div class="quick-progress">
                                <div class="quick-length" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-latest col-xl-12">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-latest-data" aria-expanded="true" aria-controls="order-latest-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Latest orders</h2>
                </div>
                <div id="order-latest-data" class="content collapse show">
                    <div class="table-responsive">
                        <table class="list-items table table-hover">
                            <tbody>
                            <tr>
                                <td class="order-id">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/6?locale=en">6</a>
                                </td>
                                <td class="order-address-name">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/6?locale=en">Fashion Store</a>
                                </td>
                                <td class="order-product-price">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/6?locale=en">49 USD</a>
                                </td>
                                <td class="order-datepayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/6?locale=en">2023-07-30 02:01:00</a>
                                </td>
                                <td class="order-statuspayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/6?locale=en">authorized</a>
                                </td>
                                <td class="order-service-payment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/6?locale=en">demo-invoice</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="order-id">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/5?locale=en">5</a>
                                </td>
                                <td class="order-address-name">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/5?locale=en">Sandy Ottwell</a>
                                </td>
                                <td class="order-product-price">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/5?locale=en">88 USD</a>
                                </td>
                                <td class="order-datepayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/5?locale=en">2023-07-30 02:01:00</a>
                                </td>
                                <td class="order-statuspayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/5?locale=en">pending</a>
                                </td>
                                <td class="order-service-payment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/5?locale=en">demo-prepay</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="order-id">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/4?locale=en">4</a>
                                </td>
                                <td class="order-address-name">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/4?locale=en">Simone Duval</a>
                                </td>
                                <td class="order-product-price">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/4?locale=en">500 EUR</a>
                                </td>
                                <td class="order-datepayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/4?locale=en">2023-07-29 02:01:00</a>
                                </td>
                                <td class="order-statuspayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/4?locale=en">authorized</a>
                                </td>
                                <td class="order-service-payment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/4?locale=en">demo-cashondelivery</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="order-id">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/3?locale=en">3</a>
                                </td>
                                <td class="order-address-name">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/3?locale=en">Sabina Griffin</a>
                                </td>
                                <td class="order-product-price">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/3?locale=en">280 USD</a>
                                </td>
                                <td class="order-datepayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/3?locale=en">2023-07-28 02:01:00</a>
                                </td>
                                <td class="order-statuspayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/3?locale=en">authorized</a>
                                </td>
                                <td class="order-service-payment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/3?locale=en">demo-sepa</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="order-id">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/2?locale=en">2</a>
                                </td>
                                <td class="order-address-name">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/2?locale=en">Mike Schuhmann</a>
                                </td>
                                <td class="order-product-price">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/2?locale=en">200 EUR</a>
                                </td>
                                <td class="order-datepayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/2?locale=en">2023-07-27 02:01:00</a>
                                </td>
                                <td class="order-statuspayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/2?locale=en">authorized</a>
                                </td>
                                <td class="order-service-payment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/2?locale=en">demo-invoice</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="order-id">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/1?locale=en">1</a>
                                </td>
                                <td class="order-address-name">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/1?locale=en">test user</a>
                                </td>
                                <td class="order-product-price">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/1?locale=en">200 EUR</a>
                                </td>
                                <td class="order-datepayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/1?locale=en">2023-07-26 02:01:00</a>
                                </td>
                                <td class="order-statuspayment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/1?locale=en">authorized</a>
                                </td>
                                <td class="order-service-payment">
                                    <a class="items-field" href="/admin/default/jqadm/get/order/1?locale=en">demo-invoice</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart line order-salesday col-xl-12">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-salesday-data" aria-expanded="true" aria-controls="order-salesday-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Sales of the last 30 days</h2>
                </div>
                <div id="order-salesday-data" class="collapse show content">
                    <div class="chart-legend">
                        <div class="legend">
                            <div class="item" data-index="0"><span class="color" style="background-color: rgba(48, 160, 224, 0.75);"></span><span class="label">EUR</span></div>
                            <div class="item" data-index="1"><span class="color" style="background-color: rgba(0, 176, 160, 0.75);"></span><span class="label">USD</span></div>
                        </div>
                    </div>
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas style="display: block; height: 216px; width: 1349px;" width="2023" height="324" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart line order-salesmonth col-xl-6">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-salesmonth-data" aria-expanded="true" aria-controls="order-salesmonth-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Sales per month</h2>
                </div>
                <div id="order-salesmonth-data" class="collapse show content">
                    <div class="chart-legend">
                        <div class="legend">
                            <div class="item" data-index="0"><span class="color" style="background-color: rgba(48, 160, 224, 0.75);"></span><span class="label">EUR</span></div>
                            <div class="item" data-index="1"><span class="color" style="background-color: rgba(0, 176, 160, 0.75);"></span><span class="label">USD</span></div>
                        </div>
                    </div>
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas width="969" height="324" style="display: block; height: 216px; width: 646px;" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart line order-salesweekday col-xl-6">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-salesweekday-data" aria-expanded="true" aria-controls="order-salesweekday-data">
                    <div class="card-tools-start">
                        <div class="btn btn-card-header act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Sales by weekday</h2>
                </div>
                <div id="order-salesweekday-data" class="collapse show content">
                    <div class="chart-legend">
                        <div class="legend">
                            <div class="item" data-index="0"><span class="color" style="background-color: rgba(48, 160, 224, 0.75);"></span><span class="label">EUR</span></div>
                            <div class="item" data-index="1"><span class="color" style="background-color: rgba(0, 176, 160, 0.75);"></span><span class="label">USD</span></div>
                        </div>
                    </div>
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas width="969" height="324" style="display: block; height: 216px; width: 646px;" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart matrix order-countday col-xl-12">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-countday-data" aria-expanded="true" aria-controls="order-countday-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Orders by day</h2>
                </div>
                <div id="order-countday-data" class="collapse show content">
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas width="2023" height="252" style="display: block; height: 168px; width: 1349px;" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart bar order-countpaystatus col-xl-6" data-labels="{&quot;&quot;:&quot;&quot;,&quot;-1&quot;:&quot;---&quot;,&quot;0&quot;:&quot;deleted&quot;,&quot;1&quot;:&quot;canceled&quot;,&quot;2&quot;:&quot;refused&quot;,&quot;3&quot;:&quot;refunded&quot;,&quot;4&quot;:&quot;pending&quot;,&quot;5&quot;:&quot;authorized&quot;,&quot;6&quot;:&quot;received&quot;,&quot;7&quot;:&quot;transferred&quot;}">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-countpaystatus-data" aria-expanded="true" aria-controls="order-countpaystatus-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Orders by payment status</h2>
                </div>
                <div id="order-salesday-data" class="collapse show content">
                    <div class="chart-legend">
                        <div class="legend">
                            <div class="item" data-index="0"><span class="color" style="background-color: rgba(211, 211, 211, 0.75);"></span><span class="label">---</span></div>
                            <div class="item" data-index="1"><span class="color" style="background-color: rgba(225, 87, 89, 0.75);"></span><span class="label">deleted</span></div>
                            <div class="item" data-index="2"><span class="color" style="background-color: rgba(242, 142, 43, 0.75);"></span><span class="label">canceled</span></div>
                            <div class="item" data-index="3"><span class="color" style="background-color: rgba(237, 201, 72, 0.75);"></span><span class="label">refused</span></div>
                            <div class="item" data-index="4"><span class="color" style="background-color: rgba(91, 179, 230, 0.75);"></span><span class="label">refunded</span></div>
                            <div class="item" data-index="5"><span class="color" style="background-color: rgba(48, 160, 224, 0.75);"></span><span class="label">pending</span></div>
                            <div class="item" data-index="6"><span class="color" style="background-color: rgba(0, 204, 187, 0.75);"></span><span class="label">authorized</span></div>
                            <div class="item" data-index="7"><span class="color" style="background-color: rgba(0, 176, 160, 0.75);"></span><span class="label">received</span></div>
                        </div>
                    </div>
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas width="969" height="324" style="display: block; height: 216px; width: 646px;" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart bar order-counthour col-xl-6">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-counthour-data" aria-expanded="true" aria-controls="order-counthour-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Orders by hour</h2>
                </div>
                <div id="order-counthour-data" class="collapse show content">
                    <div class="chart-legend"></div>
                    <div class="chart">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas width="969" height="324" style="display: block; height: 216px; width: 646px;" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart geo order-countcountry col-xl-12"
             data-labels="{&quot;AD&quot;:&quot;Andorra&quot;,&quot;AE&quot;:&quot;United Arab Emirates&quot;,&quot;AF&quot;:&quot;Afghanistan&quot;,&quot;AG&quot;:&quot;Antigua and Barbuda&quot;,&quot;AI&quot;:&quot;Anguilla&quot;,&quot;AL&quot;:&quot;Albania&quot;,&quot;AM&quot;:&quot;Armenia&quot;,&quot;AO&quot;:&quot;Angola&quot;,&quot;AQ&quot;:&quot;Antarctica&quot;,&quot;AR&quot;:&quot;Argentina&quot;,&quot;AS&quot;:&quot;American Samoa&quot;,&quot;AT&quot;:&quot;Austria&quot;,&quot;AU&quot;:&quot;Australia&quot;,&quot;AW&quot;:&quot;Aruba&quot;,&quot;AX&quot;:&quot;\u00c5land Islands&quot;,&quot;AZ&quot;:&quot;Azerbaijan&quot;,&quot;BA&quot;:&quot;Bosnia and Herzegovina&quot;,&quot;BB&quot;:&quot;Barbados&quot;,&quot;BD&quot;:&quot;Bangladesh&quot;,&quot;BE&quot;:&quot;Belgium&quot;,&quot;BF&quot;:&quot;Burkina Faso&quot;,&quot;BG&quot;:&quot;Bulgaria&quot;,&quot;BH&quot;:&quot;Bahrain&quot;,&quot;BI&quot;:&quot;Burundi&quot;,&quot;BJ&quot;:&quot;Benin&quot;,&quot;BL&quot;:&quot;Saint Barth\u00e9lemy&quot;,&quot;BM&quot;:&quot;Bermuda&quot;,&quot;BN&quot;:&quot;Brunei Darussalam&quot;,&quot;BO&quot;:&quot;Bolivia, Plurinational State of&quot;,&quot;BQ&quot;:&quot;Bonaire, Sint Eustatius and Saba&quot;,&quot;BR&quot;:&quot;Brazil&quot;,&quot;BS&quot;:&quot;Bahamas&quot;,&quot;BT&quot;:&quot;Bhutan&quot;,&quot;BV&quot;:&quot;Bouvet Island&quot;,&quot;BW&quot;:&quot;Botswana&quot;,&quot;BY&quot;:&quot;Belarus&quot;,&quot;BZ&quot;:&quot;Belize&quot;,&quot;CA&quot;:&quot;Canada&quot;,&quot;CC&quot;:&quot;Cocos (Keeling) Islands&quot;,&quot;CD&quot;:&quot;Congo, the Democratic Republic of the&quot;,&quot;CF&quot;:&quot;Central African Republic&quot;,&quot;CG&quot;:&quot;Congo&quot;,&quot;CH&quot;:&quot;Switzerland&quot;,&quot;CI&quot;:&quot;C\u00f4te d\u0027Ivoire&quot;,&quot;CK&quot;:&quot;Cook Islands&quot;,&quot;CL&quot;:&quot;Chile&quot;,&quot;CM&quot;:&quot;Cameroon&quot;,&quot;CN&quot;:&quot;China&quot;,&quot;CO&quot;:&quot;Colombia&quot;,&quot;CR&quot;:&quot;Costa Rica&quot;,&quot;CU&quot;:&quot;Cuba&quot;,&quot;CV&quot;:&quot;Cape Verde&quot;,&quot;CW&quot;:&quot;Cura\u00e7ao&quot;,&quot;CX&quot;:&quot;Christmas Island&quot;,&quot;CY&quot;:&quot;Cyprus&quot;,&quot;CZ&quot;:&quot;Czech Republic&quot;,&quot;DE&quot;:&quot;Germany&quot;,&quot;DJ&quot;:&quot;Djibouti&quot;,&quot;DK&quot;:&quot;Denmark&quot;,&quot;DM&quot;:&quot;Dominica&quot;,&quot;DO&quot;:&quot;Dominican Republic&quot;,&quot;DZ&quot;:&quot;Algeria&quot;,&quot;EC&quot;:&quot;Ecuador&quot;,&quot;EE&quot;:&quot;Estonia&quot;,&quot;EG&quot;:&quot;Egypt&quot;,&quot;EH&quot;:&quot;Western Sahara&quot;,&quot;ER&quot;:&quot;Eritrea&quot;,&quot;ES&quot;:&quot;Spain&quot;,&quot;ET&quot;:&quot;Ethiopia&quot;,&quot;FI&quot;:&quot;Finland&quot;,&quot;FJ&quot;:&quot;Fiji&quot;,&quot;FK&quot;:&quot;Falkland Islands (Malvinas)&quot;,&quot;FM&quot;:&quot;Micronesia, Federated States of&quot;,&quot;FO&quot;:&quot;Faroe Islands&quot;,&quot;FR&quot;:&quot;France&quot;,&quot;GA&quot;:&quot;Gabon&quot;,&quot;GB&quot;:&quot;United Kingdom&quot;,&quot;GD&quot;:&quot;Grenada&quot;,&quot;GE&quot;:&quot;Georgia&quot;,&quot;GF&quot;:&quot;French Guiana&quot;,&quot;GG&quot;:&quot;Guernsey&quot;,&quot;GH&quot;:&quot;Ghana&quot;,&quot;GI&quot;:&quot;Gibraltar&quot;,&quot;GL&quot;:&quot;Greenland&quot;,&quot;GM&quot;:&quot;Gambia&quot;,&quot;GN&quot;:&quot;Guinea&quot;,&quot;GP&quot;:&quot;Guadeloupe&quot;,&quot;GQ&quot;:&quot;Equatorial Guinea&quot;,&quot;GR&quot;:&quot;Greece&quot;,&quot;GS&quot;:&quot;South Georgia and the South Sandwich Islands&quot;,&quot;GT&quot;:&quot;Guatemala&quot;,&quot;GU&quot;:&quot;Guam&quot;,&quot;GW&quot;:&quot;Guinea-Bissau&quot;,&quot;GY&quot;:&quot;Guyana&quot;,&quot;HK&quot;:&quot;Hong Kong&quot;,&quot;HM&quot;:&quot;Heard Island and McDonald Islands&quot;,&quot;HN&quot;:&quot;Honduras&quot;,&quot;HR&quot;:&quot;Croatia&quot;,&quot;HT&quot;:&quot;Haiti&quot;,&quot;HU&quot;:&quot;Hungary&quot;,&quot;ID&quot;:&quot;Indonesia&quot;,&quot;IE&quot;:&quot;Ireland&quot;,&quot;IL&quot;:&quot;Israel&quot;,&quot;IM&quot;:&quot;Isle of Man&quot;,&quot;IN&quot;:&quot;India&quot;,&quot;IO&quot;:&quot;British Indian Ocean Territory&quot;,&quot;IQ&quot;:&quot;Iraq&quot;,&quot;IR&quot;:&quot;Iran, Islamic Republic of&quot;,&quot;IS&quot;:&quot;Iceland&quot;,&quot;IT&quot;:&quot;Italy&quot;,&quot;JE&quot;:&quot;Jersey&quot;,&quot;JM&quot;:&quot;Jamaica&quot;,&quot;JO&quot;:&quot;Jordan&quot;,&quot;JP&quot;:&quot;Japan&quot;,&quot;KE&quot;:&quot;Kenya&quot;,&quot;KG&quot;:&quot;Kyrgyzstan&quot;,&quot;KH&quot;:&quot;Cambodia&quot;,&quot;KI&quot;:&quot;Kiribati&quot;,&quot;KM&quot;:&quot;Comoros&quot;,&quot;KN&quot;:&quot;Saint Kitts and Nevis&quot;,&quot;KP&quot;:&quot;Korea, Democratic People\u0027s Republic of&quot;,&quot;KR&quot;:&quot;Korea, Republic of&quot;,&quot;KW&quot;:&quot;Kuwait&quot;,&quot;KY&quot;:&quot;Cayman Islands&quot;,&quot;KZ&quot;:&quot;Kazakhstan&quot;,&quot;LA&quot;:&quot;Lao People\u0027s Democratic Republic&quot;,&quot;LB&quot;:&quot;Lebanon&quot;,&quot;LC&quot;:&quot;Saint Lucia&quot;,&quot;LI&quot;:&quot;Liechtenstein&quot;,&quot;LK&quot;:&quot;Sri Lanka&quot;,&quot;LR&quot;:&quot;Liberia&quot;,&quot;LS&quot;:&quot;Lesotho&quot;,&quot;LT&quot;:&quot;Lithuania&quot;,&quot;LU&quot;:&quot;Luxembourg&quot;,&quot;LV&quot;:&quot;Latvia&quot;,&quot;LY&quot;:&quot;Libya&quot;,&quot;MA&quot;:&quot;Morocco&quot;,&quot;MC&quot;:&quot;Monaco&quot;,&quot;MD&quot;:&quot;Moldova, Republic of&quot;,&quot;ME&quot;:&quot;Montenegro&quot;,&quot;MF&quot;:&quot;Saint Martin (French part)&quot;,&quot;MG&quot;:&quot;Madagascar&quot;,&quot;MH&quot;:&quot;Marshall Islands&quot;,&quot;MK&quot;:&quot;Macedonia&quot;,&quot;ML&quot;:&quot;Mali&quot;,&quot;MM&quot;:&quot;Myanmar&quot;,&quot;MN&quot;:&quot;Mongolia&quot;,&quot;MO&quot;:&quot;Macao&quot;,&quot;MP&quot;:&quot;Northern Mariana Islands&quot;,&quot;MQ&quot;:&quot;Martinique&quot;,&quot;MR&quot;:&quot;Mauritania&quot;,&quot;MS&quot;:&quot;Montserrat&quot;,&quot;MT&quot;:&quot;Malta&quot;,&quot;MU&quot;:&quot;Mauritius&quot;,&quot;MV&quot;:&quot;Maldives&quot;,&quot;MW&quot;:&quot;Malawi&quot;,&quot;MX&quot;:&quot;Mexico&quot;,&quot;MY&quot;:&quot;Malaysia&quot;,&quot;MZ&quot;:&quot;Mozambique&quot;,&quot;NA&quot;:&quot;Namibia&quot;,&quot;NC&quot;:&quot;New Caledonia&quot;,&quot;NE&quot;:&quot;Niger&quot;,&quot;NF&quot;:&quot;Norfolk Island&quot;,&quot;NG&quot;:&quot;Nigeria&quot;,&quot;NI&quot;:&quot;Nicaragua&quot;,&quot;NL&quot;:&quot;Netherlands&quot;,&quot;NO&quot;:&quot;Norway&quot;,&quot;NP&quot;:&quot;Nepal&quot;,&quot;NR&quot;:&quot;Nauru&quot;,&quot;NU&quot;:&quot;Niue&quot;,&quot;NZ&quot;:&quot;New Zealand&quot;,&quot;OM&quot;:&quot;Oman&quot;,&quot;PA&quot;:&quot;Panama&quot;,&quot;PE&quot;:&quot;Peru&quot;,&quot;PF&quot;:&quot;French Polynesia&quot;,&quot;PG&quot;:&quot;Papua New Guinea&quot;,&quot;PH&quot;:&quot;Philippines&quot;,&quot;PK&quot;:&quot;Pakistan&quot;,&quot;PL&quot;:&quot;Poland&quot;,&quot;PM&quot;:&quot;Saint Pierre and Miquelon&quot;,&quot;PN&quot;:&quot;Pitcairn&quot;,&quot;PR&quot;:&quot;Puerto Rico&quot;,&quot;PS&quot;:&quot;Palestine, State of&quot;,&quot;PT&quot;:&quot;Portugal&quot;,&quot;PW&quot;:&quot;Palau&quot;,&quot;PY&quot;:&quot;Paraguay&quot;,&quot;QA&quot;:&quot;Qatar&quot;,&quot;RE&quot;:&quot;R\u00e9union&quot;,&quot;RO&quot;:&quot;Romania&quot;,&quot;RS&quot;:&quot;Serbia&quot;,&quot;RU&quot;:&quot;Russian Federation&quot;,&quot;RW&quot;:&quot;Rwanda&quot;,&quot;SA&quot;:&quot;Saudi Arabia&quot;,&quot;SB&quot;:&quot;Solomon Islands&quot;,&quot;SC&quot;:&quot;Seychelles&quot;,&quot;SD&quot;:&quot;Sudan&quot;,&quot;SE&quot;:&quot;Sweden&quot;,&quot;SG&quot;:&quot;Singapore&quot;,&quot;SH&quot;:&quot;Saint Helena, Ascension and Tristan da Cunha&quot;,&quot;SI&quot;:&quot;Slovenia&quot;,&quot;SJ&quot;:&quot;Svalbard and Jan Mayen&quot;,&quot;SK&quot;:&quot;Slovakia&quot;,&quot;SL&quot;:&quot;Sierra Leone&quot;,&quot;SM&quot;:&quot;San Marino&quot;,&quot;SN&quot;:&quot;Senegal&quot;,&quot;SO&quot;:&quot;Somalia&quot;,&quot;SR&quot;:&quot;Suriname&quot;,&quot;SS&quot;:&quot;South Sudan&quot;,&quot;ST&quot;:&quot;Sao Tome and Principe&quot;,&quot;SV&quot;:&quot;El Salvador&quot;,&quot;SX&quot;:&quot;Sint Maarten (Dutch part)&quot;,&quot;SY&quot;:&quot;Syrian Arab Republic&quot;,&quot;SZ&quot;:&quot;Swaziland&quot;,&quot;TC&quot;:&quot;Turks and Caicos Islands&quot;,&quot;TD&quot;:&quot;Chad&quot;,&quot;TF&quot;:&quot;French Southern Territories&quot;,&quot;TG&quot;:&quot;Togo&quot;,&quot;TH&quot;:&quot;Thailand&quot;,&quot;TJ&quot;:&quot;Tajikistan&quot;,&quot;TK&quot;:&quot;Tokelau&quot;,&quot;TL&quot;:&quot;Timor-Leste&quot;,&quot;TM&quot;:&quot;Turkmenistan&quot;,&quot;TN&quot;:&quot;Tunisia&quot;,&quot;TO&quot;:&quot;Tonga&quot;,&quot;TR&quot;:&quot;Turkey&quot;,&quot;TT&quot;:&quot;Trinidad and Tobago&quot;,&quot;TV&quot;:&quot;Tuvalu&quot;,&quot;TW&quot;:&quot;Taiwan&quot;,&quot;TZ&quot;:&quot;Tanzania, United Republic of&quot;,&quot;UA&quot;:&quot;Ukraine&quot;,&quot;UG&quot;:&quot;Uganda&quot;,&quot;UM&quot;:&quot;United States Minor Outlying Islands&quot;,&quot;US&quot;:&quot;United States&quot;,&quot;UY&quot;:&quot;Uruguay&quot;,&quot;UZ&quot;:&quot;Uzbekistan&quot;,&quot;VA&quot;:&quot;Vatican City State (Holy See)&quot;,&quot;VC&quot;:&quot;Saint Vincent and the Grenadines&quot;,&quot;VE&quot;:&quot;Venezuela, Bolivarian Republic of&quot;,&quot;VG&quot;:&quot;Virgin Islands, British&quot;,&quot;VI&quot;:&quot;Virgin Islands, U.S.&quot;,&quot;VN&quot;:&quot;Viet Nam&quot;,&quot;VU&quot;:&quot;Vanuatu&quot;,&quot;WF&quot;:&quot;Wallis and Futuna&quot;,&quot;WS&quot;:&quot;Samoa&quot;,&quot;XK&quot;:&quot;Kosovo&quot;,&quot;YE&quot;:&quot;Yemen&quot;,&quot;YT&quot;:&quot;Mayotte&quot;,&quot;ZA&quot;:&quot;South Africa&quot;,&quot;ZM&quot;:&quot;Zambia&quot;,&quot;ZW&quot;:&quot;Zimbabwe&quot;}">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-countcountry-data" aria-expanded="true" aria-controls="order-countcountry-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Orders by country</h2>
                </div>
                <div id="order-countcountry-data" class="collapse show">
                    <div class="row">
                        <div class="col-md-5 content">
                            <div>
                                <h3>Top countries</h3>
                                <table class="table list-items toplist">
                                    <tr class="item">
                                        <td class="country">Germany</td>
                                        <td class="number">2</td>
                                    </tr>
                                    <tr class="item">
                                        <td class="country">France</td>
                                        <td class="number">1</td>
                                    </tr>
                                    <tr class="item">
                                        <td class="country">United Kingdom</td>
                                        <td class="number">1</td>
                                    </tr>
                                    <tr class="item">
                                        <td class="country">India</td>
                                        <td class="number">1</td>
                                    </tr>
                                    <tr class="item">
                                        <td class="country">United States</td>
                                        <td class="number">1</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-7 content">
                            <div class="chart"
                                 data-map="{&quot;type&quot;:&quot;Topology&quot;,&quot;arcs&quot;:[[[6274,4899],[112,-125],[2,-33],[42,-58]],[[6430,4683],[-14,-71],[21,-54],[-7,-95],[22,-94],[11,-12]],[[6463,4357],[-24,-34],[-88,-48],[-57,12]],[[6294,4287],[-8,79],[-16,43],[-29,10]],[[6241,4419],[-59,52]],[[6182,4471],[-16,73],[-17,32],[-8,117]],[[6141,4693],[12,3],[29,63],[-8,55]],[[6174,4814],[10,41],[-12,33]],[[6172,4888],[11,7],[91,4]],[[5026,6554],[-1,-15]],[[5025,6539],[0,-88],[-96,3],[1,-148],[-28,-5],[-7,-30],[6,-83],[-115,0],[-6,-19]],[[4780,6169],[1,24]],[[4781,6193],[66,5],[16,47],[10,79],[40,63],[14,73],[19,49],[48,-1],[32,46]],[[1677,7789],[-82,82],[-53,24],[-12,87],[-38,24],[-5,47],[-36,72]],[[1451,8125],[15,64],[-49,37],[-49,107],[-62,80],[-58,-51],[-46,63],[-58,18],[0,330],[0,214]],[[1144,8987],[132,-47],[61,42],[44,-7],[161,51],[49,-52],[126,18],[45,-24],[177,-57],[12,-41],[104,17],[52,39],[59,9],[53,-46],[85,-21],[88,8],[23,46],[88,-30],[13,58],[-66,59],[2,64],[35,42],[69,-35],[39,-65],[-26,-28],[94,-26],[35,-37],[72,10],[1,63],[85,-13],[40,-28],[-20,-60],[17,-59],[-58,-41],[-80,-20],[-71,-113],[-41,-4],[-26,-62],[-70,-54],[-43,-111],[-1,-67],[43,-10],[27,-98],[41,11],[54,-25],[50,-49],[68,-40],[81,-9],[-5,-50],[30,-123],[44,-55],[23,19],[15,59],[-15,91],[-21,31],[47,27],[50,81],[-23,88],[-35,43],[34,61],[-22,143],[20,13],[81,-21],[24,15],[72,-76],[53,-4],[9,-122],[48,-43],[42,32],[48,91],[93,-195],[-12,-36],[66,-66],[65,-34],[12,-49],[35,-29],[2,-65],[-43,-42],[-48,-21],[-37,-47],[-50,-10],[-62,13],[-75,-4],[-24,-42],[64,-16],[26,-28],[-28,-39],[19,-106],[38,-29],[48,9],[14,-36],[-64,-35],[-62,-65],[-52,92]],[[3311,7565],[-20,33],[0,79],[-42,22],[-42,-115],[-25,-26],[-98,-1],[-57,-79],[-56,0],[-7,-44],[-102,-69],[-20,23],[29,87],[-12,103],[-31,27],[-38,62],[-102,82],[-36,-17],[-60,7],[-103,50],[-161,0],[-188,0],[-175,0],[-89,0],[-199,0]],[[2694,9258],[-125,26],[-14,60],[191,-23],[154,14],[38,-46],[-99,-21],[-145,-10]],[[3649,7923],[-16,-68],[9,-32],[69,-20],[25,-99],[-13,-51],[-32,9],[-61,48],[-88,-2],[0,53],[25,35],[49,125],[33,2]],[[2819,8721],[111,-80],[-26,-18],[-62,40],[-71,-61],[-24,57],[14,99],[58,-37]],[[2969,9140],[28,23],[194,-106],[71,-23],[54,-77],[-54,-27],[115,-51],[80,-97],[-52,-67],[-82,80],[-42,-40],[83,-76],[19,-57],[-47,-26],[3,-59],[-79,23],[-63,34],[-26,44],[-86,41],[-84,-9],[-6,63],[115,8],[1,50],[38,56],[-136,144],[-118,-2],[-107,13],[-134,46],[-20,85],[53,76],[54,-22],[124,34],[51,-60],[53,-21]],[[2508,9243],[117,-16],[-110,-106],[-52,53],[45,69]],[[1676,9358],[110,81],[81,-37],[-104,-48],[-87,4]],[[1657,7761],[-63,18],[-40,57],[-30,11],[-9,44],[76,-27],[66,-103]],[[1715,9261],[117,-15],[60,-41],[-109,-55],[-36,-66],[-78,-28],[-83,56],[58,105],[71,44]],[[2117,9342],[44,-48],[-173,-34],[-161,46],[68,73],[82,-20],[119,31],[21,-48]],[[2155,9182],[33,-23],[28,-97],[102,-57],[-43,-73],[-103,25],[-89,-24],[-127,-14],[-82,37],[-96,138],[45,67],[78,35],[81,-21],[173,7]],[[2334,9161],[2,65],[95,-21],[12,-105],[-48,-22],[-122,71],[61,12]],[[2391,9393],[10,-100],[-80,4],[-18,72],[88,24]],[[2464,9617],[37,35],[203,-51],[59,-57],[-95,-60],[-112,3],[-94,79],[2,51]],[[2593,9692],[361,72],[458,-14],[52,-31],[-272,-148],[-148,-45],[-127,-165],[-262,18],[36,82],[93,84],[-125,87],[-66,60]],[[2456,8975],[0,-43],[-103,37],[46,43],[57,-37]],[[3311,7565],[-27,-47],[-61,-37],[-20,-47],[5,-81],[-38,-31],[-60,-17],[-6,-54],[-45,-102],[-17,-1],[17,-137],[-19,-43],[-64,-55],[-51,-78],[-31,-62],[-4,-41],[42,-223],[-10,-97],[-23,0],[-49,155],[6,39],[-31,80],[-42,-18],[-37,45],[-82,-5],[-7,-67],[-43,-1],[-22,31],[-47,6],[-43,-18],[-55,-67],[-23,-54],[7,-87]],[[2431,6451],[-56,28],[-14,68],[-42,107],[-45,22],[-19,-46],[-39,35],[-17,62],[-43,64],[-51,0],[0,-24],[-82,0],[-111,69],[-68,0]],[[1844,6836],[-5,30],[-36,57],[-54,24],[-39,99],[-25,80],[-34,81],[-20,79],[5,98],[-9,44],[12,55],[7,105],[-6,77],[-17,77],[64,-1],[-10,48]],[[785,8308],[32,-22],[-54,-50],[-20,43],[42,29]],[[1451,8125],[-42,40],[-8,50],[-38,47],[-16,55],[-75,5],[-34,17],[-61,60],[-79,31],[-41,-5],[-92,52],[-27,-53],[-108,-47],[-26,52],[-42,-41],[22,-28],[-28,-42],[-61,-42],[-62,-82],[-63,0],[83,91],[6,44],[-45,5],[-82,70],[-57,10],[-45,41],[-23,57],[46,95],[44,-5],[62,68],[-44,19],[-117,8],[-49,56],[106,53],[21,-29],[61,2],[-108,112],[102,132],[156,60],[126,-44],[216,-36],[115,-16]],[[7843,7801],[-47,-44],[-18,-84],[-58,19],[-21,-103],[-73,-36],[26,-101],[-18,-48]],[[7634,7404],[-33,29],[-92,8],[-52,18],[-21,-46],[-49,20],[-25,-34]],[[7362,7399],[-56,-51],[-69,-12],[-20,48],[2,58],[-35,42],[-85,-13],[-28,52],[-75,68],[-75,-34],[1,-213]],[[6922,7344],[-15,-3],[-41,62],[-46,-32]],[[6820,7371],[0,59],[-34,19],[-13,52],[12,71],[51,0],[0,93],[-54,11],[-62,-38]],[[6720,7638],[-30,78],[-47,38],[32,119],[34,9],[60,63],[46,1],[99,-63],[31,24],[134,-14],[8,27],[-48,40],[51,59],[-8,60],[110,20],[88,35],[26,24],[53,-12],[9,-60],[31,14],[63,-48],[63,37],[37,-45],[66,-147],[15,30],[41,-33],[42,15],[63,-80],[38,8],[16,-36]],[[7362,7399],[-16,-43],[42,-7],[35,-31],[-38,-41],[-22,5]],[[7363,7282],[-10,42],[-39,-14],[-34,-105],[6,-43],[-16,-59]],[[7270,7103],[-39,13]],[[7231,7116],[1,35],[-70,53],[-52,67],[-15,60],[-53,20],[-3,46],[-39,30],[-78,-83]],[[9416,4803],[105,-73],[37,-59],[4,-34],[49,-35],[-20,-37],[7,-39],[26,-38],[19,-61],[29,-45],[2,-30],[-55,15],[-40,69],[-15,51],[-38,25],[-43,-36],[4,-42],[-23,-20],[-47,12]],[[9417,4426],[0,189],[-1,188]],[[9718,4616],[-47,-28],[-40,33],[73,17],[45,66],[-11,-67],[-20,-21]],[[9820,4645],[37,-70],[-13,-22],[-25,59],[1,33]],[[9417,4426],[-26,48],[-74,-7],[12,47],[19,16],[-22,112],[-57,48],[-24,5],[-44,54],[-49,41],[-5,70],[-26,11],[42,61],[47,-24],[13,-115],[30,-34],[25,61],[34,35],[26,0],[47,-41],[31,-11]],[[8946,4439],[3,-29]],[[8949,4410],[-19,-43],[-13,49],[29,23]],[[8738,5193],[-17,-52],[22,-55],[-5,-27],[33,-53],[-35,-7],[-9,-92],[-28,-39],[-1,-58],[-15,-68],[-34,-26],[-11,35],[-36,22],[-35,-21],[-10,28],[-44,4],[-4,77],[-29,66],[-1,104],[18,39]],[[8497,5070],[25,-72],[37,8],[32,34],[27,-16],[24,12],[37,167],[59,-10]],[[9075,4791],[18,-37],[-61,3],[7,32],[36,2]],[[9033,5079],[19,-36],[1,-74],[-36,43],[16,67]],[[8886,5004],[-6,-25],[-75,-12],[-4,-43],[43,-81],[28,-74],[-5,-20],[26,-66],[-16,-55],[-26,45],[-4,38],[-38,73],[4,-150],[-32,8],[9,54],[-5,55],[-21,40],[37,195],[25,43],[60,-25]],[[8462,4582],[4,-21],[57,-5],[6,24],[54,-28],[11,-38],[44,-10],[3,-57],[-33,24],[-57,2],[-61,33],[-34,-2],[-53,24],[-32,29],[20,55],[35,-3],[36,-27]],[[8342,4891],[15,-73],[21,-5],[15,-37],[-8,-72],[-1,-89],[-33,-1],[-24,48],[-38,47],[-35,83],[-37,124],[-25,48],[-20,95],[-26,37],[-15,49],[-53,96],[-3,30],[65,-14],[64,-120],[28,-62],[30,-1],[42,-88],[22,-26],[-12,-48],[28,-21]],[[3267,1908],[49,-131]],[[3316,1777],[-49,2],[0,129]],[[3590,3205],[-16,-106],[-8,-108]],[[3566,2991],[-2,-30],[37,-49],[-4,-40],[17,-54],[-28,-74],[-44,-31],[-58,-12],[-26,-29],[-1,-72],[-48,-28],[-39,6],[4,-58],[18,-47],[-24,-36],[-11,-89],[-28,-1],[-31,-73],[57,-54],[-11,-52],[-34,-32],[-19,-68],[-39,-50],[17,-91]],[[3269,1927],[-99,17],[-11,77],[-30,18],[-2,61],[22,25],[6,66],[26,126],[-17,192],[21,193],[18,21],[-9,109],[22,38],[-1,49],[17,56],[-21,164],[18,59],[-3,56],[30,107],[21,36],[-4,138],[32,28],[7,75]],[[3312,3638],[24,52],[67,-9],[38,-15]],[[3441,3666],[54,-94],[24,-9],[66,-65],[4,-26],[-28,-88],[62,-24],[23,9],[27,44],[5,51]],[[3678,3464],[29,-22],[-1,-46],[-44,-56],[-72,-135]],[[3316,1777],[-35,-41],[-84,32],[-3,57],[25,66],[48,17]],[[3239,3936],[18,-81],[15,-24],[-9,-56],[27,-145],[22,8]],[[3269,1927],[-67,-34],[-5,-54],[-45,17],[-70,74],[-1,70],[-15,39],[-4,98],[13,56],[31,45],[-45,16],[28,52],[11,146],[19,190],[13,40],[-11,122],[13,1],[38,186],[13,87],[-7,86],[9,48],[-4,72],[17,70],[5,112],[19,250],[-8,176]],[[3216,3892],[23,44]],[[6182,4471],[-59,-11],[-11,-189],[29,-33],[-12,-51],[-23,57],[-71,28],[-9,26],[-45,23]],[[5981,4321],[-51,-9],[2,69],[-10,22],[-5,129],[-67,8],[-12,-49],[-45,-4],[-18,49],[-16,78],[-87,0],[-31,-13]],[[5641,4601],[-4,18]],[[5637,4619],[24,58]],[[5661,4677],[34,16],[13,-27],[42,83],[-2,48],[13,56],[33,58],[9,59],[2,84],[16,102]],[[5821,5156],[3,41],[27,48],[43,-41],[43,-17],[59,62],[87,7]],[[6083,5256],[31,-54],[38,18],[32,-63]],[[6184,5157],[-1,-68],[-27,-101],[-8,-112]],[[6148,4876],[-17,-87]],[[6131,4789],[10,-96]],[[6500,4856],[-18,48],[0,211],[26,65]],[[6508,5180],[27,20],[26,41],[38,2],[83,174]],[[6682,5417],[33,84],[1,113]],[[6716,5614],[63,35],[-2,-80],[-14,-83],[-32,-139],[-26,-84],[-59,-144],[-101,-149],[-45,-114]],[[6274,4899],[0,61],[34,104],[-17,95],[-14,41]],[[6277,5200],[38,72]],[[6315,5272],[16,-9],[10,-52],[20,0],[37,-49],[42,-10],[36,48],[32,-20]],[[6500,4856],[-39,-51],[-19,-103],[-12,-19]],[[6001,5430],[-33,42],[3,65],[-20,61]],[[5951,5598],[-25,105],[16,115],[13,43],[26,-4],[-2,230]],[[5979,6087],[34,24],[0,116]],[[6013,6227],[118,0],[114,0],[116,0]],[[6361,6227],[10,-57],[-2,-70],[10,-69],[28,-36]],[[6407,5995],[-15,-33],[-31,-27],[-16,-124],[4,-23]],[[6349,5788],[-17,-107],[-18,-28],[-15,-68],[-14,-16],[-8,-113]],[[6277,5456],[-8,95],[-15,23],[0,84],[-26,-28],[2,-35],[-30,-74],[-40,28],[-30,-52],[-73,9],[-21,50],[-21,-8],[-15,-78],[1,-40]],[[5951,5598],[-34,-33],[-21,-63],[-28,-27],[-28,4],[-33,-69],[-37,-22],[-42,-5]],[[5728,5383],[-9,80],[-30,43],[7,28],[38,-3],[-16,53],[-1,77],[-12,37]],[[5705,5698],[-28,87],[13,76],[37,55],[2,75],[17,142],[-23,54],[-7,90]],[[5716,6277],[29,31],[117,-111],[117,-110]],[[3176,6094],[1,-96]],[[3177,5998],[-29,23],[-3,60],[31,13]],[[3176,6094],[27,10],[46,-33],[27,-40],[-11,-24],[-37,13],[-51,-22]],[[8031,9642],[63,13],[125,-85],[-71,-59],[-131,39],[-62,52],[76,40]],[[8297,9541],[65,-56],[-165,-23],[100,79]],[[9352,9359],[184,-33],[-23,-43],[-157,-12],[-58,38],[54,50]],[[5947,8097],[-90,6]],[[5857,8103],[47,44]],[[5904,8147],[43,-50]],[[6850,9221],[62,77],[162,68],[206,-1],[-194,-57],[-91,-55],[-89,-112],[44,-100],[-95,7],[-66,73],[61,100]],[[9472,8061],[10,-113],[41,-160],[-43,19],[-18,-84],[28,-59],[-47,-2],[0,119],[8,121],[-18,57],[3,79],[36,23]],[[9116,7397],[-4,10]],[[9112,7407],[15,31],[-4,118],[26,20],[35,-10],[30,119],[27,74],[-74,-40],[-45,0],[-12,54],[-34,41],[-51,19],[-51,175],[-69,39],[-76,-12],[-7,-75],[-84,-142],[-35,22]],[[8703,7840],[-35,-4],[-33,25],[-43,-41],[-66,-24],[-64,9],[-47,58],[-29,7],[-65,-18],[-41,24],[-6,44],[-94,45],[-30,-60],[11,-34],[-28,-40],[-72,17],[-19,27],[-56,18],[-101,-77],[-31,-10]],[[7854,7806],[-11,-5]],[[6720,7638],[-41,-43],[-30,-60],[27,-55],[-3,-39],[32,-68]],[[6705,7373],[-22,-38],[-42,41]],[[6641,7376],[-27,37],[-50,14],[-40,27],[-72,13]],[[6452,7467],[-71,71],[-4,43],[25,48],[-1,50]],[[6401,7679],[16,42],[29,4],[9,99],[-60,18],[-78,38],[-47,102],[-58,-14]],[[6212,7968],[-1,98],[-29,59],[4,43],[-80,36]],[[6106,8204],[-26,75]],[[6080,8279],[21,116]],[[6101,8395],[2,59]],[[6103,8454],[90,108],[11,29],[-43,40],[12,38],[-26,43],[19,49],[-34,66],[27,44],[-45,38],[5,41]],[[6119,8950],[73,28]],[[6192,8978],[159,-28],[111,-66],[24,-66],[-80,-45],[-131,44],[26,-50],[4,-86],[65,42],[71,-36],[5,57],[69,56],[54,-23],[71,34],[52,50],[164,77],[-7,-38],[112,15],[111,28],[-16,52],[87,-17],[147,-84],[19,30],[-66,48],[-7,92],[96,116],[77,-15],[15,-77],[76,49],[116,1],[26,77],[185,17],[10,68],[345,77],[159,72],[112,-56],[85,-1],[90,-50],[-7,-30],[-132,-66],[134,-34],[141,0],[7,-27],[123,-9],[2,44],[109,-10],[47,-30],[-4,-61],[83,-69],[76,34],[176,6],[-21,54],[38,25],[265,-38],[102,-78],[119,11],[82,-34],[33,-58],[202,8],[51,-52],[37,19],[-11,63],[155,-13],[84,-28],[-10519,-25],[159,-110],[80,-9],[57,-54],[-77,-31],[-1,-57],[-39,-10],[-131,64],[-48,-23],[10522,-26],[-12,-27],[32,-63],[-167,-77],[-88,-76],[-53,14],[-76,-46],[-81,5],[-44,-94],[34,-37],[-4,-84],[-27,-2],[-1,-73],[-51,-30],[-10,-66],[-44,-14],[-9,-59],[-42,-54],[-23,125],[-17,128],[15,80],[26,62],[45,13],[103,132],[53,46],[-30,29],[-74,-63],[-24,71],[-76,-20],[-73,-97],[24,-35],[-111,-21],[2,42],[-45,9],[-37,-29],[-89,10],[-97,-17],[-95,-113],[-112,-137],[46,-7],[14,-36],[80,12],[42,-63],[1,-50],[-23,-58],[-16,-161],[-44,-84],[-10,-40],[-98,-168],[-39,-34],[-37,27],[-44,-61]],[[6261,7614],[46,-14]],[[6307,7600],[7,-46],[-40,-34],[-13,94]],[[3485,1953],[35,35],[57,-37],[-77,-24],[-15,26]],[[5724,9564],[54,22],[134,-64],[-74,-23],[-56,-101],[-98,33],[-98,132],[138,1]],[[6119,8950],[12,41],[-83,3],[-42,-68],[-120,26]],[[5886,8952],[-23,-40],[-55,9],[-36,-32],[-49,-105],[-93,-178],[2,-76],[19,-30],[-10,-68],[-37,-73]],[[5604,8359],[-20,36],[-58,-67],[-39,-14],[-41,30],[-20,195],[27,38],[78,48],[58,60],[124,192],[130,116],[112,23],[45,48],[106,9],[92,-43],[-6,-52]],[[6084,9586],[-44,-31],[-171,3],[-80,43],[163,20],[132,-35]],[[3908,9735],[239,53],[338,-2],[437,-129],[-162,-67],[-58,-80],[36,-102],[-40,-51],[14,-104],[-120,-129],[50,-82],[-18,-30],[-158,-97],[-149,-42],[-40,-61],[-63,-41],[-102,-30],[-40,-114],[-48,-46],[12,-46],[-28,-104],[-42,-3],[-43,47],[-59,0],[-99,160],[-18,90],[-41,53],[-9,63],[29,68],[44,22],[-94,50],[20,113],[-21,60],[-113,169],[-79,34],[-212,-2],[-85,55],[-52,82],[219,56],[-68,41],[157,96],[466,50]],[[7302,2140],[47,-25],[-7,-38],[-45,-3],[5,66]],[[8946,4439],[3,-29]],[[5759,3300],[63,-27],[42,34],[0,213]],[[5864,3520],[25,-63],[4,-56],[21,6],[50,84],[26,-23],[43,11],[43,110],[26,44],[41,42]],[[6143,3675],[52,-9]],[[6195,3666],[22,-122],[-3,-86]],[[6214,3458],[-23,7],[-11,-59],[18,-31],[23,32]],[[6221,3407],[22,-1]],[[6243,3406],[-11,-90],[-33,-64],[-37,-100],[-54,-95],[-72,-68],[-94,5],[-87,-55],[-40,55],[-1,128],[-55,178]],[[6130,3278],[-13,18],[-45,-71],[22,-45],[32,34],[4,64]],[[2431,6451],[-17,-93],[-5,-106],[20,-104],[38,-105],[43,-39],[89,42],[18,23],[15,100],[51,28],[44,3],[6,-40],[-16,-34],[-14,-116],[-13,14]],[[2690,6024],[-25,-40]],[[2665,5984],[-54,1],[15,-102],[-37,0],[-14,-88]],[[2575,5795],[-33,62],[-40,34],[-54,-32],[-126,88],[-32,43],[-46,22],[-44,59],[-21,65],[13,37],[-22,98],[-70,139],[-30,38],[4,36],[-32,41],[-54,104],[-27,128],[-48,37],[3,-95],[50,-101],[6,-37],[34,-65],[27,-106],[38,-84],[-26,3],[-56,76],[-3,74],[-64,65],[9,83],[-40,57],[-47,172]],[[3590,3205],[19,6],[93,-112],[17,-39],[-5,-60]],[[3714,3000],[-12,-37],[-33,-32],[-85,28],[-18,32]],[[3678,3464],[9,68],[-10,42],[-22,-7],[-6,76],[-26,33],[-42,-1],[1,79],[-8,32]],[[3574,3786],[19,116],[-23,52],[2,57],[-57,2],[-11,67],[1,77],[-35,16],[-44,50],[-33,10],[-32,51],[2,105],[-38,-10],[-48,-63],[-37,4]],[[3240,4320],[-29,-3],[1,88],[-24,-35],[-25,2],[-41,94],[-12,52],[25,52],[7,78],[61,60],[27,-3]],[[3230,4705],[13,159],[-4,58],[-13,21],[6,110],[57,-1],[29,-26]],[[3318,5026],[16,-30],[63,44],[-5,133],[46,12],[54,31],[6,39]],[[3498,5255],[36,-72],[-13,-70],[9,-56],[18,-27],[73,34]],[[3621,5064],[17,35],[43,-12]],[[3681,5087],[46,-10],[38,117]],[[3765,5194],[10,3],[23,-133],[17,-50],[-13,-65],[52,-9],[109,-76],[14,-34],[86,-45],[44,2],[44,-48],[37,-64],[48,-19],[10,-19],[15,-108],[-11,-96],[-57,-118],[-18,-66],[-38,-94],[2,-108],[-11,-127],[-14,-100],[-30,-76],[-5,-60],[-31,-60],[-32,1],[-46,-23],[-53,-42],[-35,-46],[-24,-58],[0,-75],[-12,-87],[-21,-31],[-32,-102],[-46,-73],[-33,-88]],[[3574,3786],[-28,48],[-78,-16],[-14,-51],[-13,-101]],[[3239,3936],[18,63],[-12,48],[12,70],[9,110],[-26,93]],[[3216,3892],[-32,57],[-58,58],[-76,99],[-7,64],[-25,76],[-56,222],[-22,69],[-43,62],[9,25],[-14,56],[9,40],[23,37]],[[2924,4757],[-4,-59],[53,-8],[24,90],[35,23],[32,60],[5,82]],[[3069,4945],[8,5],[42,-69],[18,-61],[66,3],[22,-27],[-10,-60],[15,-31]],[[3069,4945],[-27,33],[-33,-2],[-42,58]],[[2967,5034],[12,72],[15,4],[24,66],[-12,101],[1,64],[-12,31]],[[2995,5372],[19,41],[-3,42]],[[3011,5455],[15,-1],[34,46],[6,68],[38,40],[23,-5],[48,70],[13,-38]],[[3188,5635],[-19,-10],[-28,-67],[-11,-75],[15,-4],[24,-121],[55,-2],[21,-49],[60,-1],[-14,-92],[15,-68],[-15,-29],[18,-33],[9,-58]],[[2995,5372],[-21,86],[-15,16],[-40,-52],[-12,-51],[-24,52],[-37,7]],[[2846,5430],[13,77]],[[2859,5507],[32,-45],[55,48],[44,-21],[21,-34]],[[2846,5430],[-19,47],[-64,63],[3,55]],[[2766,5595],[60,-8]],[[2826,5587],[33,-80]],[[2766,5595],[-24,42],[-23,68]],[[2719,5705],[16,44],[28,5],[26,55],[14,-9],[38,21]],[[2841,5821],[-12,-108],[-3,-126]],[[2719,5705],[-14,23]],[[2705,5728],[2,23],[-48,37]],[[2659,5788],[6,37],[27,39]],[[2692,5864],[52,3],[13,13],[48,-10],[36,-49]],[[2705,5728],[-21,-13],[-47,33]],[[2637,5748],[22,40]],[[2665,5984],[6,-111]],[[2671,5873],[21,-9]],[[2637,5748],[-33,12],[-29,35]],[[2690,6024],[-2,-114],[-17,-37]],[[3188,5635],[-2,-47],[36,24],[37,4],[21,-52],[57,6],[40,-33],[16,32],[47,-12],[56,-61],[4,-46],[27,-12]],[[3527,5438],[-23,-34],[7,-43],[-25,-20],[-7,-43],[19,-43]],[[3527,5438],[19,-22],[58,-117]],[[3604,5299],[-5,-52],[-18,-15],[-4,-43],[44,-125]],[[3604,5299],[35,-11],[27,14],[31,-15]],[[3697,5287],[-15,-50],[14,-74],[-15,-76]],[[3697,5287],[32,-20],[36,-73]],[[5461,7816],[57,-26],[-19,-81]],[[5499,7709],[-42,-52],[24,-42]],[[5481,7615],[-3,-56],[20,-77]],[[5498,7482],[-26,-33],[-58,16],[-43,-19],[-3,-35]],[[5368,7411],[-34,-7],[-98,40],[-12,22]],[[5224,7466],[15,35],[6,115],[-52,90],[-45,22],[-3,43],[38,12],[50,-15],[18,41],[68,45],[35,59]],[[5354,7913],[52,-72],[40,-21]],[[5446,7820],[15,-4]],[[2924,4757],[-18,135],[10,9],[15,97],[36,36]],[[2867,6295],[48,-4],[39,-41],[28,6],[53,-75],[27,-11],[42,-43],[-43,-23],[-62,-1],[-28,100],[-91,35],[-28,28],[-21,-30],[-22,23],[58,36]],[[6143,3675],[-41,35],[-21,64],[-34,63],[-26,90]],[[6021,3927],[52,-11],[17,37],[56,95],[22,8]],[[6168,4056],[76,-69],[-3,-174],[-15,-81],[-31,-66]],[[5864,3520],[0,169],[29,2],[0,206],[67,23],[12,-24],[44,36]],[[6016,3932],[5,-5]],[[5759,3300],[-33,86],[-23,187],[-5,101],[-26,72],[-22,106],[-24,56],[-2,44]],[[5624,3952],[32,21],[41,-24],[119,3],[20,-28],[71,-8],[54,24]],[[5961,3940],[24,13],[31,-21]],[[4790,5740],[-14,77],[21,70]],[[4797,5887],[55,27],[34,-32],[37,-83]],[[4923,5799],[19,-125]],[[4942,5674],[-29,-7],[-35,15]],[[4878,5682],[-54,2],[-33,-14]],[[4791,5670],[-5,45]],[[4786,5715],[4,25]],[[4923,5799],[15,45],[30,-15],[32,21],[118,1],[1,47],[-14,250],[-14,250],[45,1]],[[5136,6399],[99,-127],[98,-126],[7,-27],[32,-26],[1,-37],[32,6]],[[5405,6062],[0,-133],[-18,-75],[-66,-14],[-30,-23]],[[5291,5817],[-26,11],[-44,-32],[-44,-71],[-23,-6],[-4,-40],[-23,-48],[-6,-77]],[[5121,5554],[-18,-16],[-59,6]],[[5044,5544],[-10,69],[-22,53],[-30,-27],[-40,35]],[[5025,6539],[111,-140]],[[4797,5887],[9,114],[-3,115],[-23,53]],[[5359,5316],[-24,-7]],[[5335,5309],[-8,40],[2,133],[-26,77],[3,31]],[[5306,5590],[37,54]],[[5343,5644],[21,18],[22,-34]],[[5386,5628],[3,-92],[-29,-90],[-1,-130]],[[5705,5698],[-9,-22]],[[5696,5676],[-25,62],[-30,-30],[-23,17],[-41,-3],[-33,-26],[-35,30],[-29,-14],[-40,44],[-32,-7],[-20,-69],[-2,-52]],[[5343,5644],[1,40],[-34,13],[-17,66],[-2,54]],[[5405,6062],[42,26],[84,113],[101,111]],[[5632,6312],[46,-25],[17,-32],[21,22]],[[5696,5676],[7,-53],[-25,-45],[-24,-120],[-16,-24],[-13,-76],[-21,-20],[-27,23],[-26,-35],[-22,-96]],[[5529,5230],[-53,-31],[-23,1],[-25,78],[-21,38],[-48,0]],[[5728,5383],[-22,-69],[-1,-87],[45,-142]],[[5750,5085],[-2,-31],[-47,29],[-37,2]],[[5664,5085],[-53,-1]],[[5611,5084],[-48,2]],[[5563,5086],[4,45],[-25,48],[-13,51]],[[5335,5309],[-24,-12]],[[5311,5297],[-17,86],[-3,160],[-10,48]],[[5281,5591],[25,-1]],[[5311,5297],[-89,-71],[-26,17]],[[5196,5243],[-11,72],[20,114],[-8,83]],[[5197,5512],[-3,76],[87,3]],[[5121,5554],[32,-44],[24,16],[20,-14]],[[5196,5243],[-34,10],[-53,-10],[-55,-37]],[[5054,5206],[4,78],[-30,44],[4,70]],[[5032,5398],[18,52],[-14,70],[8,24]],[[5032,5398],[-14,-21],[-24,71],[-14,-8]],[[4980,5440],[-26,95],[-38,-12],[-25,-54]],[[4891,5469],[-39,76],[-16,47]],[[4836,5592],[41,45],[1,45]],[[4836,5592],[-28,28],[-17,50]],[[5054,5206],[-38,27],[-72,113]],[[4944,5346],[36,94]],[[4944,5346],[-44,59],[-9,64]],[[5821,5156],[-38,13],[-33,-84]],[[6001,5430],[48,-98],[7,-34],[27,-42]],[[5661,4677],[-32,-15]],[[5629,4662],[-24,61]],[[5605,4723],[23,32],[-11,39],[29,21],[44,-4],[13,65],[-17,80],[13,67],[-29,7],[-6,55]],[[5605,4723],[-49,107],[-18,59],[20,123]],[[5558,5012],[53,3],[0,69]],[[5558,5012],[5,74]],[[6241,4419],[21,-74],[-11,-63],[6,-48],[-18,-74],[15,-15]],[[6254,4145],[-89,-48],[3,-41]],[[5961,3940],[-39,83],[1,184],[62,0],[-4,114]],[[6294,4287],[-8,-44],[8,-75],[21,-18],[12,-42],[2,-74],[-21,-53],[-19,36],[2,91],[-37,37]],[[6463,4357],[4,-26],[4,-199],[5,-29],[-20,-81],[-19,-36],[-60,-50],[-77,-127],[-2,-41],[25,-93],[-3,-117],[-72,-72],[-12,-21],[7,-59]],[[6221,3407],[-7,51]],[[5637,4619],[-8,43]],[[5624,3952],[1,88],[29,153],[26,64],[1,76],[-23,90],[10,35],[-27,143]],[[6131,4789],[18,-4],[25,29]],[[6328,6846],[-5,-18]],[[6323,6828],[-5,-52]],[[6318,6776],[-14,-115]],[[6304,6661],[-19,99]],[[6285,6760],[25,108]],[[6310,6868],[21,11]],[[6331,6879],[-3,-33]],[[6310,6868],[26,90]],[[6336,6958],[18,-25],[-23,-54]],[[6733,4232],[15,-63],[13,-96],[-29,-109],[-2,-49],[-26,-147],[-42,-258],[-50,-38],[-40,36],[-23,169],[5,42],[28,73],[2,37],[-14,117],[14,69],[55,25],[40,69],[34,87],[20,36]],[[6323,6828],[-5,-52]],[[4786,5715],[4,25]],[[5558,6707],[-12,104],[-43,72],[-2,44],[18,32],[8,132]],[[5527,7091],[32,24],[42,-96],[-4,-50],[-19,-29],[39,-69]],[[5617,6871],[-2,-44],[-43,-58],[-14,-62]],[[5026,6554],[0,68],[47,43],[53,25],[11,28],[35,23],[1,43],[30,27],[39,9],[-15,131],[-11,38]],[[5216,6989],[107,83],[98,15],[43,14],[63,-10]],[[5558,6707],[11,-78],[-4,-141],[-12,-24],[29,-100],[14,11],[36,-63]],[[6328,6846],[32,-23],[58,62]],[[6418,6885],[12,-70]],[[6430,6815],[-65,-38],[30,-58],[-37,-37],[-20,-39],[-33,9]],[[6305,6652],[-1,9]],[[6793,6356],[71,-7],[61,112]],[[6925,6461],[5,-20]],[[6930,6441],[4,-45]],[[6934,6396],[-17,-38],[-18,-90]],[[6899,6268],[-5,-13],[-89,30],[-12,71]],[[6770,6386],[6,72],[17,-11],[-6,-68]],[[6787,6379],[-17,7]],[[6687,6688],[13,-82]],[[6700,6606],[-54,31]],[[6646,6637],[22,56],[19,-5]],[[6418,6885],[65,60],[8,112],[31,51]],[[6522,7108],[71,-4]],[[6593,7104],[19,-69],[20,-17],[-20,-99],[21,-55],[35,-32],[16,-44],[-5,-42],[26,-61]],[[6705,6685],[-18,3]],[[6646,6637],[-54,5],[-83,116],[-44,41],[-35,16]],[[6934,6396],[30,-61],[39,-18],[31,-72],[-38,-109],[-24,-40],[3,-39],[-34,-29],[-10,-40],[-30,-37],[-63,-34]],[[6838,5917],[-33,136]],[[6805,6053],[88,58],[20,116],[-14,41]],[[6925,6461],[5,-20]],[[8289,5659],[-7,70],[19,48],[38,11],[27,-8]],[[8366,5780],[25,-23],[13,40],[26,-22]],[[8430,5775],[7,-38],[-4,-69],[-49,-45],[-44,-63]],[[8340,5560],[-24,9],[-27,90]],[[8289,5659],[-26,26],[-21,45],[-26,-1],[-2,-63],[-25,-136],[21,-44],[17,-103],[49,-69]],[[8276,5314],[-9,-24],[-51,38]],[[8216,5328],[-47,111],[2,89]],[[8171,5528],[30,114],[-14,112],[-20,46],[14,90],[-30,80],[-2,61],[13,63],[21,3],[34,38]],[[8217,6135],[14,-53],[20,-2],[-7,-113],[31,34],[26,-8],[28,16],[23,-47],[2,-57],[23,-50],[-11,-75]],[[8217,6135],[31,59]],[[8248,6194],[29,59]],[[8277,6253],[30,-98],[36,0],[12,-51],[-27,-36],[35,-34],[72,-201],[-5,-58]],[[8171,5528],[6,88],[-10,34],[3,63],[-12,30],[-15,142],[-13,48],[-52,-70],[-35,19],[10,71],[-6,55],[-58,142]],[[7989,6150],[9,79]],[[7998,6229],[15,14],[5,104],[22,-13],[31,124],[-1,33],[57,65],[8,33]],[[8135,6589],[17,4],[23,-48],[-1,-92],[-27,-48],[-4,-69],[31,10],[17,-113],[57,-39]],[[8277,6253],[68,21],[25,31],[41,-32],[9,-57],[29,-15]],[[8449,6201],[-39,-50],[-31,-95],[50,-136],[45,-82],[13,-108],[-4,-101],[-58,-76],[-60,-102],[-11,37],[8,40],[-22,32]],[[9116,7397],[-32,-36],[1,-42],[-64,-65],[24,-66]],[[9045,7188],[-64,-50]],[[8981,7138],[-43,21],[20,74],[-33,31]],[[8925,7264],[56,68],[21,41],[79,35],[31,-1]],[[9045,7188],[32,-106],[1,-67],[-11,-31],[-50,-35],[-27,-5],[2,74],[-13,61],[2,59]],[[8703,7840],[-35,-101],[53,-25],[22,21],[50,-59],[-69,-22],[-42,-54],[-74,-54],[-46,17],[-16,-37],[14,-41],[-41,-51],[-34,-20],[-92,-22],[-34,-31],[-49,17],[-43,36],[-68,0],[-93,12],[-30,88],[-54,42],[-74,18],[-11,25],[11,68],[-20,46],[-42,22],[-32,71]],[[7998,6229],[-22,121],[14,49],[-72,17],[-3,40],[-37,28],[-11,-39],[22,-31],[-25,-43],[28,-141]],[[7892,6230],[-5,-21],[-56,-12],[2,-43],[-16,-34],[-42,-39],[-33,-68],[-51,-75],[0,-26],[-55,-38],[-9,-45],[8,-123],[-12,-55],[-1,-98],[-28,-47],[-40,-91],[-27,54],[-25,139],[-26,83],[-12,108],[-27,80],[-21,186],[-6,124],[-42,-34],[-21,7],[-38,70],[5,43],[-34,49]],[[7280,6324],[19,39],[65,0],[-26,124],[-19,26],[32,60],[35,-4],[30,60],[47,117],[0,41],[25,34],[-24,29],[-21,89],[15,25],[44,-14],[33,9],[28,48]],[[7563,7007],[32,-67],[-14,-99],[9,-64],[69,-77]],[[7659,6700],[-18,-26],[-12,-54],[95,-83],[40,-7],[17,-30],[82,-18],[2,85]],[[7865,6567],[20,-34]],[[7885,6533],[27,-33],[68,7],[-10,54]],[[7970,6561],[23,7],[61,80],[25,-15],[20,25],[36,-69]],[[7989,6150],[-27,121],[-27,2],[-7,-56],[-36,13]],[[7885,6533],[36,58],[49,-30]],[[7659,6700],[36,-4],[56,-74],[46,-36],[68,-19]],[[7280,6324],[-22,15],[-31,86],[-54,-11],[-89,-9]],[[7084,6405],[11,67],[42,30],[-16,36],[-1,51],[-28,25],[-26,66]],[[7066,6680],[49,-30],[73,9],[38,24],[1,49],[16,33],[59,18],[22,86],[35,51],[22,68],[-11,53],[18,25],[97,36]],[[7485,7102],[30,-71],[48,-24]],[[7270,7103],[67,26],[20,52],[22,-34],[8,-68],[42,44],[50,-4]],[[7479,7119],[6,-17]],[[7066,6680],[26,52],[-24,47],[-12,123],[19,114]],[[7075,7016],[30,-22],[68,61],[6,46],[52,15]],[[7363,7282],[-14,-37],[37,-19],[55,9]],[[7441,7235],[8,-53],[27,-8],[3,-55]],[[7634,7404],[-61,-67],[-37,-7],[-11,-37],[-31,8],[-49,-39],[-4,-27]],[[7075,7016],[-57,102],[-56,36],[-54,-4],[-46,-44]],[[6862,7106],[-2,101],[-34,63],[6,49],[28,-14],[26,18],[-30,68],[-36,-20]],[[6593,7104],[-19,131],[20,17]],[[6594,7252],[19,-49],[21,-8]],[[6634,7195],[10,2]],[[6644,7197],[35,43],[9,-42],[26,-27]],[[6714,7171],[9,-43],[48,-41],[42,-10],[49,29]],[[7084,6405],[-120,38],[-13,71],[-14,10],[-52,-38],[-36,19],[-29,45],[-29,16],[-41,132],[-34,10],[-11,-23]],[[6336,6958],[4,68]],[[6340,7026],[27,47],[33,16],[39,-11],[34,22],[49,8]],[[6634,7195],[-40,57]],[[6594,7252],[-33,31],[-3,48]],[[6558,7331],[41,9]],[[6599,7340],[44,-103],[1,-40]],[[5886,8952],[84,-67],[11,-112]],[[5981,8773],[-50,-16],[-24,-76],[-103,-97],[-22,-81],[49,-73],[-27,-65],[-30,-14],[-12,-97],[-16,-54],[-36,6],[-16,-46],[-34,-3],[-56,202]],[[6212,7968],[-74,-42],[-85,27],[-53,3],[-30,-18]],[[5970,7938],[8,65],[-9,70]],[[5969,8073],[60,22],[28,77]],[[6057,8172],[49,32]],[[6401,7679],[-95,-48],[1,-31]],[[6261,7614],[-79,35],[-34,-75]],[[6148,7574],[-40,12]],[[6108,7586],[21,44],[24,6],[-19,86],[-47,36],[-26,-14]],[[6061,7744],[-52,-28],[-63,8]],[[5946,7724],[-18,32]],[[5928,7756],[14,38]],[[5942,7794],[-1,23],[44,71],[-15,50]],[[5942,7794],[-28,22],[-53,-15],[-28,17]],[[5833,7818],[-38,50],[-74,43]],[[5721,7911],[-28,108],[1,45]],[[5694,8064],[103,63],[60,-24]],[[5947,8097],[22,-24]],[[5778,7738],[-23,-73]],[[5755,7665],[-70,-20]],[[5685,7645],[-49,35],[-50,-13]],[[5586,7667],[-25,37]],[[5561,7704],[101,6],[17,72]],[[5679,7782],[48,9],[51,-25]],[[5778,7766],[0,-28]],[[5946,7724],[-18,-12],[-31,-78],[-24,-11]],[[5873,7623],[-41,-13]],[[5832,7610],[-35,3],[-31,31]],[[5766,7644],[-11,21]],[[5778,7738],[26,-21],[86,50],[38,-11]],[[6108,7586],[-3,76],[-44,82]],[[6148,7574],[-22,-22],[-8,-69]],[[6118,7483],[-39,27],[-49,-28],[-77,7],[-8,24]],[[5945,7513],[-33,31],[-39,79]],[[5904,8147],[-6,49]],[[5898,8196],[33,17],[78,3],[48,-44]],[[5898,8196],[15,80],[80,22]],[[5993,8298],[25,10],[62,-29]],[[5993,8298],[-28,80],[74,25],[62,-8]],[[5721,7911],[-82,-49],[8,-41],[32,-39]],[[5561,7704],[-62,5]],[[5461,7816],[-4,38]],[[5457,7854],[4,39]],[[5461,7893],[27,136],[-5,19]],[[5483,8048],[55,31],[-8,55]],[[5530,8134],[41,1]],[[5571,8135],[60,-45],[16,15],[47,-41]],[[6118,7483],[-26,-66],[9,-33]],[[6101,7384],[-55,-10]],[[6046,7374],[-27,-34],[-21,20],[-45,-14]],[[5953,7346],[-17,56]],[[5936,7402],[18,52],[-9,59]],[[6046,7374],[-2,-58]],[[6044,7316],[-33,7],[-15,-48],[-46,-27],[4,-39],[31,-44],[0,-33],[-69,-46],[-16,84],[-29,76]],[[5871,7246],[26,71]],[[5897,7317],[56,29]],[[6340,7026],[-17,43],[-25,14],[-20,-34],[-44,-6],[-24,31],[-32,2],[-27,-31],[-28,31],[-32,-1],[-39,89],[14,45],[-18,28],[32,55],[45,3],[13,44],[56,-8],[69,54],[49,1],[93,-63],[59,4],[35,30]],[[6499,7357],[31,3],[28,-29]],[[6101,7384],[24,-55],[-35,-3],[-37,-49],[-9,39]],[[5871,7246],[-22,37],[-1,94]],[[5848,7377],[21,41]],[[5869,7418],[15,-42]],[[5884,7376],[13,-59]],[[5832,7610],[6,-61]],[[5838,7549],[-90,22],[-6,-24],[56,-104],[26,-22]],[[5824,7421],[-3,-9]],[[5821,7412],[-71,59],[-25,43],[-8,48],[-35,24]],[[5682,7586],[48,-2],[36,60]],[[5586,7667],[-78,-62],[-27,10]],[[5446,7820],[11,34]],[[5354,7913],[23,12]],[[5377,7925],[49,7],[35,-39]],[[5377,7925],[41,101],[65,22]],[[5015,7377],[69,0],[-12,-165],[2,-55],[-13,-57]],[[5061,7100],[-42,-13],[2,81],[-20,27],[22,117],[-8,65]],[[5015,7377],[-11,66],[42,42],[106,-20],[72,1]],[[5368,7411],[1,-33],[-28,-39],[-37,-12],[-32,-99],[11,-33],[-23,-63],[-43,-56],[-65,0],[-30,-42],[-33,57],[-28,9]],[[5098,8071],[5,-42],[-22,-51],[-52,-35],[-42,9],[24,61],[-15,58],[62,73]],[[5058,8144],[0,-62],[40,-11]],[[10143,3734],[-9,-35],[-38,72],[8,18],[39,-55]],[[10469,2635],[-26,-71],[-40,1],[17,47],[-41,56],[22,41],[3,82],[-48,124],[38,-2],[29,-112],[42,-39],[51,10],[-16,-85],[-22,1],[-9,-53]],[[10257,2433],[43,61],[28,90],[63,-47],[-57,-122],[-25,-21],[-24,-97],[-38,-42],[-78,24],[11,64],[37,57],[40,33]],[[9612,2592],[18,-4],[2,-68],[-44,-91],[-24,5],[-39,138],[48,1],[39,19]],[[8980,3090],[-56,-44],[-17,-53],[-69,4],[-41,-9],[-55,-63],[-41,2],[-47,48],[15,41],[8,74],[-19,93],[-3,66],[-26,78],[-21,144],[-2,72],[13,76],[24,71],[61,66],[21,-3],[53,46],[47,16],[41,86],[2,54],[20,49],[24,17],[55,109],[40,24],[38,-61],[31,26],[35,109],[18,21],[40,4],[29,19],[51,-27],[35,22],[13,-28],[-44,-137],[25,-48],[23,-19],[64,-87],[28,-19],[19,20],[25,134],[-6,78],[5,75],[24,100],[11,-64],[19,-61],[12,-99],[19,22],[23,-47],[8,-105],[15,-56],[7,-69],[72,-83],[25,-113],[30,-4],[5,-61],[58,-104],[7,-116],[14,-49],[-20,-204],[-13,-53],[-22,-28],[-48,-196],[-2,-58],[-50,-22],[-58,-71],[-54,55],[-25,-42],[-88,46],[-19,35],[-12,73],[-42,31],[-23,52],[16,62],[-45,-26],[-11,-46],[-50,131],[-87,65],[-52,-5],[-72,-40],[-28,4]],[[7679,5389],[-4,-60],[-38,-30],[-14,46],[-5,83],[13,94],[20,-32],[28,-101]],[[8491,6007],[-24,17],[-1,50],[47,43],[23,-24],[-19,-59],[-26,-27]],[[8925,7264],[-62,-44],[-23,34],[24,39],[-16,30],[-59,-61],[-18,-37],[-43,-30],[15,-39],[48,-52],[33,41],[45,-24],[5,-30],[-42,-17],[-42,-60],[-15,-40],[32,-32],[11,-57],[38,-98],[-19,-58],[24,-49],[-12,-93],[-16,-5],[-45,-139],[-27,-69],[-82,-102],[-33,-7],[-18,-25],[-67,-39],[-58,-9],[-54,9]],[[8852,6365],[-30,-140],[-19,92],[41,100],[8,-52]],[[5685,7645],[4,-53]],[[5689,7592],[-47,-12],[7,-75],[28,-29],[15,-48],[54,-71],[48,-38],[-31,-63],[-31,15],[-52,66],[-22,4],[-70,97],[-9,57],[-38,26],[-43,-39]],[[5713,7161],[10,-88],[-78,57],[4,30],[64,1]],[[5536,7320],[32,-23],[-4,-77],[-37,0],[9,100]],[[5530,8134],[-13,91],[14,33],[50,-13],[-10,-110]],[[5058,8144],[56,-34],[-16,-39]],[[5189,8044],[-15,70],[-58,40],[-16,85],[33,107],[59,0],[-31,-62],[62,7],[-4,-102],[28,-75],[20,-9],[27,-89],[35,-11],[-33,-114],[-39,1],[-83,-32],[-49,102],[21,87],[43,-5]],[[4854,8799],[27,-77],[-38,-44],[-110,-50],[-121,27],[-35,53],[9,80],[45,8],[45,-39],[82,15],[48,31],[48,-4]],[[6705,7373],[30,-72],[-21,-130]],[[6599,7340],[49,-3],[-7,39]],[[6499,7357],[-3,64],[-44,46]],[[8876,5531],[10,52],[34,21],[-3,-56],[-29,-72],[-12,55]],[[8987,5440],[5,-70],[-35,-24],[1,-69],[-34,33],[-27,73],[-41,-13],[12,49],[34,38],[11,-27],[27,42],[43,19],[4,-51]],[[8869,6008],[5,-65],[-8,-48],[-17,-20],[2,-92],[28,0],[37,-32],[-3,-31],[-35,-3],[-18,34],[-27,-8],[-31,77],[9,152],[10,52],[48,-16]],[[8276,5314],[36,-79],[4,-120],[21,-87],[-20,-3],[-63,88],[-20,69],[-15,79],[-3,67]],[[8497,5070],[21,-20],[23,11],[6,49],[48,23],[35,83]],[[8630,5216],[34,-13],[3,66]],[[8667,5269],[37,85],[28,-54],[44,-33],[-16,-54],[-22,-20]],[[8630,5216],[37,53]],[[5682,7586],[7,6]],[[6103,8454],[-152,-38],[-46,51],[-7,109],[40,70],[87,75],[-44,52]],[[5778,7766],[55,52]],[[6407,5995],[25,-120],[56,-83],[56,-104]],[[6544,5688],[-22,-9]],[[6522,5679],[-42,92],[-53,36],[-44,-31],[-34,12]],[[9442,7221],[-27,-58],[-6,-135],[-15,-41],[-37,-27],[-52,-4],[-42,-66],[-19,22],[-2,43],[-51,-12],[-34,-28],[-25,-142],[-33,-1],[8,52],[-31,56],[28,18],[15,36],[51,70],[58,17],[32,-12],[31,103],[19,-27],[60,80],[18,71],[-5,65],[13,36],[31,11],[16,-80],[-1,-47]],[[9522,7497],[27,-40],[-43,-16],[-26,-57],[-46,39],[-16,-63],[-33,-1],[-4,57],[15,45],[31,3],[17,125],[35,-60],[43,-32]],[[9163,6890],[45,52],[25,-32],[-16,-35],[-54,15]],[[6838,5917],[-21,-15],[-7,-46],[-76,-51],[-26,-41],[-90,-41],[-18,-35],[-44,-3],[-8,34],[-15,144],[2,37]],[[6535,5900],[18,71],[53,-9],[53,-28],[34,71],[28,26],[84,22]],[[6700,6606],[12,-50],[39,-58],[-1,-43],[20,-69]],[[6787,6379],[6,-23]],[[6535,5900],[-15,65],[-15,21],[-24,95],[-34,49],[-19,56],[-2,74],[-17,64],[-29,35],[-17,76],[-52,142],[-6,75]],[[6240,6987],[37,-5]],[[6277,6982],[-37,5]],[[6277,6982],[-37,5]],[[4781,6193],[22,73],[8,60],[26,46],[19,101],[20,21],[34,82],[27,6],[62,104],[-7,72],[15,80],[19,39],[51,50],[29,96],[39,-25],[71,-9]],[[6013,6227],[0,213],[0,205],[-8,47],[13,88]],[[6018,6780],[39,1],[71,-41],[35,35],[26,5],[59,-31],[37,11]],[[6304,6661],[-29,-108],[5,-87],[47,-128],[-5,-48],[39,-63]],[[5617,6871],[71,-25],[39,-25],[14,-52],[68,-35],[31,-29],[28,42],[-7,44],[31,55],[60,-4],[10,-26],[49,-17],[7,-19]],[[6315,5272],[-30,77],[-28,88],[20,19]],[[6522,5679],[-20,-52],[3,-34],[30,-7]],[[6535,5586],[-7,-21],[33,-80],[96,-69],[25,1]],[[6544,5688],[2,-71]],[[6546,5617],[-11,-31]],[[6546,5617],[28,-59],[74,21],[68,35]],[[6172,4888],[-24,-12]],[[6184,5157],[75,16],[18,27]],[[5838,7549],[17,-47],[-11,-30]],[[5844,7472],[-20,-51]],[[5884,7376],[29,22]],[[5913,7398],[23,4]],[[5913,7398],[-39,33]],[[5874,7431],[-30,41]],[[5848,7377],[-27,35]],[[5874,7431],[-5,-13]],[[3853,438],[139,-25],[17,-90],[-210,-58],[-40,63],[94,110]],[[3112,830],[54,4],[10,98],[59,15],[37,-99],[-10,-70],[-67,-20],[-91,8],[8,64]],[[0,52],[381,8],[542,-60],[166,60],[-314,51],[21,95],[165,80],[14,43],[-81,33],[-170,17],[-80,60],[31,42],[166,-6],[153,53],[53,55],[267,71],[204,-1],[84,-11],[269,16],[67,30],[187,-85],[79,14],[124,-21],[-18,65],[-55,26],[-16,65],[98,-8],[117,-50],[114,26],[118,9],[204,-49],[104,25],[50,-31],[100,32],[114,23],[49,79],[-36,89],[31,113],[-9,48],[49,64],[90,91],[26,-89],[-48,-18],[-52,-63],[22,-63],[46,-32],[50,-108],[24,-120],[-38,-74],[-70,-47],[-159,-56],[-24,-24],[-195,-4],[105,-69],[-125,-28],[-3,-46],[78,-62],[356,-87],[183,-64],[212,65],[204,-20],[60,42],[359,59],[-34,62],[-174,-11],[-4,65],[202,96],[224,44],[162,82],[8,78],[63,25],[88,84],[84,-25],[165,31],[79,-8],[183,61],[70,13],[38,-47],[77,50],[171,4],[129,-36],[101,3],[166,63],[33,51],[140,-74],[40,39],[190,87],[179,90],[110,4],[70,-76],[107,-42],[49,35],[142,-30],[19,-101],[-51,-36],[33,-45],[-29,-45],[90,-14],[84,128],[111,24],[43,66],[107,65],[138,19],[92,-21],[129,4],[138,-5],[91,98],[99,-79],[119,13],[98,48],[59,-48],[87,-27],[68,-1],[42,36],[190,-11],[58,19],[150,23],[46,-54],[165,9],[71,-6],[34,-57],[171,-57],[53,18],[246,-125],[168,-14],[82,-42],[-56,-113],[-94,-42],[-54,-63],[-22,-93],[103,-97],[-154,-24],[-58,-103],[79,-65],[396,-121],[118,-32],[-10560,0]]],&quot;transform&quot;:{&quot;scale&quot;:[0.034090909090909095,0.017282150790172434],&quot;translate&quot;:[-180,-85.60903777459771]},&quot;objects&quot;:{&quot;countries&quot;:{&quot;type&quot;:&quot;GeometryCollection&quot;,&quot;geometries&quot;:[{&quot;type&quot;:null,&quot;id&quot;:&quot;FJ&quot;},{&quot;arcs&quot;:[[0,1,2,3,4,5,6,7,8]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TZ&quot;},{&quot;arcs&quot;:[[9,10,11,12]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;EH&quot;},{&quot;arcs&quot;:[[[13,14,15,16]],[[17]],[[18]],[[19]],[[20]],[[21]],[[22]],[[23]],[[24]],[[25]],[[26]],[[27]],[[28]],[[29]],[[30]],[[31]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;CA&quot;},{&quot;arcs&quot;:[[[-17,32,33,34]],[[35]],[[-15,36]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;US&quot;},{&quot;arcs&quot;:[[37,38,39,40,41,42]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;KZ&quot;},{&quot;arcs&quot;:[[-40,43,44,45,46]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;UZ&quot;},{&quot;arcs&quot;:[[[47,48]],[[49]],[[50]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;PG&quot;},{&quot;arcs&quot;:[[[-49,51]],[[52,53]],[[54,55]],[[56]],[[57]],[[58]],[[59]],[[60]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;ID&quot;},{&quot;arcs&quot;:[[[61,62]],[[63,64,65,66,67,68]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;AR&quot;},{&quot;arcs&quot;:[[[-63,69]],[[70,-66,71,72]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;CL&quot;},{&quot;arcs&quot;:[[-6,73,74,75,76,77,78,79,80,81,82]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CD&quot;},{&quot;arcs&quot;:[[83,84,85,86]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SO&quot;},{&quot;arcs&quot;:[[-1,87,88,89,-84,90]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;KE&quot;},{&quot;arcs&quot;:[[91,92,93,94,95,96,97,98]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SD&quot;},{&quot;arcs&quot;:[[-93,99,100,101,102]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TD&quot;},{&quot;arcs&quot;:[[103,104]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;HT&quot;},{&quot;arcs&quot;:[[-104,105]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;DO&quot;},{&quot;arcs&quot;:[[[106]],[[107]],[[108]],[[109,110,111]],[[112]],[[113]],[[114,115,116,117,-43,118,119,120,121,122,123,124,125,126,127,128,129]],[[130,131]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;RU&quot;},{&quot;type&quot;:null,&quot;id&quot;:&quot;BS&quot;},{&quot;arcs&quot;:[[132]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;FK&quot;},{&quot;arcs&quot;:[[[133]],[[-129,134,135,136]],[[137]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;NO&quot;},{&quot;arcs&quot;:[[138]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GL&quot;},{&quot;arcs&quot;:[[139]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TF&quot;},{&quot;arcs&quot;:[[140,-53]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TL&quot;},{&quot;arcs&quot;:[[141,142,143,144,145,146,147],[148]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ZA&quot;},{&quot;arcs&quot;:[[-149]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LS&quot;},{&quot;arcs&quot;:[[-34,149,150,151,152]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MX&quot;},{&quot;arcs&quot;:[[153,154,-64]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;UY&quot;},{&quot;arcs&quot;:[[-154,-69,155,156,157,158,159,160,161,162,163]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BR&quot;},{&quot;arcs&quot;:[[-157,164,-67,-71,165]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BO&quot;},{&quot;arcs&quot;:[[-158,-166,-73,166,167,168]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;PE&quot;},{&quot;arcs&quot;:[[-159,-169,169,170,171,172,173]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CO&quot;},{&quot;arcs&quot;:[[-172,174,175,176]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;PA&quot;},{&quot;arcs&quot;:[[-176,177,178,179]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CR&quot;},{&quot;arcs&quot;:[[-179,180,181,182]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;NI&quot;},{&quot;arcs&quot;:[[-182,183,184,185,186]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;HN&quot;},{&quot;arcs&quot;:[[-185,187,188]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SV&quot;},{&quot;arcs&quot;:[[-152,189,190,-186,-189,191]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GT&quot;},{&quot;arcs&quot;:[[-151,192,-190]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BZ&quot;},{&quot;arcs&quot;:[[-160,-174,193,194]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;VE&quot;},{&quot;arcs&quot;:[[-161,-195,195,196]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GY&quot;},{&quot;arcs&quot;:[[-162,-197,197,198]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SR&quot;},{&quot;arcs&quot;:[[[-163,-199,199]],[[200,201,202,203,204,205,206,207]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;FR&quot;},{&quot;arcs&quot;:[[-168,208,-170]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;EC&quot;},{&quot;type&quot;:null,&quot;id&quot;:&quot;PR&quot;},{&quot;type&quot;:null,&quot;id&quot;:&quot;JM&quot;},{&quot;arcs&quot;:[[209]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CU&quot;},{&quot;arcs&quot;:[[-144,210,211,212]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ZW&quot;},{&quot;arcs&quot;:[[-143,213,214,-211]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BW&quot;},{&quot;arcs&quot;:[[-142,215,216,217,-214]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;NA&quot;},{&quot;arcs&quot;:[[218,219,220,221,222,223,224]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SN&quot;},{&quot;arcs&quot;:[[-221,225,226,227,228,229,230]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ML&quot;},{&quot;arcs&quot;:[[-11,231,-226,-220,232]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MR&quot;},{&quot;arcs&quot;:[[233,234,235,236,237]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BJ&quot;},{&quot;arcs&quot;:[[-102,238,239,-237,240,-228,241,242]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;NE&quot;},{&quot;arcs&quot;:[[-238,-240,243,244]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;NG&quot;},{&quot;arcs&quot;:[[-101,245,246,247,248,249,-244,-239]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CM&quot;},{&quot;arcs&quot;:[[-235,250,251,252]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TG&quot;},{&quot;arcs&quot;:[[-252,253,254,255]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GH&quot;},{&quot;arcs&quot;:[[-230,256,-255,257,258,259]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CI&quot;},{&quot;arcs&quot;:[[-222,-231,-260,260,261,262,263]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GN&quot;},{&quot;arcs&quot;:[[-223,-264,264]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GW&quot;},{&quot;arcs&quot;:[[-259,265,266,-261]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LR&quot;},{&quot;arcs&quot;:[[-262,-267,267]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SL&quot;},{&quot;arcs&quot;:[[-229,-241,-236,-253,-256,-257]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BF&quot;},{&quot;arcs&quot;:[[-79,268,-246,-100,-92,269]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CF&quot;},{&quot;arcs&quot;:[[-78,270,271,272,-247,-269]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CG&quot;},{&quot;arcs&quot;:[[-248,-273,273,274]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GA&quot;},{&quot;arcs&quot;:[[-249,-275,275]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GQ&quot;},{&quot;arcs&quot;:[[-5,276,277,-212,-215,-218,278,-74]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ZM&quot;},{&quot;arcs&quot;:[[-4,279,-277]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MW&quot;},{&quot;arcs&quot;:[[-3,280,-147,281,-145,-213,-278,-280]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MZ&quot;},{&quot;arcs&quot;:[[-146,-282]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SZ&quot;},{&quot;arcs&quot;:[[[-77,282,-271]],[[-75,-279,-217,283]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;AO&quot;},{&quot;arcs&quot;:[[-7,-83,284]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BI&quot;},{&quot;arcs&quot;:[[285,286,287,288,289,290,291]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;IL&quot;},{&quot;arcs&quot;:[[-291,292,293]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LB&quot;},{&quot;arcs&quot;:[[294]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MG&quot;},{&quot;arcs&quot;:[[-287,295]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;PS&quot;},{&quot;arcs&quot;:[[-225,296]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GM&quot;},{&quot;arcs&quot;:[[297,298,299]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TN&quot;},{&quot;arcs&quot;:[[-10,300,301,-298,302,-242,-227,-232]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;DZ&quot;},{&quot;arcs&quot;:[[-286,303,304,305,306,-288,-296]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;JO&quot;},{&quot;arcs&quot;:[[307,308,309,310,311]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;AE&quot;},{&quot;arcs&quot;:[[312,313]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;QA&quot;},{&quot;arcs&quot;:[[314,315,316]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;KW&quot;},{&quot;arcs&quot;:[[-305,317,318,319,320,-317,321]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;IQ&quot;},{&quot;arcs&quot;:[[-311,322,323,324]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;OM&quot;},{&quot;type&quot;:null,&quot;id&quot;:&quot;VU&quot;},{&quot;arcs&quot;:[[326,327,328,329]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;KH&quot;},{&quot;arcs&quot;:[[-327,330,331,332,333,334]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TH&quot;},{&quot;arcs&quot;:[[-328,-335,335,336,337]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LA&quot;},{&quot;arcs&quot;:[[-334,338,339,340,341,-336]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MM&quot;},{&quot;arcs&quot;:[[-329,-338,342,343]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;VN&quot;},{&quot;arcs&quot;:[[-115,344,345,346,347]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;KP&quot;},{&quot;arcs&quot;:[[-346,348]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;KR&quot;},{&quot;arcs&quot;:[[-117,349]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MN&quot;},{&quot;arcs&quot;:[[-341,350,351,352,353,354,355,356,357]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;IN&quot;},{&quot;arcs&quot;:[[-340,358,-351]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BD&quot;},{&quot;arcs&quot;:[[-357,359]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BT&quot;},{&quot;arcs&quot;:[[-355,360]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;NP&quot;},{&quot;arcs&quot;:[[-353,361,362,363,364]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;PK&quot;},{&quot;arcs&quot;:[[-46,365,366,-364,367,368]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;AF&quot;},{&quot;arcs&quot;:[[-45,369,370,-366]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TJ&quot;},{&quot;arcs&quot;:[[-39,371,-370,-44]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;KG&quot;},{&quot;arcs&quot;:[[-41,-47,-369,372,373]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TM&quot;},{&quot;arcs&quot;:[[-320,374,375,376,377,378,-373,-368,-363,379]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;IR&quot;},{&quot;arcs&quot;:[[-292,-294,380,381,-318,-304]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SY&quot;},{&quot;arcs&quot;:[[-377,382,383,384,385]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;AM&quot;},{&quot;arcs&quot;:[[-136,386,387]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SE&quot;},{&quot;arcs&quot;:[[-124,388,389,390,391]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BY&quot;},{&quot;arcs&quot;:[[-123,392,-131,393,394,395,396,397,398,399,-389]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;UA&quot;},{&quot;arcs&quot;:[[-390,-400,400,401,402,403,-110,404]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;PL&quot;},{&quot;arcs&quot;:[[405,406,407,408,409,410,411]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;AT&quot;},{&quot;arcs&quot;:[[-398,412,413,414,415,-406,416]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;HU&quot;},{&quot;arcs&quot;:[[-396,417]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MD&quot;},{&quot;arcs&quot;:[[-395,418,419,420,-413,-397,-418]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;RO&quot;},{&quot;arcs&quot;:[[-391,-405,-112,421,422]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LT&quot;},{&quot;arcs&quot;:[[-125,-392,-423,423,424]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LV&quot;},{&quot;arcs&quot;:[[-126,-425,425]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;EE&quot;},{&quot;arcs&quot;:[[-403,426,-410,427,-201,428,429,430,431,432,433]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;DE&quot;},{&quot;arcs&quot;:[[-420,434,435,436,437,438]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BG&quot;},{&quot;arcs&quot;:[[-437,439,440,441,442]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GR&quot;},{&quot;arcs&quot;:[[[-319,-382,443,444,-384,-375]],[[-436,445,-440]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;TR&quot;},{&quot;arcs&quot;:[[-442,446,447,448,449]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;AL&quot;},{&quot;arcs&quot;:[[-415,450,451,452,453,454]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;HR&quot;},{&quot;arcs&quot;:[[-409,455,-202,-428]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CH&quot;},{&quot;arcs&quot;:[[-429,-208,456]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LU&quot;},{&quot;arcs&quot;:[[-430,-457,-207,457,458]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BE&quot;},{&quot;arcs&quot;:[[-431,-459,459]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;NL&quot;},{&quot;arcs&quot;:[[460,461]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;PT&quot;},{&quot;arcs&quot;:[[-461,462,-205,463]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ES&quot;},{&quot;arcs&quot;:[[464,465]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;IE&quot;},{&quot;arcs&quot;:[[466]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;NC&quot;},{&quot;type&quot;:null,&quot;id&quot;:&quot;SB&quot;},{&quot;arcs&quot;:[[[467]],[[468]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;NZ&quot;},{&quot;arcs&quot;:[[[469]],[[470]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;AU&quot;},{&quot;arcs&quot;:[[471]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LK&quot;},{&quot;arcs&quot;:[[[472]],[[-38,-118,-350,-116,-348,473,-343,-337,-342,-358,-360,-356,-361,-354,-365,-367,-371,-372]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;CN&quot;},{&quot;arcs&quot;:[[474]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;TW&quot;},{&quot;arcs&quot;:[[[-408,475,476,-203,-456]],[[477]],[[478]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;IT&quot;},{&quot;arcs&quot;:[[-433,479]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;DK&quot;},{&quot;arcs&quot;:[[[-466,480]],[[481]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;GB&quot;},{&quot;arcs&quot;:[[482]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;IS&quot;},{&quot;arcs&quot;:[[[-120,483,-378,-386,484]],[[-376,-383]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;AZ&quot;},{&quot;arcs&quot;:[[-121,-485,-385,-445,485]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;GE&quot;},{&quot;arcs&quot;:[[[486]],[[487]],[[488]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;PH&quot;},{&quot;arcs&quot;:[[[-332,489]],[[-56,490,491,492]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;MY&quot;},{&quot;arcs&quot;:[[-492,493]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BN&quot;},{&quot;arcs&quot;:[[-407,-416,-455,494,-476]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SI&quot;},{&quot;arcs&quot;:[[-128,495,-387,-135]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;FI&quot;},{&quot;arcs&quot;:[[-399,-417,-412,496,-401]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SK&quot;},{&quot;arcs&quot;:[[-402,-497,-411,-427]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CZ&quot;},{&quot;arcs&quot;:[[-97,497,498,499]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ER&quot;},{&quot;arcs&quot;:[[[500]],[[501]],[[502]]],&quot;type&quot;:&quot;MultiPolygon&quot;,&quot;id&quot;:&quot;JP&quot;},{&quot;arcs&quot;:[[-156,-68,-165]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;PY&quot;},{&quot;arcs&quot;:[[-324,503,504]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;YE&quot;},{&quot;arcs&quot;:[[-306,-322,-316,505,-314,506,-312,-325,-505,507]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SA&quot;},{&quot;arcs&quot;:[[508,509]],&quot;type&quot;:&quot;Polygon&quot;},{&quot;arcs&quot;:[[-510,510]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;CY&quot;},{&quot;arcs&quot;:[[-301,-13,511]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MA&quot;},{&quot;arcs&quot;:[[-95,512,513,-289,514]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;EG&quot;},{&quot;arcs&quot;:[[-94,-103,-243,-303,-300,515,-513]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;LY&quot;},{&quot;arcs&quot;:[[-85,-90,516,-98,-500,517,518]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ET&quot;},{&quot;arcs&quot;:[[-499,519,520,-518]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;DJ&quot;},{&quot;arcs&quot;:[[-86,-519,-521,521]],&quot;type&quot;:&quot;Polygon&quot;},{&quot;arcs&quot;:[[-9,522,-81,523,-88]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;UG&quot;},{&quot;arcs&quot;:[[-8,-285,-82,-523]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;RW&quot;},{&quot;arcs&quot;:[[-452,524,525]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;BA&quot;},{&quot;arcs&quot;:[[-438,-443,-450,526,527]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;MK&quot;},{&quot;arcs&quot;:[[-414,-421,-439,-528,528,529,-525,-451]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;RS&quot;},{&quot;arcs&quot;:[[-448,530,-453,-526,-530,531]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;ME&quot;},{&quot;arcs&quot;:[[-449,-532,-529,-527]],&quot;type&quot;:&quot;Polygon&quot;},{&quot;type&quot;:null,&quot;id&quot;:&quot;TT&quot;},{&quot;arcs&quot;:[[-80,-270,-99,-517,-89,-524]],&quot;type&quot;:&quot;Polygon&quot;,&quot;id&quot;:&quot;SS&quot;}]},&quot;land&quot;:{&quot;type&quot;:&quot;GeometryCollection&quot;,&quot;geometries&quot;:[{&quot;arcs&quot;:[[[1,280,147,215,283,75,282,271,273,275,249,244,233,250,253,257,265,267,262,264,223,296,218,232,11,511,301,298,515,513,289,292,380,443,485,121,392,131,393,418,434,445,440,446,530,453,494,476,203,463,461,462,205,457,459,431,479,433,403,110,421,423,425,126,495,387,136,129,344,348,346,473,343,329,330,489,332,338,358,351,361,379,320,314,505,312,506,307,325,309,322,503,507,306,514,95,497,519,521,86,90],[378,373,41,118,483]],[[15,32,149,192,190,186,182,179,176,172,193,195,197,199,163,154,64,71,166,208,170,174,177,180,183,187,191,152,34,13,36]],[[17]],[[18]],[[19]],[[20]],[[21]],[[22]],[[23]],[[24]],[[25]],[[26]],[[27]],[[28]],[[29]],[[30]],[[31]],[[35]],[[47,51]],[[49]],[[50]],[[53,140]],[[492,54,490,493]],[[56]],[[57]],[[58]],[[59]],[[60]],[[61,69]],[[104,105]],[[106]],[[107]],[[108]],[[112]],[[113]],[[132]],[[133]],[[137]],[[138]],[[139]],[[209]],[[294]],[[464,480]],[[466]],[[467]],[[468]],[[469]],[[470]],[[471]],[[472]],[[474]],[[477]],[[478]],[[481]],[[482]],[[486]],[[487]],[[488]],[[500]],[[501]],[[502]],[[532]],[[533]],[[534]]],&quot;type&quot;:&quot;MultiPolygon&quot;}]}}}">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas width="1165" height="372" style="display: block; height: 248px; width: 777px;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart pie order-servicepayment col-xl-6" data-title="Payment">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-servicepayment-data" aria-expanded="true" aria-controls="order-servicepayment-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Payment types</h2>
                </div>
                <div id="order-servicepayment-data" class="collapse show">
                    <div class="row">
                        <div class="content col-md-7">
                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas width="543" height="346" style="display: block; height: 231px; width: 362px;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <div class="content col-md-5">
                            <div class="chart-legend">
                                <div class="legend">
                                    <div class="item" data-index="0"><span class="color" style="background-color: rgb(48, 160, 224);"></span><span class="label">demo-cashondelivery</span></div>
                                    <div class="item" data-index="1"><span class="color" style="background-color: rgb(0, 176, 160);"></span><span class="label">demo-invoice</span></div>
                                    <div class="item" data-index="2"><span class="color" style="background-color: rgb(255, 127, 14);"></span><span class="label">demo-prepay</span></div>
                                    <div class="item" data-index="3"><span class="color" style="background-color: rgb(224, 48, 40);"></span><span class="label">demo-sepa</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart pie order-servicedelivery col-xl-6" data-title="Delivery">
            <div class="box">
                <div class="header" data-bs-toggle="collapse" data-bs-target="#order-servicedelivery-data" aria-expanded="true" aria-controls="order-servicedelivery-data">
                    <div class="card-tools-start">
                        <div class="btn act-show fa"></div>
                    </div>
                    <h2 class="header-label">
                        Delivery types</h2>
                </div>
                <div id="order-servicedelivery-data" class="collapse show">
                    <div class="row">
                        <div class="content col-md-7">
                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas width="543" height="346" style="display: block; height: 231px; width: 362px;" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                        <div class="content col-md-5">
                            <div class="chart-legend">
                                <div class="legend">
                                    <div class="item" data-index="0"><span class="color" style="background-color: rgb(48, 160, 224);"></span><span class="label">demo-dhl</span></div>
                                    <div class="item" data-index="1"><span class="color" style="background-color: rgb(0, 176, 160);"></span><span class="label">demo-dhlexpress</span></div>
                                    <div class="item" data-index="2"><span class="color" style="background-color: rgb(255, 127, 14);"></span><span class="label">demo-fedex</span></div>
                                    <div class="item" data-index="3"><span class="color" style="background-color: rgb(224, 48, 40);"></span><span class="label">demo-pickup</span></div>
                                    <div class="item" data-index="4"><span class="color" style="background-color: rgb(0, 200, 240);"></span><span class="label">demo-tnt</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/combine/npm/moment@2,npm/chart.js@2,npm/chartjs-chart-matrix@0.1.3,npm/chartjs-chart-geo@2,npm/chartjs-plugin-doughnutlabel@2/dist/chartjs-plugin-doughnutlabel.min.js"></script>
    </div>
@endsection
