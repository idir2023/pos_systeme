<!-- business information here -->

<style type="text/css">
	 
	/* body {
        margin: 0 
        padding: 0;
        min-height: 10vh;
        position: relative;
    }
	.content {
        padding-bottom: 70px; 
    }
    .footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: #333;
        color: #fff;
        text-align: center;
        height: 100px; 
    }*/
    .page-footer, .page-footer-space {
 	 height:40px;
	}
    .tdStyle td{
     	border: 1px solid #ffffff !important;
	    padding-left: 9px !important;
	    padding-right: 9px !important;
	    background: #f0f0f0a3 !important;
	    height: 35px !important;
	    padding-top: 7px !important;
    }
    .thStyle th{
        background-color: #363636 !important;
	    color: white !important;
	    font-size: 20px !important;
	    text-align: center;
	    border: 1px solid white !important;
	    font-size: 16px !important;
	    height: 35px !important;
	    padding-bottom: 5px !important;
    }
    .total_style th{
    	padding-left: 9px !important;
	    padding-right: 9px !important;
      border: 1px solid #ffffff !important;
     height: 35px !important;
     padding-top: 5px !important;
     background: #f0f0f0a3 !important;
    } 
    .total_style td{
    	padding-left: 9px !important;
	    padding-right: 9px !important;
      border: 1px solid #ffffff !important;
     height: 35px !important;
     padding-top: 5px !important;
     background: #f0f0f0a3 !important;
    }
	.page-footer {
	  position: fixed;
	  bottom: 0;
	  width: 100%;
	  /*border-top: 1px solid black;*/ /* for demo */
	  /*padding: 3mm;*/
	  display: none;
	}
	.page {
	  page-break-after: always;
	}

	@page {
	  margin: 10mm;
	  margin-bottom: 40px;
	}
  
   
	@media print {
	    tfoot {display: table-footer-group;}

        .page-footer {
        	display: block;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        margin: 0; /* Override the @page margin */
        padding: 0mm; /* Add padding if needed */
        padding: 0mm; /* Add padding if needed */
        border-top: 1px solid black; /* Add top border */
        background: white; /* Optional: background color for better visibility */
        z-index: 1000; /* Ensure it appears above other content */
        }
	}
	
