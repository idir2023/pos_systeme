@extends('layouts.app')
@section('title', __('report.register_report'))
<style type="text/css">
  @media print {
    .modal {
        position: absolute;
        left: 0;
        top: 0;
        margin: 0;
        padding: 0;
        overflow: visible!important;
    }
}
</style>

@section('content')
<section class="content-header">
    <h1>{{ __('report.payment_report')}}</h1>
</section>

<section class="content">
  
@component('components.filters', ['title' => __('report.filters')])
          <form action="{{ url('/reports/postPaymentReport') }}" method="post" id='filtrageForm'>
              @csrf
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                      <label for="register_user_id">@lang('report.user')</label>
                      <select name="register_user_id" class="form-control select2" style="width:100%" placeholder="All Users" id="users_id">
                          <option value="">{{ __('report.all') }}</option>
                          @foreach($users as $key => $value)
                              <option value="{{ $key }}">{{ $value }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>              
              
              <div class="col-md-3">
                  <div class="form-group">
                      <label for="location_id">@lang('purchase.business_location') </label>
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fas fa-map-marker-alt"></i>
                          </span>
                          <select name="location_id" class="form-control select2" id="location_id">
                              <option value="">@lang('report.all') </option>
                              @foreach($business_locations as $key => $value)
                                  <option value="{{ $key }}">{{ $value }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>    

              <div class="col-md-3">
                <div class="form-group">
                    <label for="date_start">@lang('report.date_start'):</label>
                    <input type="date" name="date_start" placeholder="Select a date start" class="form-control date-range-picker">
                </div>
          </div>

          <div class="col-md-3">
              <div class="form-group">
                  <label for="date_end">@lang('report.date_end'):</label>
                  <input type="date" name="date_end" placeholder="Select a date end" class="form-control date-range-picker">
              </div>
          </div>

            
            </div> 
          <button type="submit" class='btn btn-success btn-sm'>Search</button>
          </form>
@endcomponent

<div class='medal'>
@component('components.widget', ['class' => 'box-primary'], ['id'=>'payment_raport'])
<div class="col-md-12">
<div class="col-md-6">

  <h4 class='text-primary text-center text-bold'>@lang('report.Transaction_payment_in')</h4>
  <table class="table table-condensed" >
        <tr>
          <th>@lang('lang_v1.payment_method')</th>
          <th>@lang('sale.amount')</th>
        </tr>
  
        <tr>
          <td>
            @lang('cash_register.cash_payment'):
          </th>
          <td>
            <span class="display_currency" data-currency_symbol="true">{{ $SellTransaction->amount_cash }}</span>
          </td>
        </tr>
  
        <tr>
          <td>
            @lang('cash_register.checque_payment'):
          </td>
          <td>
            <span class="display_currency" data-currency_symbol="true">{{ $SellTransaction->amount_cheque }}</span>
          </td>
        </tr>
  
        <tr>
          <td>
            @lang('cash_register.card_payment'):
          </td>
          <td>
            <span class="display_currency" data-currency_symbol="true">{{ $SellTransaction->amount_card }}</span>
          </td>
        </tr>
  
        <tr>
          <td>
            @lang('cash_register.bank_transfer'):
          </td>
          <td>
            <span class="display_currency" data-currency_symbol="true">{{ $SellTransaction->amount_bank_transfer }}</span>
          </td>
        </tr>
        <tr>
          <td class ='text text-warning'>
            @lang('Total'):
          </td>
          <td>
            <span class="text text-danger display_currency" data-currency_symbol="true">{{ $SellTransaction->amount_bank_transfer
            +$SellTransaction->amount_card 
            +$SellTransaction->amount_cheque 
            +$SellTransaction->amount_cash
            }}</span>
          </td>
        </tr>
  </table>
  <hr>
  <h4 class='text-primary text-center text-bold'>@lang('lang_v1.purchase_return')</h4>
  <table class="table table-condensed" id="cheque_payment_table">
     <tr>
       <th>@lang('lang_v1.payment_method')</th>
       <th>@lang('sale.amount')</th>
     </tr>

     <tr>
       <td>
         @lang('cash_register.cash_payment'):
       </th>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['purchase_return']->amount_cash }}</span>
       </td>
     </tr>

     <tr>
       <td>
         @lang('cash_register.checque_payment'):
       </td>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['purchase_return']->amount_cheque }}</span>
       </td>
     </tr>

     <tr>
       <td>
         @lang('cash_register.card_payment'):
       </td>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['purchase_return']->amount_card }}</span>
       </td>
     </tr>
     
     <tr>
       <td>
         @lang('cash_register.bank_transfer'):
       </td>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['purchase_return']->amount_bank_transfer }}</span>
       </td>
     </tr>
     <tr>
       <td class ='text text-warning'>
         @lang('Total'):
       </td>
       <td>
         <span class="text text-danger display_currency" data-currency_symbol="true">{{ $transactionData['purchase_return']->amount_bank_transfer
         +$transactionData['purchase_return']->amount_card 
         +$transactionData['purchase_return']->amount_cheque 
         +$transactionData['purchase_return']->amount_cash
         }}</span>
       </td>
     </tr>
