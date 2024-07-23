@extends('layouts.app')
@section('title',__('messages.Management_customer_checks'))


@section('content')
    <section class="content-header">
        <h1>@lang('messages.Management_customer_checks')</h1>
        <br>
    </section>
    <section class="content no-print">
        <div class="row">
            <div class="col-md-12">
                @component('components.widget')
                <div class="row">
                    <div class="col-md-3" id="totalEnCours"></div>
                    <div class="text text-warning col-md-3" id="totalDepose"></div>
                    <div class="text text-success col-md-3" id="totalEncaisse"></div>
                    <div class="text text-danger col-md-3" id="totalImpaye"></div>
                </div>
                @endcomponent
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @component('components.filters', ['title' => __('report.filters')])
                    {!! Form::open(['url' => '#', 'method' => 'get', 'id' => 'cheque_client_management_form']) !!}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('customer_id', 'Customer:') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    {!! Form::select('customer_id', $customers, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('messages.all'),
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('location_id', __('purchase.business_location') . ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    {!! Form::select('location_id', $business_locations, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('messages.all'),
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('cheque_statut', __('messages.cheque_status'). ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-money-bill-alt"></i>
                                    </span>
                                    {!! Form::select(
                                        'cheque_statut',
                                        ['En cours' => 'En cours', 'Déposé' => 'Déposé', 'Encaissé' => 'Encaissé', 'Impayé' => 'Impayé'],
                                        null,
                                        [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('messages.all'),
                                            'required' => 'required',
                                        ],
                                    ) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('cheque_type', __('messages.cheque_type')) !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                              <i class="fas fa-money-check"></i>
                                    </span>
                                    {!! Form::select(
                                        'cheque_type',
                                        ['Cheque' => 'Cheque', 'Effet' => 'Effet'],
                                        null,
                                        [
                                            'class' => 'form-control select2',
                                            'placeholder' => __('messages.all'),  
                                            'id'=>'cheque_type',
                                        ]
                                    ) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('CustomerGroup_id', __('lang_v1.customer_groups'). ':') !!}
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fas fa-users"></i>
                                    </span>
                                    {!! Form::select('CustomerGroup_id', $customer_groups, null, [
                                        'class' => 'form-control select2',
                                        'placeholder' => __('messages.all'),
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('spr_date_filterFour', 'Date de Paiement:') !!}
                                {!! Form::text('date_range_payment', null, [
                                    'placeholder' => __('lang_v1.select_a_date_range'),
                                    'class' => 'form-control',
                                    'id' => 'spr_date_filterFour',
                                    'readonly',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('spr_date_filters_echeance_four', __('messages.Cheque_Echeance'). ':') !!}
                                {!! Form::text('date_range_echeance', null, [
                                    'placeholder' => __('lang_v1.select_a_date_range'),
                                    'class' => 'form-control',
                                    'id' => 'spr_date_filters_echeance_four',
                                    'readonly',
                                ]) !!}
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}
                @endcomponent
            </div>
        </div>

        <div class="modal fade edit_payment_modal"  role="dialog" aria-labelledby="gridSystemModalLabel">
        </div>
      
       <div class="modal fade pay_contact_due_modal"  role="dialog" 
        aria-labelledby="gridSystemModalLabel">
       </div>
    
        <div class="row">
            <div class="col-md-12">
                @component('components.widget', ['class' => 'box-primary'])
                
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="cheque_client_report_table">
                            <thead>
                                <tr>
                                    <th>@lang('role.customer')</th>
                                    <th>@lang('messages.Cheque_Echeance')</th>
                                    <th>@lang('lang_v1.cheque_no')</th>
                                    <th>@lang('messages.Factur_Number')</th>
                                    <th>@lang('messages.Payment_Number')</th>
                                    <th>@lang('messages.bank_name')</th>
                                    <th>@lang('messages.cheque_type')</th>
                                    <th>@lang('messages.cheque_owner')</th>
                                    <th>@lang('messages.Amount')</th>
                                    <th>@lang('messages.Number_De_Jour')</th>
                                    <th>@lang('messages.cheque_status')</th>
                                    <th>@lang('messages.action')</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="bg-gray font-17 footer-total text-center">
                                    <td colspan="8"><strong>Total:</strong></td>
                                    <td><span class="display_currency" id="footer_total_gar_amount"
                                        data-currency_symbol="true"></span></td>
                                    <td colspan="3"></td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                @endcomponent
            </div>
        </div>
    </section>

    
    {{--  add   --}}
@endsection
@section('javascript')
<script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script> 
    <script>
        $(document).ready(function() {
            var cheque_payment_table = $('table#cheque_client_report_table').DataTable({
                processing: true,
                serverSide: false,
                aaSorting: [
                    [2, 'desc']
                ],
                ajax: {
                    url: '/cheque_client',
                    data: function(data) {
                        data.customer_id = $('#customer_id').val();
                        data.CustomerGroup_id = $('#CustomerGroup_id').val();
                        data.location_id = $('#location_id').val();
                        data.cheque_status = $('#cheque_statut').val();
                        data.cheque_type = $('#cheque_type').val();
                       
                        var start = '';
                        var end = '';
                        if ($('#spr_date_filterFour').val()) {
                            start = $('#spr_date_filterFour')
                                .data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            end = $('#spr_date_filterFour')
                                .data('daterangepicker')
                                .endDate.format('YYYY-MM-DD');
                        }
                        data.start_date = start;
                        data.end_date = end;
                        var startE = '';
                        var endE = '';
                        if ($('#spr_date_filters_echeance_four').val()) {
                            startE = $('#spr_date_filters_echeance_four')
                                .data('daterangepicker')
                                .startDate.format('YYYY-MM-DD');
                            endE = $('#spr_date_filters_echeance_four')
                                .data('daterangepicker')
                                .endDate.format('YYYY-MM-DD');
                        }
                        data.start_date_echeance = startE;
                        data.end_date_echeance = endE;

                    } 
                },
                columns: [{
                        data: 'customer',
                        name: 'c.name',
                       
                    },
                    {
                        data: 'chequeEcheance',
                        name: 'chequeEcheance',
                       
                    },
                    {
                        data: 'chequeNumber',
                        name: 'chequeNumber',
                       
                    },
                    {
                        data: 'facturNumber',
                        name: 'facturNumber',
                       
                    },
                    {
                        data: 'payment_no',
                        name: 'payment_no',
                        visible: false, // Corrected value to false
                       
                    },
                    {
                        data: 'banque_name',
                        name: 'banque_name',
                        visible: false, // Corrected value to false
                       
                    },
                    {
                        data: 'cheque_type',
                        name: 'cheque_type',
                       
                    },
                    {
                        data: 'cheque_owner',
                        name: 'cheque_owner',
                       
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                       
                       
                    },
                    {
                        data: 'NumberJour',
                        name: 'NumberJour',
                        visible: false, // Corrected value to false
                    
                    },
                    {
                        data: 'chequeStatus',
                        name: 'chequeStatus',
                       
                       
                    },
                    {
                        data: 'action',
                        searchable: false
                    }
                ],
                fnDrawCallback: function(oSettings) {
                    var totalEnCours =sum_table_col($('table#cheque_client_report_table'),'paid-amount1');
                    var totalDepose =sum_table_col($('table#cheque_client_report_table'),'paid-amount2');
                    var totalEncaisse =sum_table_col($('table#cheque_client_report_table'),'paid-amount3');
                    var totalImpaye =sum_table_col($('table#cheque_client_report_table'),'paid-amount4');
                    var total_amount = totalEnCours+totalDepose+totalEncaisse+totalImpaye;
                    $('#footer_total_gar_amount').text(total_amount);
                    $('#totalEnCours').text('Total En cours: ' +totalEnCours+ ' Dh');
                    $('#totalDepose').text('Total Déposé: ' +totalDepose+ ' Dh');
                    $('#totalEncaisse').text('Total Encaissé : ' +totalEncaisse+ ' Dh');
                    $('#totalImpaye').text('Total Impayé: ' +totalImpaye+ ' Dh');
                    __currency_convert_recursively($('#cheque_client_report_table'));
                },
            });

            $('#cheque_client_report_table').on('click', '.delete_payment1', function(e) {
                swal({
                    title: 'Are you sure?',
                    text: 'This payment will be deleted.',
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
                                    cheque_payment_table.ajax.reload();
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

            $('#location_id,#CustomerGroup_id,#customer_id, #cheque_statut ,#cheque_type, #cheque_client_report_table')
                .change(function() {
                    cheque_payment_table.ajax.reload();
                });

            if ($('#spr_date_filterFour').length == 1) {
                $('#spr_date_filterFour').daterangepicker(dateRangeSettings, function(start, end) {
                    $('#spr_date_filterFour span').val(
                        start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                    );
                    cheque_payment_table.ajax.reload();
                });
                $('#spr_date_filterFour').on('apply.daterangepicker', function(ev, picker) {
                    cheque_payment_table.ajax.reload();
                });
                $('#spr_date_filterFour').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    cheque_payment_table.ajax.reload();
                });
            }

            if ($('#spr_date_filters_echeance_four').length == 1) {
                $('#spr_date_filters_echeance_four').daterangepicker(dateRangeSettings, function(start, end) {
                    $('#spr_date_filters_echeance_four span').val(
                        start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format)
                    );
                    cheque_payment_table.ajax.reload();
                });
                $('#spr_date_filters_echeance_four').on('apply.daterangepicker', function(ev, picker) {
                    cheque_payment_table.ajax.reload();
                });
                $('#spr_date_filters_echeance_four').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    cheque_payment_table.ajax.reload();
                });
            }
        });
        
    </script>
@endsection