</style>	
<div class="row" style="color: #000000 !important;">
	@if(empty($receipt_details->letter_head))
		<!-- Logo -->
		@if(!empty($receipt_details->logo))
		<div class="col-xs-4">
			<img style="max-height: 110px; width: auto;" src="{{$receipt_details->logo}}" class="img img-responsive">
		</div>	
		@endif
		<!-- Header text -->
		@if(!empty($receipt_details->header_text))
			<div class="col-xs-8" >
				{!! $receipt_details->header_text !!}
			</div>
		@endif

		<!-- business information here -->
		<div class="col-xs-5" style="margin-top: 37px !important;" >
			<b>
				<h3 class="text-center" >
					<!-- Shop & Location Name  -->
					@if(!empty($receipt_details->display_name))
						{{$receipt_details->display_name}}
					@endif
				</h3>
		    </b>

			<!-- Address -->
			<p >
			@if(!empty($receipt_details->address))
					<small class="text-center">
					{!! $receipt_details->address !!}
					</small>
			@endif
			@if(!empty($receipt_details->contact))
				<br/>{!! $receipt_details->contact !!}
			@endif	
			@if(!empty($receipt_details->contact) && !empty($receipt_details->website))
				, 
			@endif
			@if(!empty($receipt_details->website))
				{{ $receipt_details->website }}
			@endif
			@if(!empty($receipt_details->location_custom_fields))
				<br>{{ $receipt_details->location_custom_fields }}
			@endif
			</p>
			<p>
			@if(!empty($receipt_details->sub_heading_line1))
				{{ $receipt_details->sub_heading_line1 }}
			@endif
			@if(!empty($receipt_details->sub_heading_line2))
				<br>{{ $receipt_details->sub_heading_line2 }}
			@endif
			@if(!empty($receipt_details->sub_heading_line3))
				<br>{{ $receipt_details->sub_heading_line3 }}
			@endif
			@if(!empty($receipt_details->sub_heading_line4))
				<br>{{ $receipt_details->sub_heading_line4 }}
			@endif		
			@if(!empty($receipt_details->sub_heading_line5))
				<br>{{ $receipt_details->sub_heading_line5 }}
			@endif
			</p>
			<p>
			@if(!empty($receipt_details->tax_info1))
				<b>{{ $receipt_details->tax_label1 }}</b> {{ $receipt_details->tax_info1 }}
			@endif

			@if(!empty($receipt_details->tax_info2))
				<b>{{ $receipt_details->tax_label2 }}</b> {{ $receipt_details->tax_info2 }}
			@endif
			</p>

			<!-- Title of receipt -->
			@if(!empty($receipt_details->invoice_heading))
				<h2 style="text-align: right;" >
					{!! $receipt_details->invoice_heading !!}
				</h2>
			@endif
		</div>
	@else
		<div class="col-xs-12 text-center">
			<img style="width: 100%;margin-bottom: 10px;" src="{{$receipt_details->letter_head}}">
		</div>
	@endif
	<div class="col-xs-12 text-center" style="margin-top: 37px !important;">
		<!-- Invoice  number, Date  -->
		<p style="width: 100% !important" class="word-wrap">
			<span class="pull-right text-left word-wrap" style="font-size:18px; border: 1px solid #cfcaca; border-radius: 10px; padding: 10px 50px 10px 20px;">
				<!--@if(!empty($receipt_details->invoice_no_prefix))
					<b>{!! $receipt_details->invoice_no_prefix !!}</b>
				@endif
				{{$receipt_details->invoice_no}}-->

				@if(!empty($receipt_details->types_of_service))
					<br/>
					<span class="pull-left text-left">
						<strong>{!! $receipt_details->types_of_service_label !!}:</strong>
						{{$receipt_details->types_of_service}}
						<!-- Waiter info -->
						@if(!empty($receipt_details->types_of_service_custom_fields))
							@foreach($receipt_details->types_of_service_custom_fields as $key => $value)
								<br><strong>{{$key}}: </strong> {{$value}}
							@endforeach
						@endif
					</span>
				@endif

				<!-- Table information-->
		        @if(!empty($receipt_details->table_label) || !empty($receipt_details->table))
		        	<br/>
					<span class="pull-left text-left">
						@if(!empty($receipt_details->table_label))
							<b>{!! $receipt_details->table_label !!}</b>
						@endif
						{{$receipt_details->table}}

						<!-- Waiter info -->
					</span>
		        @endif

				<!-- customer info -->
				@if(!empty($receipt_details->customer_info))
					<b style="background-color: white; !important; color: #535353 !important; font-size: 20px !important">{{ $receipt_details->customer_label }}:</b> <br> {!! $receipt_details->customer_info !!}
				@endif
				@if(!empty($receipt_details->client_id_label))
					<br/>
					<b>{{ $receipt_details->client_id_label }}:</b> {{ $receipt_details->client_id }}
				@endif
				@if(!empty($receipt_details->customer_tax_label))
					<br/>
					<b>{{ $receipt_details->customer_tax_label }}:</b> {{ $receipt_details->customer_tax_number }}
				@endif
				@if(!empty($receipt_details->customer_custom_fields))
					<br/>{!! $receipt_details->customer_custom_fields !!}
				@endif
				@if(!empty($receipt_details->sales_person_label))
					<br/>
					<b>{{ $receipt_details->sales_person_label }}</b> {{ $receipt_details->sales_person }}
				@endif
				@if(!empty($receipt_details->commission_agent_label))
					<br/>
					<strong>{{ $receipt_details->commission_agent_label }}</strong> {{ $receipt_details->commission_agent }}
				@endif
				@if(!empty($receipt_details->customer_rp_label))
					<br/>
					<strong>{{ $receipt_details->customer_rp_label }}</strong> {{ $receipt_details->customer_total_rp }}
				@endif
			</span>

			<span class="pull-left text-left" style="font-size:18px!important; margin-left: 10px; border: 1px solid #cfcaca; border-radius: 10px; padding: 10px 30px 10px 20px;">
                 
                @if(!empty($receipt_details->invoice_no_prefix))
					<b>{!! $receipt_details->invoice_no_prefix !!}:</b>
				@endif
				{{--  --}}
					   @if($invoice_layout_id==2)
					   {{$receipt_details->facture_numero}}
					   @else
					   {{$receipt_details->invoice_no}}
					   @endif  
				{{--  --}}
				<br>
				<b>{{$receipt_details->date_label}}:</b> {{$receipt_details->invoice_date}}

				@if(!empty($receipt_details->due_date_label))
				<br><b>{{$receipt_details->due_date_label}}:</b> {{$receipt_details->due_date ?? ''}}
				@endif

				@if(!empty($receipt_details->brand_label) || !empty($receipt_details->repair_brand))
					<br>
					@if(!empty($receipt_details->brand_label))
						<b>{!! $receipt_details->brand_label !!}</b>
					@endif
					{{$receipt_details->repair_brand}}
		        @endif


		        @if(!empty($receipt_details->device_label) || !empty($receipt_details->repair_device))
					<br>
					@if(!empty($receipt_details->device_label))
						<b>{!! $receipt_details->device_label !!}</b>
					@endif
					{{$receipt_details->repair_device}}
		        @endif

				@if(!empty($receipt_details->model_no_label) || !empty($receipt_details->repair_model_no))
					<br>
					@if(!empty($receipt_details->model_no_label))
						<b>{!! $receipt_details->model_no_label !!}</b>
					@endif
					{{$receipt_details->repair_model_no}}
		        @endif

				@if(!empty($receipt_details->serial_no_label) || !empty($receipt_details->repair_serial_no))
					<br>
					@if(!empty($receipt_details->serial_no_label))
						<b>{!! $receipt_details->serial_no_label !!}</b>
					@endif
					{{$receipt_details->repair_serial_no}}<br>
		        @endif
				@if(!empty($receipt_details->repair_status_label) || !empty($receipt_details->repair_status))
					@if(!empty($receipt_details->repair_status_label))
						<b>{!! $receipt_details->repair_status_label !!}</b>
					@endif
					{{$receipt_details->repair_status}}<br>
		        @endif
		        
		        @if(!empty($receipt_details->repair_warranty_label) || !empty($receipt_details->repair_warranty))
					@if(!empty($receipt_details->repair_warranty_label))
						<b>{!! $receipt_details->repair_warranty_label !!}</b>
					@endif
					{{$receipt_details->repair_warranty}}
					<br>
		        @endif
		        
				<!-- Waiter info -->
				@if(!empty($receipt_details->service_staff_label) || !empty($receipt_details->service_staff))
		        	<br/>
					@if(!empty($receipt_details->service_staff_label))
						<b>{!! $receipt_details->service_staff_label !!}</b>
					@endif
					{{$receipt_details->service_staff}}
		        @endif
		        @if(!empty($receipt_details->shipping_custom_field_1_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_1_label!!} :</strong> {!!$receipt_details->shipping_custom_field_1_value ?? ''!!}
				@endif

				@if(!empty($receipt_details->shipping_custom_field_2_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_2_label!!}:</strong> {!!$receipt_details->shipping_custom_field_2_value ?? ''!!}
				@endif

				@if(!empty($receipt_details->shipping_custom_field_3_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_3_label!!}:</strong> {!!$receipt_details->shipping_custom_field_3_value ?? ''!!}
				@endif

				@if(!empty($receipt_details->shipping_custom_field_4_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_4_label!!}:</strong> {!!$receipt_details->shipping_custom_field_4_value ?? ''!!}
				@endif

				@if(!empty($receipt_details->shipping_custom_field_5_label))
					<br><strong>{!!$receipt_details->shipping_custom_field_2_label!!}:</strong> {!!$receipt_details->shipping_custom_field_5_value ?? ''!!}
				@endif
				{{-- sale order --}}
				@if(!empty($receipt_details->sale_orders_invoice_no))
					<br>
					<strong>@lang('restaurant.order_no'):</strong> {!!$receipt_details->sale_orders_invoice_no ?? ''!!}
				@endif

				@if(!empty($receipt_details->sale_orders_invoice_date))
					<br>
					<strong>@lang('lang_v1.order_dates'):</strong> {!!$receipt_details->sale_orders_invoice_date ?? ''!!}
				@endif
			</span>
		</p>
	</div>
</div>

<div class="row" style="color: #000000 !important">
	@includeIf('sale_pos.receipts.partial.common_repair_invoice')
</div>

<div class="row" style="color: #000000 !important;">
	<div class="col-xs-12 table-body">
		<br/>
		@php
			$p_width = 35;
		@endphp
		@if(!empty($receipt_details->item_discount_label))
			@php
				$p_width -= 10;
			@endphp
		@endif
		@if(!empty($receipt_details->discounted_unit_price_label))
			@php
				$p_width -= 10;
			@endphp
		@endif
		<table class="table table-responsive table-slim" >
			<thead class="thStyle">
				<tr >
					<th  width="{{$p_width}}%">{{$receipt_details->table_product_label}}</th>
					<th  class="text-left" width="10%">{{$receipt_details->table_qty_label}}</th>
			        
					@if(!empty($receipt_details->discounted_unit_price_label))
						<th class="text-left" width="10%">{{$receipt_details->discounted_unit_price_label}}</th>
					@endif
					@if(!empty($receipt_details->item_discount_label))
						<th  class="text-left" width="10%">{{$receipt_details->item_discount_label}}</th>
					@endif
			        @if($receipt_details->invoice_heading == "Facture" )
    					<th  class="text-left" width="10%">PU.TTC</th>
    					<th  class="text-left" width="20%">Total.TTC</th>
    				@else
    					<th  class="text-left" width="10%">Prix.U</th>
    					<th  class="text-left" width="20%">Montant</th>
					@endif
				</tr>
			</thead>
			<tbody  class="tdStyle" >
				@forelse($receipt_details->lines as $line)
					<tr>
						<td >
							@if(!empty($line['image']))
								<img src="{{$line['image']}}" alt="Image" width="50" style="float: left; margin-right: 8px;">
							@endif
                            {{$line['name']}} {{$line['product_variation']}} {{$line['variation']}} 
                            @if(!empty($line['sub_sku'])), {{$line['sub_sku']}} @endif @if(!empty($line['brand'])), {{$line['brand']}} @endif @if(!empty($line['cat_code'])), {{$line['cat_code']}}@endif
                            
                            @if(!empty($line['product_description']))
                            	<small>
                            		{!!$line['product_description']!!}
                            	</small>
                            @endif 
                            @if(!empty($line['sell_line_note']))
                            <br>
                            <small>
                            	{!!$line['sell_line_note']!!}
                            </small>
                            @endif 
                            @if(!empty($line['lot_number']))<br> {{$line['lot_number_label']}}:  {{$line['lot_number']}} @endif 
                            @if(!empty($line['product_expiry'])), {{$line['product_expiry_label']}}:  {{$line['product_expiry']}} @endif

                            @if(!empty($line['warranty_name'])) <br><small>{{$line['warranty_name']}} </small>@endif @if(!empty($line['warranty_exp_date'])) <small>- {{@format_date($line['warranty_exp_date'])}} </small>@endif
                            @if(!empty($line['warranty_description'])) <small> {{$line['warranty_description'] ?? ''}}</small>@endif

                            @if($receipt_details->show_base_unit_details && $line['quantity'] && $line['base_unit_multiplier'] !== 1)
                            <br><small>
                            	1 {{$line['units']}} = {{$line['base_unit_multiplier']}} {{$line['base_unit_name']}} <br>
                            	{{$line['base_unit_price']}} x {{$line['orig_quantity']}} = {{$line['line_total']}}
                            </small>
                            @endif
                        </td>
						<td class="text-right" >
							{{$line['quantity']}} {{$line['units']}} 

							@if($receipt_details->show_base_unit_details && $line['quantity'] && $line['base_unit_multiplier'] !== 1)
                            <br><small>
                            	{{$line['quantity']}} x {{$line['base_unit_multiplier']}} = {{$line['orig_quantity']}} {{$line['base_unit_name']}}
                            </small>
                            @endif
						</td>
    			        
						@if(!empty($receipt_details->discounted_unit_price_label))
							<td class="text-right" s>
								{{$line['unit_price_inc_tax']}}
							</td>
						@endif
						@if(!empty($receipt_details->item_discount_label))
							<td class="text-right" >
								{{$line['total_line_discount'] ?? '0.00'}}

								@if(!empty($line['line_discount_percent']))
								 	({{$line['line_discount_percent']}}%)
								@endif
							</td>
						@endif
						
						<td class="text-right">
							{{$line['unit_price_inc_tax']}}
						</td>
						<td class="text-right" >{{$line['line_total']}}</td>
					</tr>
					@if(!empty($line['modifiers']))
						@foreach($line['modifiers'] as $modifier)
							<tr>
								<td>
		                            {{$modifier['name']}} {{$modifier['variation']}} 
		                            @if(!empty($modifier['sub_sku'])), {{$modifier['sub_sku']}} @endif @if(!empty($modifier['cat_code'])), {{$modifier['cat_code']}}@endif
		                            @if(!empty($modifier['sell_line_note']))({!!$modifier['sell_line_note']!!}) @endif 
		                        </td>
								<td class="text-right">{{$modifier['quantity']}} {{$modifier['units']}} </td>
								<td class="text-right">{{$modifier['unit_price_inc_tax']}}</td>
								@if(!empty($receipt_details->discounted_unit_price_label))
									<td class="text-right">{{$modifier['unit_price_exc_tax']}}</td>
								@endif
								@if(!empty($receipt_details->item_discount_label))
									<td class="text-right">0.00</td>
								@endif
								<td class="text-right">{{$modifier['line_total']}}</td>
							</tr>
						@endforeach
					@endif
				@empty
					<tr>
						<td colspan="4" >&nbsp;</td>
						@if(!empty($receipt_details->discounted_unit_price_label))
    					<td></td>
    					@endif
    					@if(!empty($receipt_details->item_discount_label))
    					<td></td>
    					@endif
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>

<div class="row" style="color: #000000 !important;" >
	<div class="col-md-12"><hr/></div>
	<div class="col-xs-7">

		<table class="table table-slim total_style">

			@if(!empty($receipt_details->payments))
				@foreach($receipt_details->payments as $payment)
					<tr >
						<td >{{$payment['method']}}</td>
						<td class="text-right" >{{$payment['amount']}}</td>
						<td class="text-right" >{{$payment['date']}}</td>
					</tr>
				@endforeach
			@endif

			<!-- Total Paid-->
			@if(!empty($receipt_details->total_paid))
				<tr>
					<th >
						{!! $receipt_details->total_paid_label !!}
					</th>
					<td class="text-right" >
						{{$receipt_details->total_paid}}
					</td>
				</tr>
			@endif

			<!-- Total Due-->
			@if(!empty($receipt_details->total_due) && !empty($receipt_details->total_due_label))
			<tr>
				<th>
					{!! $receipt_details->total_due_label !!}
				</th>
				<td class="text-right">
					{{$receipt_details->total_due}}
				</td>
			</tr>
			@endif

			@if(!empty($receipt_details->all_due))
			<tr>
				<th>
					{!! $receipt_details->all_bal_label !!}
				</th>
				<td class="text-right">
					{{$receipt_details->all_due}}
				</td>
			</tr>
			@endif
		</table>
	</div>

	<div class="col-xs-5">
        <div class="table-responsive">
          	<table class="table table-slim total_style">
				<tbody>
					@if(!empty($receipt_details->total_quantity_label))
						<tr>
							<th style="width:70%">
								{!! $receipt_details->total_quantity_label !!}
							</th>
							<td class="text-right" >
								{{$receipt_details->total_quantity}}
							</td>
						</tr>
					@endif

					@if(!empty($receipt_details->total_items_label))
						<tr >
							<th style="width:70%">
								{!! $receipt_details->total_items_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->total_items}}
							</td>
						</tr>
					@endif
					
					@php
                        // Convert subtotal to float after removing commas
                        $subtotal = floatval(str_replace(',', '', $receipt_details->subtotal));
                    
                        // Get the last tax value and convert it to float after removing commas
                        $lastTax = is_array($receipt_details->taxes) 
                                    ? end($receipt_details->taxes) 
                                    : ($receipt_details->taxes instanceof \Illuminate\Support\Collection 
                                        ? $receipt_details->taxes->last() 
                                        : 0);
                        $lastTax = floatval(str_replace(',', '', $lastTax));
                    
                        // Perform the subtraction HT
                        $result = $subtotal - $lastTax;
                    @endphp
                    
					@if($receipt_details->invoice_heading == "Facture" )
					<tr >
						<th style="width:45%" >
							{!! $receipt_details->subtotal_label !!}
						</th>
						
						<td class="text-right" style="width:55%">
							 {{ number_format($result, 2) }} Dh
						</td>
					</tr>
				    @endif
					@if(!empty($receipt_details->total_exempt_uf))
					<tr>
						<th style="width:70%">
							@lang('lang_v1.exempt')
						</th>
						<td class="text-right">
							{{$receipt_details->total_exempt}}
						</td>
					</tr>
					@endif
					<!-- Shipping Charges -->
					@if(!empty($receipt_details->shipping_charges))
						<tr>
							<th style="width:70%">
								{!! $receipt_details->shipping_charges_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->shipping_charges}}
							</td>
						</tr>
					@endif

					@if(!empty($receipt_details->packing_charge))
						<tr>
							<th style="width:70%">
								{!! $receipt_details->packing_charge_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->packing_charge}}
							</td>
						</tr>
					@endif

					<!-- Discount -->
					@if( !empty($receipt_details->discount) )
						<tr>
							<th>
								{!! $receipt_details->discount_label !!}
							</th>

							<td class="text-right">
								(-) {{$receipt_details->discount}}
							</td>
						</tr>
					@endif

					@if( !empty($receipt_details->total_line_discount) )
						<tr>
							<th>
								{!! $receipt_details->line_discount_label !!}
							</th>

							<td class="text-right">
								(-) {{$receipt_details->total_line_discount}}
							</td>
						</tr>
					@endif

					@if( !empty($receipt_details->additional_expenses) )
						@foreach($receipt_details->additional_expenses as $key => $val)
							<tr>
								<td>
									{{$key}}:
								</td>

								<td class="text-right">
									(+) {{$val}}
								</td>
							</tr>
						@endforeach
					@endif

					@if( !empty($receipt_details->reward_point_label) )
						<tr>
							<th>
								{!! $receipt_details->reward_point_label !!}
							</th>

							<td class="text-right">
								(-) {{$receipt_details->reward_point_amount}}
							</td>
						</tr>
					@endif

					<!-- Tax -->
					@if( !empty($receipt_details->tax) )
						<tr>
							<th>
								{!! $receipt_details->tax_label !!}
							</th>
							<td class="text-right">
								(+) {{$receipt_details->tax}}
							</td>
						</tr>
					@endif
					@if($receipt_details->invoice_heading == "Facture" )
	        		<tr>
        				<th>{{$receipt_details->tax_summary_label}}:</th>
        				<td class="text-right">{{ end($receipt_details->taxes) }}</td>
        			</tr>
				    @endif

					@if( $receipt_details->round_off_amount > 0)
						<tr>
							<th>
								{!! $receipt_details->round_off_label !!}
							</th>
							<td class="text-right">
								{{$receipt_details->round_off}}
							</td>
						</tr>
					@endif

					<!-- Total -->
					<tr >
					    @if($receipt_details->invoice_heading == "Facture" )
    						<th>
    							{!! $receipt_details->total_label !!}
    						</th>
    					@else
    					    <th>
    							TOTAL
    						</th>
					    @endif
						<td class="text-right" >
							{{$receipt_details->total}}
							@if(!empty($receipt_details->total_in_words))
								<br>
								<small>({{$receipt_details->total_in_words}})</small>
							@endif
						</td>
						
					</tr>
				</tbody>
        	</table>
        </div>
    </div>

	@if(!empty($receipt_details->additional_notes))
	    <div class="col-xs-12">
	    	<p>{!! nl2br($receipt_details->additional_notes) !!}</p>
	    </div>
    @endif
    
</div>
<div class="row" style="color: #000000 !important;">
	@if($receipt_details->show_barcode || $receipt_details->show_qr_code)
		<div class="@if(!empty($receipt_details->footer_text)) col-xs-4 @else col-xs-12 @endif text-center">
			@if($receipt_details->show_barcode)
				{{-- Barcode --}}
				<img class="center-block" src="data:image/png;base64,{{DNS1D::getBarcodePNG($receipt_details->invoice_no, 'C128', 2,30,array(39, 48, 54), true)}}">
			@endif
			
			@if($receipt_details->show_qr_code && !empty($receipt_details->qr_code_text))
				<img class="center-block mt-5" src="data:image/png;base64,{{DNS2D::getBarcodePNG($receipt_details->qr_code_text, 'QRCODE', 3, 3, [39, 48, 54])}}">
			@endif
		</div>
	@endif
</div>
<div class="page-footer">
	<div  style="text-align: center;">
		Ste El Abboudi Négoce SARL, RC:604313 - IF:60122344 - ICE:003397897000060 - PATENTE:35503353 Adresse:174 Bd Zerkouti 5éme Etage Bureau 12,Casablanca. Tél:+212661849605-Email: contact@lines.ma-Site web:www.lines.ma 
    </div>
</div>