</table>
<h2 class='text-success text-bold'>@lang('report.total_entrer')</h2>
<table class="table table-condensed">
      <tr>
        <th>@lang('lang_v1.payment_method')</th>
        <th>@lang('sale.amount')</th>
      </tr>

      <tr>
        <td>
          @lang('cash_register.cash_payment'):
        </th>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$SellTransaction->amount_cash + $transactionData['purchase_return']->amount_cash}}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.checque_payment'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$SellTransaction->amount_cheque + $transactionData['purchase_return']->amount_cheque}}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.card_payment'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$SellTransaction->amount_card + $transactionData['purchase_return']->amount_card }}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.bank_transfer'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$SellTransaction->amount_bank_transfer + $transactionData['purchase_return']->amount_bank_transfer}}</span>
        </td>
      </tr>
      <tr>
        <td><strong>Total :</strong></td>
        <td>
        
          <span class="display_currency" data-currency_symbol="true">
            {{ $SellTransaction->amount_cash + $transactionData['purchase_return']->amount_cash +
              $SellTransaction->amount_cheque + $transactionData['purchase_return']->amount_cheque +
              $SellTransaction->amount_card  +$transactionData['purchase_return']->amount_card  +
              $SellTransaction->amount_bank_transfer + $transactionData['purchase_return']->amount_bank_transfer }}
          </span>
        </td>
      </tr>

</table>
<hr>

</div>
<div class="col-md-6">

<h4 class='text-primary text-center text-bold'> @lang('report.Transaction_payment_out')</h4>
<table class="table table-condensed" id="cheque_payment_table">
   <tr>
     <th>@lang('lang_v1.payment_method')</th>
     <th>@lang('sale.amount')</th>
   </tr>

   <tr>
     <td>
       @lang('cash_register.cash_payment'):
     </th>
     <td>
       <span class="display_currency" data-currency_symbol="true">{{ $PurchaseTransaction->amount_cash }}</span>
     </td>
   </tr>

   <tr>
     <td>
       @lang('cash_register.checque_payment'):
     </td>
     <td>
       <span class="display_currency" data-currency_symbol="true">{{ $PurchaseTransaction->amount_cheque }}</span>
     </td>
   </tr>

   <tr>
     <td>
       @lang('cash_register.card_payment'):
     </td>
     <td>
       <span class="display_currency" data-currency_symbol="true">{{ $PurchaseTransaction->amount_card }}</span>
     </td>
   </tr>
   
   <tr>
     <td>
       @lang('cash_register.bank_transfer'):
     </td>
     <td>
       <span class="display_currency" data-currency_symbol="true">{{ $PurchaseTransaction->amount_bank_transfer }}</span>
     </td>
   </tr>
   <tr>
     <td class ='text text-warning'>
       @lang('Total'):
     </td>
     <td>
       <span class="text text-danger display_currency" data-currency_symbol="true">{{ $PurchaseTransaction->amount_bank_transfer
       +$PurchaseTransaction->amount_card 
       +$PurchaseTransaction->amount_cheque 
       +$PurchaseTransaction->amount_cash
       }}</span>
     </td>
   </tr>

