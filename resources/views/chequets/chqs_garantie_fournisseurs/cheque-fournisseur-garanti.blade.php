@extends('layouts.app')
@section('title',__('lang_v1.supplier_cheques'))

@section('content')
    <section class="content-header">
        <h1> @lang('lang_v1.supplier_cheques')</h1>
        <br>
    </section>
    <section class="content no-print">
        <a class="btn btn-primary btn-sm pull-right" style="margin: 20px;" data-toggle="modal"
        href="{{ action([\App\Http\Controllers\ChqsFournisseurController::class, 'create']) }}">
        <i class="fa fa-plus"></i> @lang('messages.add')</a>
        </a>  
        <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    {!! Form::open(['url' => '#', 'method' => 'get', 'id' => 'cheque_fournisseur_management_form']) !!}
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('customer_id', __('purchase.supplier') ) !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                {!! Form::select('customer_id', $suppleirs, null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('messages.all'),
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('cheque_statut', 'Statut de cheque.:') !!}
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fas fa-money-bill-alt"></i>
                                </span>
                                {!! Form::select('cheque_statut', ['Activate' => 'Activate', 'Desactivate' => 'Desactivate'], null, [
                                    'class' => 'form-control select2',
                                    'placeholder' => __('messages.all'),
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">

                            {!! Form::label('spr_date_filterFour', 'Date de Paiment:') !!}
                            {!! Form::text('date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'id' => 'spr_date_filterFour',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('spr_date_filters_echeance_four', 'Date échéance:') !!}
                            {!! Form::text('date_range', null, [
                                'placeholder' => __('lang_v1.select_a_date_range'),
                                'class' => 'form-control',
                                'id' => 'spr_date_filters_echeance_four',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                @endcomponent
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @component('components.widget', ['class' => 'box-primary'])
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="chequeGarantie_payment_report_table">
                            <thead>
                                <tr>
                                    <th>@lang('purchase.supplier') </th>
                                    <th>@lang('lang_v1.cheque_no')</th>
                                    <th>@lang('messages.Amount')</th>
                                    <th>@lang('messages.Cheque_Echeance')</th>
                                    <th>@lang('lang_v1.payment_date')</th>
                                    <th>@lang('messages.cheque_status')</th>
                                    <th>@lang('messages.action')</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="bg-gray font-17 footer-total text-center">
                                    <td></td>
                                    <td><strong>@lang('report.total')</strong></td>
                                    <td><span class="display_currency" id="footer_total_gar_amount"
                                            data-currency_symbol="true"></span></td>
                                    <td colspan="4"></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                @endcomponent
            </div>
        </div>
    </section>

@endsection

@section('javascript')

    <script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
    <script>
        $(document).ready(function() {

            chequeGarantiePaymentReport = $('table#chequeGarantie_payment_report_table').DataTable({
                processing: true,
                serverSide: true,
                aaSorting: [
                    [2, 'desc']
                ],
                ajax: {
                    url: '/chqs_fournisseur', // Make sure this URL is correct

                    data: function(data) {
                        data.customer_id = $('select#customer_id').val();
                        data.location_id = $('select#location_id').val();
                        data.cheque_status = $('select#cheque_statut').val();
                        var start = '';
                        var end = '';
                        if ($('input#spr_date_filterFour').val()) {
                            start = $('input#spr_date_filterFour')
                                .data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            end = $('input#spr_date_filterFour')
                                .data('daterangepicker')
                                .endDate.format('YYYY-MM-DD');
                        }
                        data.start_date = start;
                        data.end_date = end;
                        var startE = '';
                        var endE = '';
                        if ($('input#spr_date_filters_echeance_four').val()) {
                            startE = $('input#spr_date_filters_echeance_four')
                                .data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            endE = $('input#spr_date_filters_echeance_four')
                                .data('daterangepicker')
                                .endDate.format('YYYY-MM-DD');
                        }
                        data.start_date_echeance = startE;
                        data.end_date_echeance = endE;
                        // console.log(data); // Consider removing this console.log statement
                    }
                },
                columns: [{
                        data: 'customer',
                        name: 'c.name'
                    },
                    {
                        data: 'chequeNumber',
                        name: 'cheque_number'
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        searchable: false
                    },
                    {
                        data: 'chequeEcheance',
                        name: 'chequeEcheance',
                        searchable: false
                    },
                    {
                        data: 'chequeDateP',
                        name: 'chequeDateP',
                        searchable: false
                    },
                    {
                        data: 'chequeStatus',
                        name: 'chequeStatus',
                        searchable: false
                    },
                    {
                        data: 'action',
                        searchable: false
                    }
                ],
                fnDrawCallback: function(oSettings) {
                    var total_amount = sum_table_col($('table#chequeGarantie_payment_report_table'),
                        'paid-amount');
                    $('#footer_total_gar_amount').text(total_amount);
                    __currency_convert_recursively($('#chequeGarantie_payment_report_table'));
                },
            });
   
            $('#chequeGarantie_payment_report_table').on('click', '.delete-cheque-garant', function(e) {
                swal({
                    title: 'Are you sure?',
                    text: 'This cheque will be deleted.',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: $(this).data('href'),
                            method: 'DELETE',
                            dataType: 'json',
                            success: function(result) {

                                if (result.success === true) {
                                    toastr.success(result.msg);
                                    refreshTable();
                                } else {
                                    toastr.error(result.msg);
                                }
                            },
                            error: function(error) {
                                console.error('Error deleting cheque:', error);
                            }
                        });
                    }
                });
            });
        });

        $('#cheque_fournisseur_management_form #location_id, #cheque_fournisseur_management_form #customer_id, #cheque_fournisseur_management_form #cheque_statut')
            .change(
                function() {
                    chequeGarantiePaymentReport.ajax.reload();
                }
            );
        if ($('#spr_date_filterFour').length == 1) {
            $('#spr_date_filterFour').daterangepicker(dateRangeSettings, function(start, end) {
                $('#spr_date_filterFour span').val(
                    start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                );
                chequeGarantiePaymentReport.ajax.reload();
            });
            $('#spr_date_filterFour').on('cancel.daterangepicker', function(ev, picker) {
                $('#spr_date_filterFour').val('');
                chequeGarantiePaymentReport.ajax.reload();
            });
        }

        if ($('#spr_date_filters_echeance_four').length == 1) {
            $('#spr_date_filters_echeance_four').daterangepicker(dateRangeSettings, function(start, end) {
                $('#spr_date_filters_echeance_four span').val(
                    start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                );
                chequeGarantiePaymentReport.ajax.reload();
            });
            $('#spr_date_filters_echeance_four').on('cancel.daterangepicker', function(ev, picker) {
                $('#spr_date_filters_echeance_four').val('');
                chequeGarantiePaymentReport.ajax.reload();
            });
        }
        $('#add_cheque_garant_btn').on('click', function() {
            $('#amount').val('').attr('placeholder', '67867');
            $('#cheque_number').val('').attr('placeholder', 'Numero de cheque');
            $('#cheque_echeance').val('');
            $('#cheque_status').val(''); // Hide the select input
            $('#cheque_dateP').val('');
        });

        function refreshTable() {
            chequeGarantiePaymentReport.ajax.reload();
        }
    </script>
    @if (session('success'))
        {{ session('success') }}
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif
@endsection
