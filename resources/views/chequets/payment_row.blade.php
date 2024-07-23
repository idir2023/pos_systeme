<div class="modal-dialog" role="document">
    <div class="modal-content">
      {!! Form::open(['url' => action([\App\Http\Controllers\TransactionPaymentController::class, 'postPayContactDue']), 'method' => 'post', 'id' => 'transaction_payment_add_form', 'files' => true ]) !!}
      {!! Form::hidden('transaction_id', $payment_line->id); !!}
      {{-- {!! Form::hidden('transaction_id', $transaction->id); !!} --}}
      @if(!empty($transaction->location))
        {!! Form::hidden('default_payment_accounts', $transaction->location->default_payment_accounts, ['id' => 'default_payment_accounts']); !!}
      @endif
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="text-align:center">Transferer Le Cheque/Effet</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-8">
            <div class="well">

            <strong>
              <div class="form-group custom-select-container">
                  {!! Form::label('contact_id', __('role.supplier')) !!}
                  <div class="input-group">
                      <span class="input-group-addon">
                          <i class="fa fa-user"></i>
                      </span>
                      {!! Form::select('contact_id', $suppliers, null, [
                          'class' => 'form-control select2-supplier custom-select',
                          'placeholder' => __('messages.Choose_a_supplier'),
                          'required' => 'required',
                      ]) !!}
                  </div>
              </div>
          </strong>
          
            </div>
          </div>

          <div class="col-md-4">
            <div class="well">
              <strong>@lang('sale.total_amount'): </strong><span class="display_currency" data-currency_symbol="true">{{ $transaction->final_total }}</span><br>
              <strong>@lang('purchase.payment_note'): </strong>
              @if(!empty($transaction->additional_notes))
              {{ $transaction->additional_notes }}
              @else
                --
              @endif
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            @if(!empty($transaction->contact))
              <strong>@lang('lang_v1.advance_balance'):</strong> <span class="display_currency" data-currency_symbol="true">{{$transaction->contact->balance}}</span>
              {!! Form::hidden('advance_balance', $transaction->contact->balance, ['id' => 'advance_balance', 'data-error-msg' => __('lang_v1.required_advance_balance_not_available')]); !!}
            @endif
          </div>
        </div>
        <div class="row payment_row">
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label("method" , __('purchase.payment_method') . ':*') !!}
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fas fa-money-bill-alt"></i>
                </span>
                {!! Form::select("method", $payment_types, $payment_line->method, ['class' => 'form-control select2 payment_types_dropdown', 'required',
                'readonly', 'style' => 'width:100%;']); !!}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label("paid_on" , __('lang_v1.paid_on') . ':*') !!}
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </span>
                {!! Form::text('paid_on', @format_datetime($payment_line->paid_on), ['class' => 'form-control', 'readonly', 'required']); !!}
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label("amount" , __('sale.amount') . ':*') !!}
              <div class="input-group">
                <span class="input-group-addon">
                  <i class="fas fa-money-bill-alt"></i>
                </span>
                {!! Form::text("amount", @num_format($payment_line->amount), ['class' => 'form-control input_number payment_amount','readonly','required', 'placeholder' => 'Amount', 'data-rule-max-value' => $payment_line->amount, 'data-msg-max-value' => __('lang_v1.max_amount_to_be_paid_is', ['amount' => $amount_formated])]); !!}
              </div>
            </div>
          </div>
  
          @php
              $pos_settings = !empty(session()->get('business.pos_settings')) ? json_decode(session()->get('business.pos_settings'), true) : [];
              $enable_cash_denomination_for_payment_methods = !empty($pos_settings['enable_cash_denomination_for_payment_methods']) ? $pos_settings['enable_cash_denomination_for_payment_methods'] : [];
          @endphp
  
          @if(!empty($pos_settings['enable_cash_denomination_on']) && $pos_settings['enable_cash_denomination_on'] == 'all_screens')
              <input type="hidden" class="enable_cash_denomination_for_payment_methods" value="{{json_encode($pos_settings['enable_cash_denomination_for_payment_methods'])}}">
              <div class="clearfix"></div>
              <div class="col-md-12 cash_denomination_div @if(!in_array($payment_line->method, $enable_cash_denomination_for_payment_methods)) hide @endif">
                  <hr>
                  <strong>@lang( 'lang_v1.cash_denominations' )</strong>
                    @if(!empty($pos_settings['cash_denominations']))
                      <table class="table table-slim">
                        <thead>
                          <tr>
                            <th width="20%" class="text-right">@lang('lang_v1.denomination')</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%" class="text-center">@lang('lang_v1.count')</th>
                            <th width="20%">&nbsp;</th>
                            <th width="20%" class="text-left">@lang('sale.subtotal')</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach(explode(',', $pos_settings['cash_denominations']) as $dnm)
                          <tr>
                            <td class="text-right">{{$dnm}}</td>
                            <td class="text-center" >X</td>
                            <td>{!! Form::number("denominations[$dnm]", null, ['class' => 'form-control cash_denomination input-sm', 'min' => 0, 'data-denomination' => $dnm, 'style' => 'width: 100px; margin:auto;' ]); !!}</td>
                            <td class="text-center">=</td>
                            <td class="text-left">
                              <span class="denomination_subtotal">0</span>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <th colspan="4" class="text-center">@lang('sale.total')</th>
                            <td>
                              <span class="denomination_total">0</span>
                              <input type="hidden" class="denomination_total_amount" value="0">
                              <input type="hidden" class="is_strict" value="{{$pos_settings['cash_denomination_strict_check'] ?? ''}}">
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                      <p class="cash_denomination_error error hide">@lang('lang_v1.cash_denomination_error')</p>
                    @else
                      <p class="help-block">@lang('lang_v1.denomination_add_help_text')</p>
                    @endif
              </div>
              <div class="clearfix"></div>
          @endif
          @if(!empty($accounts))
            <div class="col-md-6">
              <div class="form-group">
                {!! Form::label("account_id" , __('lang_v1.payment_account') . ':') !!}
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fas fa-money-bill-alt"></i>
                  </span>
                  {!! Form::select("account_id", $accounts, !empty($payment_line->account_id) ? $payment_line->account_id : '' , ['class' => 'form-control select2', 'id' => "account_id", 'style' => 'width:100%;']); !!}
                </div>
              </div>
            </div>
          @endif
          <div class="col-md-4">
            <div class="form-group">
              {!! Form::label('document', __('purchase.attach_document') . ':') !!}
              {!! Form::file('document', ['accept' => implode(',', array_keys(config('constants.document_upload_mimes_types')))]); !!}
              <p class="help-block">
              @includeIf('components.document_help_text')</p>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="payment_details_div @if( $payment_line->method !== 'card' ) {{ 'hide' }} @endif" data-type="card" >
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label("card_number", __('lang_v1.card_no')) !!}
                    {!! Form::text("card_number", $payment_line->card_number, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_no')]); !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label("card_holder_name", __('lang_v1.card_holder_name')) !!}
                    {!! Form::text("card_holder_name", $payment_line->card_holder_name, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_holder_name')]); !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label("card_transaction_number",__('lang_v1.card_transaction_no')) !!}
                    {!! Form::text("card_transaction_number", $payment_line->card_transaction_number, ['class' => 'form-control', 'placeholder' => __('lang_v1.card_transaction_no')]); !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label("card_type", __('lang_v1.card_type')) !!}
                    {!! Form::select("card_type", ['credit' => 'Credit Card', 'debit' => 'Debit Card', 'visa' => 'Visa', 'master' => 'MasterCard'], $payment_line->card_type,['class' => 'form-control select2']); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label("card_month", __('lang_v1.month')) !!}
                    {!! Form::text("card_month", $payment_line->card_month, ['class' => 'form-control', 
                    'placeholder' => __('lang_v1.month') ]); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label("card_year", __('lang_v1.year')) !!}
                    {!! Form::text("card_year", $payment_line->card_year, ['class' => 'form-control', 'placeholder' => __('lang_v1.year') ]); !!}
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label("card_security",__('lang_v1.security_code')) !!}
                    {!! Form::text("card_security", $payment_line->card_security, ['class' => 'form-control', 'placeholder' => __('lang_v1.security_code')]); !!}
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="payment_details_div @if( $payment_line->method !== 'cheque' ) {{ 'hide' }} @endif" data-type="cheque" >
            <div class="col-md-12">
                {{--  --}}
            <div class='row'>
        
                <div class="form-group col-md-4">
                    {!! Form::label('cheque_type', __('messages.cheque_type')) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                  <i class="fas fa-money-check"></i>
                        </span>
                        {!! Form::select(
                            'cheque_type',
                            ['Cheque' => 'Cheque', 'Effet' => 'Effet'],
                            isset($payment_line->cheque_type) ? $payment_line->cheque_type : 'Cheque',
                            [
                                'class' => 'form-control',
                                'placeholder' => __('messages.all'),
                                'readonly',                            
                              ]
                        ) !!}
                    </div>
                </div>
                <div class="form-group  col-md-8">
                    {!! Form::label("cheque_number",__('lang_v1.cheque_no')) !!}
                    {!! Form::text("cheque_number", $payment_line->cheque_number, ['class' => 'form-control',
                     'placeholder' => __('lang_v1.cheque_no'),
                     'readonly',        
                     ]); !!}
                </div>
        
            </div>
            {{--  --}}
            
                <div class="form-group">
                    {!! Form::label('bank_name',__('messages.bank_name')) !!}
                    {!! Form::text('bank_name', $payment_line->bank_name, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.bank_name'),
                        'id' => 'bank_name'
                        ,'readonly',
        
                    ]) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('cheque_owner',__('messages.cheque_owner')) !!}
                    {!! Form::text('cheque_owner', $payment_line->cheque_owner, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.cheque_owner'),
                        'id' => 'cheque_owner'
                        ,'readonly' ,
        
                    ]) !!}
                </div>
                
                {{--  --}}
        
                <div class="form-group">
                    {!! Form::label('cheque_echeance',__('messages.Cheque_Echeance')) !!}
                    {!! Form::date('cheque_echeance', $payment_line->cheque_echeance, [
                        'class' => 'form-control',
                        'placeholder' => __('messages.Cheque_Echeance'),
                        'id' => 'cheque_echeance',
                        'readonly',        
                    ]) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('cheque_status', __('messages.cheque_status')) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fas fa-money-bill-alt"></i>
                        </span>
                        {!! Form::select(
                            'cheque_status',
                            ['En cours' => 'En cours', 'Déposé' => 'Déposé', 'Encaissé' => 'Encaissé', 'Impayé' => 'Impayé'],
                            isset($payment_line->cheque_status) ? $payment_line->cheque_status : 'En cours', // Utilisez isset pour vérifier si le statut existe
                            [
                                'class' => 'form-control',
                                'placeholder' => __('messages.all'),
                                'required' => 'required',
                                'readonly',
                            ]
                        ) !!}
                    </div>
                </div>
        
            </div>
        </div>
        
          <div class="col-md-12">
            <div class="form-group">
              {!! Form::label("note", __('lang_v1.payment_note') . ':') !!}
              {!! Form::textarea("note", $payment_line->note, ['class' => 'form-control', 'rows' => 3,
             'readonly',]); !!}
            </div>
          </div>
        </div>
      </div>
  
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
      </div>
  
      {!! Form::close() !!}
  
    </div>
  </div>
  <script>
    $(document).ready(function() {
        // Cibler le select
        $('.select2-supplier').select2();
    });
</script>


