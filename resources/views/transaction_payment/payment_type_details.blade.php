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
                        'placeholder' => __('messages.all')
                        ,isset($payment_line->cheque_transfered_id)? 'readonly' : '',
                    ]
                ) !!}
            </div>
        </div>
        <div class="form-group  col-md-8">
            {!! Form::label("cheque_number",__('lang_v1.cheque_no')) !!}
            {!! Form::text("cheque_number", $payment_line->cheque_number, ['class' => 'form-control',
             'placeholder' => __('lang_v1.cheque_no')
             ,isset($payment_line->cheque_transfered_id)? 'readonly' : '',

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
                ,isset($payment_line->cheque_transfered_id)? 'readonly' : '',

            ]) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('cheque_owner',__('messages.cheque_owner')) !!}
            {!! Form::text('cheque_owner', $payment_line->cheque_owner, [
                'class' => 'form-control',
                'placeholder' => __('messages.cheque_owner'),
                'id' => 'cheque_owner'
                ,isset($payment_line->cheque_transfered_id)? 'readonly' : '',

            ]) !!}
        </div>
        
        {{--  --}}

        <div class="form-group">
            {!! Form::label('cheque_echeance',__('messages.Cheque_Echeance')) !!}
            {!! Form::date('cheque_echeance', $payment_line->cheque_echeance, [
                'class' => 'form-control',
                'placeholder' => __('messages.Cheque_Echeance'),
                'id' => 'cheque_echeance'
                ,isset($payment_line->cheque_transfered_id)? 'readonly' : '',

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
                        
                    ]
                ) !!}
            </div>
        </div>

    </div>
</div>
<div class="payment_details_div @if( $payment_line->method !== 'bank_transfer' ) {{ 'hide' }} @endif" data-type="bank_transfer" >
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("bank_account_number",__('lang_v1.bank_account_number')) !!}
            {!! Form::text( "bank_account_number", $payment_line->bank_account_number, ['class' => 'form-control', 'placeholder' => __('lang_v1.bank_account_number')]); !!}
        </div>
    </div>
</div>
<div class="payment_details_div @if( $payment_line->method !== 'custom_pay_1' ) {{ 'hide' }} @endif" data-type="custom_pay_1" >
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("transaction_no_1", __('lang_v1.transaction_no')) !!}
            {!! Form::text("transaction_no_1", $payment_line->transaction_no, ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no')]); !!}
        </div>
    </div>
</div>
<div class="payment_details_div @if( $payment_line->method !== 'custom_pay_2' ) {{ 'hide' }} @endif" data-type="custom_pay_2" >
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("transaction_no_2", __('lang_v1.transaction_no')) !!}
            {!! Form::text("transaction_no_2", $payment_line->transaction_no, ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no')]); !!}
        </div>
    </div>
</div>
<div class="payment_details_div @if( $payment_line->method !== 'custom_pay_3' ) {{ 'hide' }} @endif" data-type="custom_pay_3" >
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("transaction_no_3", __('lang_v1.transaction_no')) !!}
            {!! Form::text("transaction_no_3", $payment_line->transaction_no, ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no')]); !!}
        </div>
    </div>
</div>
