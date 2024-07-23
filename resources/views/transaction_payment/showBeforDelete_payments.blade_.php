<div class="modal-dialog" role="document">
    
    <div class="modal-content">
      <br>  
      <h3 class="text text-danger col-md-12" style="text-align: center;"> Supprimer les paiments en premier temps</h5>
        <div class="modal-header">
            <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         
        </div>

        <div class="modal-body">
            @if(in_array($transaction->type, ['purchase', 'purchase_return']))
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        <b>@lang('purchase.ref_no'):</b> #{{ $transaction->ref_no }}<br/>
                        <b>@lang('messages.date'):</b> {{ @format_date($transaction->transaction_date) }}<br/>
                        <b>@lang('purchase.purchase_status'):</b> {{ __('lang_v1.' . $transaction->status) }}<br>
                        <b>@lang('purchase.payment_status'):</b> {{ __('lang_v1.' . $transaction->payment_status) }}<br>
                    </div>
                </div>
            @elseif(in_array($transaction->type, ['expense', 'expense_refund']))
                <div class="row invoice-info">
                    @if(!empty($transaction->contact))
                        <div class="col-sm-4 invoice-col">
                            @lang('expense.expense_for'):
                            <address>
                                <strong>{{ $transaction->contact->supplier_business_name }}</strong>
                                {{ $transaction->contact->name }}
                                {!! $transaction->contact->contact_address !!}
                                @if(!empty($transaction->contact->tax_number))
                                    <br>@lang('contact.tax_no'): {{$transaction->contact->tax_number}}
                                @endif
                                @if(!empty($transaction->contact->mobile))
                                    <br>@lang('contact.mobile'): {{$transaction->contact->mobile}}
                                @endif
                                @if(!empty($transaction->contact->email))
                                    <br>@lang('business.email'): {{$transaction->contact->email}}
                                @endif
                            </address>
                        </div>
                    @endif
                    <div class="col-md-4 invoice-col">
                        @include('transaction_payment.payment_business_details')
                    </div>

                    <div class="col-sm-4 invoice-col">
                        <b>@lang('purchase.ref_no'):</b> #{{ $transaction->ref_no }}<br/>
                        <b>@lang('messages.date'):</b> {{ @format_date($transaction->transaction_date) }}<br/>
                        <b>@lang('purchase.payment_status'):</b> {{ __('lang_v1.' . $transaction->payment_status) }}<br>
                    </div>
                </div>
            @elseif($transaction->type == 'payroll')
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        @lang('essentials::lang.payroll_for'):
                        <address>
                            <strong>{{ $transaction->transaction_for->user_full_name }}</strong>
                            @if(!empty($transaction->transaction_for->address))
                                <br>{{$transaction->transaction_for->address}}
                            @endif
                            @if(!empty($transaction->transaction_for->contact_number))
                                <br>@lang('contact.mobile'): {{$transaction->transaction_for->contact_number}}
                            @endif
                            @if(!empty($transaction->transaction_for->email))
                                <br>@lang('business.email'): {{$transaction->transaction_for->email}}
                            @endif
                        </address>
                    </div>
                    <div class="col-md-4 invoice-col">
                        @include('transaction_payment.payment_business_details')
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>@lang('purchase.ref_no'):</b> #{{ $transaction->ref_no }}<br/>
                        @php
                            $transaction_date = \Carbon::parse($transaction->transaction_date);
                        @endphp
                        <b>@lang( 'essentials::lang.month_year' ):</b> {{ $transaction_date->format('F') }} {{ $transaction_date->format('Y') }}<br/>
                        <b>@lang('purchase.payment_status'):</b> {{ __('lang_v1.' . $transaction->payment_status) }}<br>
                    </div>
                </div>
            @else
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        @lang('contact.customer'):
                        <address>
                            <strong>{{ $transaction->contact->name }}</strong>

                            {!! $transaction->contact->contact_address !!}
                            @if(!empty($transaction->contact->tax_number))
                                <br>@lang('contact.tax_no'): {{$transaction->contact->tax_number}}
                            @endif
                            @if(!empty($transaction->contact->mobile))
                                <br>@lang('contact.mobile'): {{$transaction->contact->mobile}}
                            @endif
                            @if(!empty($transaction->contact->email))
                                <br>@lang('business.email'): {{$transaction->contact->email}}
                            @endif
                        </address>
                    </div>
                    <div class="col-md-4 invoice-col">
                        @include('transaction_payment.payment_business_details')
                    </div>
                    <div class="col-sm-4 invoice-col">
                        <b>@lang('sale.invoice_no'):</b> #{{ $transaction->invoice_no }}<br/>
                        <b>@lang('messages.date'):</b> {{ @format_date($transaction->transaction_date) }}<br/>
                        <b>@lang('purchase.payment_status'):</b> {{ __('lang_v1.' . $transaction->payment_status) }}<br>
                    </div>
                </div>
            @endif

            @if($transaction->payment_status != 'paid')
                <div class="row">
                    <div class="col-md-12">
                        @if((auth()->user()->can('purchase.payments') && (in_array($transaction->type, ['purchase', 'purchase_return']))) || (auth()->user()->can('sell.payments') && (in_array($transaction->type, ['sell', 'sell_return']))) || ((auth()->user()->can('all_expense.access') || auth()->user()->can('view_own_expense')) &&  $transaction->type == 'expense') )
                            <a href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, 'addPayment'], [$transaction->id]) }}" class="btn btn-primary btn-xs pull-right add_payment_modal no-print"><i class="fa fa-plus" aria-hidden="true"></i> @lang("purchase.add_payment")</a>
                        @endif
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                        <tr>
                          <th>@lang('messages.date')</th>
                          <th>@lang('purchase.ref_no')</th>
                          <th>@lang('purchase.amount')</th>
                          <th>@lang('purchase.payment_method')</th>
                          <th>@lang('messages.Cheque_Echeance')</th>
                          <th>@lang('messages.cheque_status')</th>
                          <th>@lang('purchase.payment_note')</th>
                          @if($accounts_enabled)
                            <th>@lang('lang_v1.payment_account')</th>
                          @endif
                          <th class="no-print">@lang('messages.actions')</th>
                        </tr>
                        @forelse ($payments as $payment)
                            <tr>
                              <td>{{ @format_datetime($payment->paid_on) }}</td>
                              <td>{{ $payment->payment_ref_no }}</td>
                              <td><span class="display_currency" data-currency_symbol="true">{{ $payment->amount }}</span></td>
                              <td>{{ $payment_types[$payment->method] ?? '' }}</td>
                              <td>{{ $payment->cheque_echeance }}</td>
                              <td>{{ $payment->cheque_status }}</td>
                              <td>@if(!empty($payment->gateway)){{$payment->gateway}} - @endif {{ $payment->note }}</td>
                              @if($accounts_enabled)
                                <td>{{$payment->payment_account->name ?? ''}}</td>
                              @endif
                              <td class="no-print" style="display: flex;">
        

                                @if((auth()->user()->can('delete_purchase_payment') && (in_array($transaction->type, ['purchase', 'purchase_return']))) || (auth()->user()->can('delete_sell_payment') && (in_array($transaction->type, ['sell', 'sell_return']))) || ((auth()->user()->can('all_expense.access') || auth()->user()->can('view_own_expense')) && $transaction->type == 'expense') )
                                    &nbsp; <button type="button" class="btn btn-danger btn-xs delete_payment" 
                                    data-href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, 'destroy'], [$payment->id]) }}"
                                    ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                @endif
                              &nbsp;
    
                              </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                              <td colspan="6">@lang('purchase.no_records_found')</td>
                            </tr>
                        @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang( 'messages.close' )</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
