@extends('layouts.app')
@section('title', __('manufacturing::lang.production'))

@section('content')
    @include('manufacturing::layouts.nav')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Rapport de Productions</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('productstion_list_filter_location_id',  __('purchase.business_location') . ':') !!}
                    {!! Form::select('productstion_list_filter_location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('production_list_filter_date_range', __('report.date_range') . ':') !!}
                    {!! Form::text('production_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                </div>
            </div>
        
        @endcomponent
        @component('components.widget', ['class' => 'box-solid'])
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="productions_table1">
                    <thead>
                        <tr>
                            <th>@lang('purchase.location')</th>
                            <th>@lang('sale.product')</th>
                            <th>Quantité produite</th>
                            <th>@lang('manufacturing::lang.total_cost')</th>
                            <th>Stock actuel</th>
                            <th>Details d'utilistation</th>

                        </tr>
                    </thead>
                </table>
            </div>
        @endcomponent
    </section>
<!-- /.content -->
<div class="modal fade" id="recipe_modal" tabindex="-1" role="dialog" 
    aria-labelledby="gridSystemModalLabel">
</div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#production_list_filter_date_range').daterangepicker(dateRangeSettings, function(start, end) {
                $('#production_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                productions_table1.ajax.reload();
            });

            $('#production_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
                $('#production_list_filter_date_range').val('');
                productions_table1.ajax.reload();
            });

            // Purchase table
            productions_table1 = $('#productions_table1').DataTable({
                processing: true,
                serverSide: true,
                aaSorting: [[0, 'desc']],
                ajax: {
                    url: '{{action([\Modules\Manufacturing\Http\Controllers\ProductionController::class, 'getRaportProduction'])}}',
                    data: function(d) {
                        if ($('#production_list_filter_date_range').val()) {
                            var start = $('#production_list_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                            var end = $('#production_list_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                            d.start_date = start;
                            d.end_date = end;
                        }
                        d.location_id = $('#productstion_list_filter_location_id').val();
                        if ($('#production_list_is_final').is(':checked')) {
                            d.is_final = 1;
                        }
                        d = __datatable_ajax_callback(d);
                    },
                },
                 columnDefs: [
	            {
	                targets: [5],
	                orderable: false,
	                searchable: false,
	            },
	        ],
	        columns: [
	            { data: 'location_name', name: 'bl.name' },
	            { data: 'product_name', name: 'product_name' },
	            { data: 'total_quantity', searchable: false },
	            { data: 'final_total', name: 'final_total' },
                { data: 'current_stock', name: 'current_stock' },
                { data: 'ref_no', name: 'ref_no' },

	        ],
                fnDrawCallback: function(oSettings) {
                    __currency_convert_recursively($('#productions_table1'));
                }
            });

            $(document).on('change', '#production_list_filter_date_range, #productstion_list_filter_location_id', function() {
                productions_table1.ajax.reload();
            });

            $('#production_list_is_final').on('ifChanged', function(event) {
                productions_table1.ajax.reload();
            });

            if ($('textarea#instructions').length > 0) {
                tinymce.init({
                    selector: 'textarea#instructions',
                });
            }

            if ($('#search_product').length) {
                initialize_search($('#search_product'));
            }

            if ($('.search_product').length) {
                $('.search_product').each(function() {
                    initialize_search($(this));
                });
            }
        });
    </script>
@endsection
