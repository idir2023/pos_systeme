{{-- <div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button"  class="close close_modal_2" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title product_name" id="myModalLabel"></h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="form-group col-xs-12 @if(!auth()->user()->can('edit_product_price_from_sale_screen')) hide @endif">
					@php
						$pos_unit_price = !empty($product->unit_price_before_discount) ? $product->unit_price_before_discount : $product->default_sell_price;
					@endphp
					<label>@lang('sale.unit_price')</label>
						<input type="text" name="products[{{$row_count}}][unit_price]" class="form-control pos_unit_price input_number mousetrap" value="{{@num_format($pos_unit_price)}}" @if(!empty($pos_settings['enable_msp'])) data-rule-min-value="{{$pos_unit_price}}" data-msg-min-value="{{__('lang_v1.minimum_selling_price_error_msg', ['price' => @num_format($pos_unit_price)])}}" @endif>
				</div>
			
				<div class="form-group col-xs-12 col-sm-6 ">
					<label>@lang('sale.discount_type')</label>
						{!! Form::select("products[$row_count][line_discount_type]", ['fixed' => __('lang_v1.fixed'), 'percentage' => __('lang_v1.percentage')], $discount_type , ['class' => 'form-control row_discount_type']); !!}
				</div>

				<div class="form-group col-xs-12 col-sm-6 ">
					<label>@lang('sale.discount_amount')</label>
						{!! Form::text("products[$row_count][line_discount_amount]", @num_format($discount_amount), ['class' => 'form-control input_number row_discount_amount']); !!}
				</div>

                <div class="form-group col-xs-12" >
                    <label>@lang('sale.qty')</label>
                    <input type="text" data-min="1" 
                    class="form-control pos_quantity input_number mousetrap input_quantity" 
                    value="{{@format_quantity($product->quantity_ordered)}}" name="products[{{$row_count}}][quantity]" 
                >
                </div>

				<div class="form-group col-xs-12">
		      		<label>@lang('lang_v1.description')</label>
		      		<textarea class="form-control" name="products[{{$row_count}}][sell_line_note]" rows="3">{{$sell_line_note}}</textarea>
		      		<p class="help-block">@lang('lang_v1.sell_line_description_help')</p>
		      	</div>

                <div class="form-group col-xs-12">
					<label class="text text-danger">@lang('sale.subtotal') : </label>
                    @php
                        $subtotal_type = !empty($pos_settings['is_pos_subtotal_editable']) ? 'text' : 'hidden';           
                    @endphp
                    <span class="display_currency pos_line_total_text @if(!empty($pos_settings['is_pos_subtotal_editable'])) hide @endif" data-currency_symbol="true">{{$product->quantity_ordered*$unit_price_inc_tax}}</span>
                </div> 

			</div>
		</div>
		<div class="modal-footer">
			<button type="button" id="close_modal" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
		</div>
	</div>
</div> --}}