</table>
<hr>
<h4 class='text-primary text-center text-bold'>@lang('lang_v1.sell_return')</h4>
    <table class="table table-condensed" id="">
          <tr>
            <th>@lang('lang_v1.payment_method')</th>
            <th>@lang('sale.amount')</th>
          </tr>
    
          <tr>
            <td>
              @lang('cash_register.cash_payment'):
            </th>
            <td>
              <span class="display_currency" data-currency_symbol="true">{{ $transactionData['sell_return']->amount_cash }}</span>
            </td>
          </tr>
    
          <tr>
            <td>
              @lang('cash_register.checque_payment'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true">{{ $transactionData['sell_return']->amount_cheque }}</span>
            </td>
          </tr>
    
          <tr>
            <td>
              @lang('cash_register.card_payment'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true">{{ $transactionData['sell_return']->amount_card }}</span>
            </td>
          </tr>
          
          <tr>
            <td>
              @lang('cash_register.bank_transfer'):
            </td>
            <td>
              <span class="display_currency" data-currency_symbol="true">{{ $transactionData['sell_return']->amount_bank_transfer }}</span>
            </td>
          </tr>
          <tr>
            <td class ='text text-warning'>
              @lang('Total'):
            </td>
            <td>
              <span class="text text-danger display_currency" data-currency_symbol="true">{{ $transactionData['sell_return']->amount_bank_transfer
              +$transactionData['sell_return']->amount_card 
              +$transactionData['sell_return']->amount_cheque 
              +$transactionData['sell_return']->amount_cash
              }}</span>
            </td>
          </tr>
    </table>
 
  <h4 class='text-primary text-center text-bold'>@lang('expense.expenses')</h4>
  <table class="table table-condensed" id="cheque_payment_table">
     <tr>
       <th>@lang('lang_v1.payment_method')</th>
       <th>@lang('sale.amount')</th>
     </tr>
     <tr>
       <td>
         @lang('cash_register.cash_payment'):
       </th>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['expense']->amount_cash }}</span>
       </td>
     </tr>

     <tr>
       <td>
         @lang('cash_register.checque_payment'):
       </td>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['expense']->amount_cheque }}</span>
       </td>
     </tr>

     <tr>
       <td>
         @lang('cash_register.card_payment'):
       </td>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['expense']->amount_card }}</span>
       </td>
     </tr>
     
     <tr>
       <td>
         @lang('cash_register.bank_transfer'):
       </td>
       <td>
         <span class="display_currency" data-currency_symbol="true">{{ $transactionData['expense']->amount_bank_transfer }}</span>
       </td>
     </tr>
     <tr>
       <td class ='text text-warning'>
         @lang('Total'):
       </td>
       <td>
         <span class="text text-danger display_currency" data-currency_symbol="true">{{ $transactionData['expense']->amount_bank_transfer
         +$transactionData['expense']->amount_card 
         +$transactionData['expense']->amount_cheque 
         +$transactionData['expense']->amount_cash
         }}</span>
       </td>
     </tr>
  </table>
<hr>

<h2 class='text-danger text-bold'>@lang('report.total_sortir')</h2>
<table class="table table-condensed">
      <tr>
        <th>@lang('lang_v1.payment_method')</th>
        <th>@lang('sale.amount')</th>
      </tr>

      <tr>
        <td>
          @lang('cash_register.cash_payment'):
        </th>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$PurchaseTransaction->amount_cash+ $transactionData['sell_return']->amount_cash+$transactionData['expense']->amount_cash}}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.checque_payment'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$PurchaseTransaction->amount_cheque+ $transactionData['sell_return']->amount_cheque+$transactionData['expense']->amount_cheque }}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.card_payment'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$PurchaseTransaction->amount_card+ $transactionData['sell_return']->amount_card+$transactionData['expense']->amount_card }}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.bank_transfer'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$PurchaseTransaction->amount_bank_transfer+ $transactionData['sell_return']->amount_bank_transfer+$transactionData['expense']->amount_bank_transfer}}</span>
        </td>
      </tr>
      <tr>
    <td>Total :</td>
    <td>
      <span class="display_currency" data-currency_symbol="true">
        {{ $PurchaseTransaction->amount_cash + $transactionData['sell_return']->amount_cash +
           $transactionData['expense']->amount_cash + $PurchaseTransaction->amount_cheque +
           $transactionData['sell_return']->amount_cheque + $transactionData['expense']->amount_cheque +
           $PurchaseTransaction->amount_card + $transactionData['sell_return']->amount_card +
           $transactionData['expense']->amount_card + $PurchaseTransaction->amount_bank_transfer +
           $transactionData['sell_return']->amount_bank_transfer + $transactionData['expense']->amount_bank_transfer }}
      </span>
    </td>
  </tr>

</table>
<hr>


</div>
</div>
@endcomponent

