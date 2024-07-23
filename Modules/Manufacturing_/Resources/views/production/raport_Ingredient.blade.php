@extends('layouts.app')
@section('title', __('manufacturing::lang.production'))

@section('content')
@include('manufacturing::layouts.nav')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Rapport d'ingrédients</h1>
</section>

<!-- Main content -->
<section class="content">
    @component('components.filters', ['title' => __('report.filters')])
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('productstion_list_filter_location_id', __('purchase.business_location') . ':') !!}
            {!! Form::select('productstion_list_filter_location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all') ]); !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('production_list_filter_date_range', __('report.date_range') . ':') !!}
            {!! Form::text('production_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('category_id', __('product.category') . ':') !!}
            {!! Form::select('category_id', $categories, null, ['class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'product_list_filter_category_id', 'placeholder' => __('lang_v1.all')]); !!}
        </div>
    </div>

    @endcomponent
    @component('components.widget', ['class' => 'box-solid'])
    <div class="table-responsive">
        <table class="table" id='table_ingredient'>
            <thead>
                <tr>
                    <th>@lang('manufacturing::lang.ingredient')</th>
                    <th>Quantité consommée</th>
                    <th>@lang('manufacturing::lang.sale_quantity')</th>
                    <th>@lang('manufacturing::lang.total_price')</th>
                    <th>Stock actuel</th>
                    <th>@lang('manufacturing::lang.usage_details')</th>
                    <th>Details de vente</th>


                </tr>
            </thead>

        </table>
    </div>
    @endcomponent
</section>
<!-- /.content -->
@endsection

@section('javascript')
<script>
$(document).ready(function() {
    var table_ingredient = $('#table_ingredient').DataTable({
        processing: true,
        serverSide: true,
        aaSorting: [[0, 'desc']],
        pageLength: 10, 
        lengthMenu: [10, 25, 50, 100],
        ajax: {
            "url": '{{ action([\Modules\Manufacturing\Http\Controllers\ProductionController::class, 'getRaportIngredient']) }}',
            "data": function(d) {
                if ($('#production_list_filter_date_range').val()) {
                    d.start_date = $('#production_list_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.end_date = $('#production_list_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
                d.location_id = $('#production_list_filter_location_id').val();
                d.category_id = $('#product_list_filter_category_id').val();
                d = __datatable_ajax_callback(d);
            }
        },
        columnDefs: [
            {
                targets: [4], 
                orderable: true,
                searchable: true,
            },
        ],
        
        columns: [
            { data: 'product_name', name: 'product_name' },
            { data: 'total_quantity',  searchable: false },
            { data: 'sale_quantity',  searchable: false },
            { data: 'final_total', name: 'final_total' },
            { data: 'current_stock', name: 'current_stock' },
            { data: 'ref_no', name: 'ref_no' },
            { data: 'sale_Details', name: 'sale_Details' },

        ],
        fnDrawCallback: function(oSettings) {
	            __currency_convert_recursively($('#table_ingredient'));
	        }
    });

    $('#production_list_filter_date_range').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#production_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            table_ingredient.ajax.reload();
        }
    );

    $('#production_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#production_list_filter_date_range').val('');
        table_ingredient.ajax.reload();
    });

    // Listen for changes in filter inputs and fetch data
    $('#productstion_list_filter_location_id, #product_list_filter_category_id, #production_list_filter_date_range').change(function() {
        table_ingredient.ajax.reload();
    });
});

</script>
@endsection

