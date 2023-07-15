@php use Carbon\Carbon; @endphp@extends('layouts.app')

@section('styles')
    <link href="{{ asset('admin/css/select2.min.css') }}" rel="stylesheet"/>
    {{-- <link href="{{ asset('admin/css/jquery.dataTables.min.css') }}" rel="stylesheet" /> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.22/r-2.2.6/datatables.min.css"/>
    <link href="{{ asset('admin/css/fixedHeader.dataTables.min.css') }}" rel="stylesheet"/>
@endsection
@section('scripts')
    <script src="{{ asset('admin/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap-confirmation.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables.fixedHeader.min.js') }}"></script>
    <script>
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            container: 'body',
        });
        $(".select2").select2({language: "bg"});
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                placement: 'auto',
                trigger: 'hover',
                html: true,
            }).on("show.bs.popover", function () {
                $(this).data("bs.popover").tip().css("max-width", "80%");
            });
            // Setup - add a text input to each footer cell
            $('#example thead tr').clone(true).appendTo('#example thead');
            $('#example thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input type="text" class="datatable-filter-input" placeholder="филтрирай по ' + title + '" style="width:100%;" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });

            var table = $('#example').DataTable({
                "order": [[7, "desc"]],
                orderCellsTop: true,
                fixedHeader: true,
                language: {
                    "sProcessing": "Обработка на резултатите...",
                    "sLengthMenu": "Показване на _MENU_ резултата",
                    "sZeroRecords": "Няма намерени резултати",
                    "sInfo": "Показване на резултати от _START_ до _END_ от общо _TOTAL_",
                    "sInfoEmpty": "Показване на резултати от 0 до 0 от общо 0",
                    "sInfoFiltered": "(филтрирани от общо _MAX_ резултата)",
                    "sInfoPostFix": "",
                    "sSearch": "Търсене:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "Първа",
                        "sPrevious": "Предишна",
                        "sNext": "Следваща",
                        "sLast": "Последна"
                    }
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="col-xs-12 p-0">
        <div class="bg-grey top-search-bar">
            <div class="search pull-left hidden-xs">
                <div class="input-group">
                    <input type="text" name="search" class="form-control input-sm search-text" placeholder="Търси" autocomplete="off">
                    <span class="input-group-btn">
					<button class="btn btn-sm submit"><i class="fa fa-search"></i></button>
				</span>
                </div>
            </div>

            <div class="action-mass-buttons" style="width: 50%;float: right;">
                <form action="{{ route('h-18-reports.generate') }}" method="POST" style="display: flex;flex-direction: row;justify-content: flex-end;align-items: center;">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom: 0;display: flex;align-items: center;">
                        <label class="form-label col-md-5" for="">Месец</label>
                        <div class="col-md-7">
                            <select class="form-control input-sm" name="month" id="">
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0;display: flex;align-items: center;">
                        <label class="form-label col-md-5" for="">Година</label>
                        <div class="col-md-7">
                            <input type="number" name="year" class="form-control input-sm" min="1900" max="9999" step="1" value="{{ date('Y') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn green btn-lg">Генерирай</button>
                </form>
            </div>
        </div>
    </div>
    <table id="example" class="table table-striped">
        <thead>
        <tr>
            <th>Месец</th>
            <th>Година</th>
            <th>Дата на генериране</th>
            <th class="text-right">Действия</th>
        </tr>
        </thead>
        <tbody>
        @if(count($reports))
            @foreach($reports as $report)
                <tr class="t-row">
                    <td>{{ $report->month }}</td>
                    <td>{{ $report->year }}</td>
                    <td>{{ Carbon::parse($report->created_at)->format('d.m.Y H:i') }}</td>
                    <td class="text-right">
                        <a href="{{ route('h-18-reports.download', ['id' => $report->id]) }}" class="btn btn-primary" role="button"><i class="fas fa-download"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="no-table-rows">{{ trans('administration_messages.no_recourds_found') }}</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