@component('components.filters1', ['title' => __('lang_v1.product_sold_details_register')])
  <div class="col-md-12">
    <table class="table table-condensed">
      <tr>
        <th>#</th>
        <th>@lang('product.sku')</th>
        <th>@lang('sale.product')</th>
        <th>@lang('sale.qty')</th>
        <th>@lang('sale.total_amount')</th>
      </tr>
      @php
        $total_amount = 0;
        $total_quantity = 0;
      @endphp
      @foreach($details as $detail)
        <tr>
          <td>
            {{$loop->iteration}}.
          </td>
          <td>
            {{$detail->sku}}
          </td>
          <td>
            {{$detail->product_name}}
            @if($detail->type == 'variable')
             {{$detail->product_variation_name}} - {{$detail->variation_name}}
            @endif
          </td>
          <td>
            {{@format_quantity($detail->total_quantity)}}
            @php
              $total_quantity += $detail->total_quantity;
            @endphp
          </td>
          <td>
            <span class="display_currency" data-currency_symbol="true">
              {{$detail->total_amount}}
            </span>
            @php
              $total_amount += $detail->total_amount;
            @endphp
          </td>
        </tr>
      @endforeach
      @php
        $total_amount += ($transaction_details->total_tax - $transaction_details->total_discount);

        $total_amount += $transaction_details->total_shipping_charges;
      @endphp

      <!-- Final details -->
      <tr class="success">
        <th>#</th>
        <th></th>
        <th></th>
        <th>{{$total_quantity}}</th>
        <th>

          @if($transaction_details->total_tax != 0)
            @lang('sale.order_tax'): (+)
            <span class="display_currency" data-currency_symbol="true">
              {{$transaction_details->total_tax}}
            </span>
            <br/>
          @endif

          @if($transaction_details->total_discount != 0)
            @lang('sale.discount'): (-)
            <span class="display_currency" data-currency_symbol="true">
              {{$transaction_details->total_discount}}
            </span>
            <br/>
          @endif
          @if($transaction_details->total_shipping_charges != 0)
            @lang('lang_v1.total_shipping_charges'): (+)
            <span class="display_currency" data-currency_symbol="true">
              {{$transaction_details->total_shipping_charges}}
            </span>
            <br/>
          @endif

          @lang('lang_v1.grand_total'):
          <span class="display_currency" data-currency_symbol="true">
            {{$total_amount}}
          </span>
        </th>
      </tr>

    </table>
  </div>
@endcomponent

@component('components.filters2', ['title' => __('lang_v1.product_purchase_details_register')])
  <div class="col-md-12">
    <table class="table table-condensed">
      <tr>
        <th>#</th>
        <th>@lang('product.sku')</th>
        <th>@lang('sale.product')</th>
        <th>@lang('sale.qty')</th>
        <th>@lang('sale.total_amount')</th>
      </tr>
      @php
        $total_amount = 0;
        $total_quantity = 0;
      @endphp
      @foreach($details_purchase as $detail)
        <tr>
          <td>
            {{$loop->iteration}}.
          </td>
          <td>
            {{$detail->sku}}
          </td>
          <td>
            {{$detail->product_name}}
            @if($detail->type == 'variable')
             {{$detail->product_variation_name}} - {{$detail->variation_name}}
            @endif
          </td>
          <td>
            {{@format_quantity($detail->total_quantity)}}
            @php
              $total_quantity += $detail->total_quantity;
            @endphp
          </td>
          <td>
            <span class="display_currency" data-currency_symbol="true">
              {{$detail->total_amount}}
            </span>
            @php
              $total_amount += $detail->total_amount;
            @endphp
          </td>
        </tr>
      @endforeach
      @php
        $total_amount += ($transaction_details_purchase->total_tax - $transaction_details_purchase->total_discount);

        $total_amount += $transaction_details_purchase->total_shipping_charges;
      @endphp

      <!-- Final details -->
      <tr class="success">
        <th>#</th>
        <th></th>
        <th></th>
        <th>{{$total_quantity}}</th>
        <th>

          @if($transaction_details_purchase->total_tax != 0)
            @lang('sale.order_tax'): (+)
            <span class="display_currency" data-currency_symbol="true">
              {{$transaction_details_purchase->total_tax}}
            </span>
            <br/>
          @endif

          @if($transaction_details_purchase->total_discount != 0)
            @lang('sale.discount'): (-)
            <span class="display_currency" data-currency_symbol="true">
              {{$transaction_details_purchase->total_discount}}
            </span>
            <br/>
          @endif
          @if($transaction_details_purchase->total_shipping_charges != 0)
            @lang('lang_v1.total_shipping_charges'): (+)
            <span class="display_currency" data-currency_symbol="true">
              {{$transaction_details_purchase->total_shipping_charges}}
            </span>
            <br/>
          @endif

          @lang('lang_v1.grand_total'):
          <span class="display_currency" data-currency_symbol="true">
            {{$total_amount}}
          </span>
        </th>
      </tr>

    </table>
  </div>
@endcomponent

@component('components.widget', ['class' => 'box-primary'], ['id'=>'payment_raport'])
<h2 class='text-danger text-bold'>@lang('report.total_caisse')</h2>
<table class="table table-condensed">
         @php
            // Your existing code
            $amountDifference_caisse_cash = $SellTransaction->amount_cash + $transactionData['purchase_return']->amount_cash-($PurchaseTransaction->amount_cash+ $transactionData['sell_return']->amount_cash+$transactionData['expense']->amount_cash);
            $amountDifference_caisse_cheque = $SellTransaction->amount_cheque + $transactionData['purchase_return']->amount_cheque-($PurchaseTransaction->amount_cheque+ $transactionData['sell_return']->amount_cheque+$transactionData['expense']->amount_cheque);
            $amountDifference_caisse_card =  $SellTransaction->amount_card + $transactionData['purchase_return']->amount_card-($PurchaseTransaction->amount_card+ $transactionData['sell_return']->amount_card+$transactionData['expense']->amount_card);
            $amountDifference_caisse_bank_transfer = $SellTransaction->amount_bank_transfer + $transactionData['purchase_return']->amount_bank_transfer-($PurchaseTransaction->amount_bank_transfer+ $transactionData['sell_return']->amount_bank_transfer+$transactionData['expense']->amount_bank_transfer);
        @endphp
      <tr>
        <th>@lang('lang_v1.payment_method')</th>
        <th>@lang('sale.amount')</th>
      </tr>

      <tr>
        <td>
          @lang('cash_register.cash_payment'):
        </th>
        <td>
      
          <span class="display_currency" data-currency_symbol="true">{{$amountDifference_caisse_cash}}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.checque_payment'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$amountDifference_caisse_cheque }}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.card_payment'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$amountDifference_caisse_card }}</span>
        </td>
      </tr>

      <tr>
        <td>
          @lang('cash_register.bank_transfer'):
        </td>
        <td>
          <span class="display_currency" data-currency_symbol="true">{{$amountDifference_caisse_bank_transfer}}</span>
        </td>
      </tr>
      <tr>
    <td>Total :</td>
    <td>
      <span class="display_currency" data-currency_symbol="true">
        {{$amountDifference_caisse_cash+$amountDifference_caisse_cheque+$amountDifference_caisse_card+$amountDifference_caisse_bank_transfer }}
      </span>
    </td>
  </tr>

</table>
<hr>

<div class="modal-footer">
  <button type="button" class="btn btn-primary no-print" 
    aria-label="Print" 
      onclick="$(this).closest('div.medal').printThis();">
    <i class="fa fa-print"></i> @lang( 'messages.print' )
  </button>

  <button type="button" class="btn btn-default no-print" 
    data-dismiss="modal">@lang( 'messages.cancel' )
  </button>
</div>
@endcomponent
<div>
</section>
@endsection

@section('javascript')
{{-- <script src="{{ asset('js/report.js?v=' . $asset_v) }}"></script>  --}}
<script>
  $(document).ready(function() {

      $('#filtrageForm').submit(function(e) {
      e.preventDefault(); // Prevent the form from submitting traditionally

      $.ajax: {
            url:{{url('/reports/postPaymentReport')}},
            method:'post',
            data: function(d) {
                d.users_id = $('select#users_id').val();
                d.location_id = $('select#location_id').val();
                var start = '';
                var end = '';
                if ($('#date_filter').val()) {
                    start = $('#date_filter')
                        .data('daterangepicker')
                        .startDate.format('YYYY-MM-DD');
                    end = $('#date_filter')
                        .data('daterangepicker')
                        .endDate.format('YYYY-MM-DD');
                }
                d.start_date = start;
                d.end_date = end;
            },
        },
  });
});
</script>
@endsection