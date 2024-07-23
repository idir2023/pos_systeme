<div class="payment_details_div @if ($payment_line['method'] !== 'card') {{ 'hide' }} @endif" data-type="card">
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label("card_number_$row_index", __('lang_v1.card_no')) !!}
            {!! Form::text("payment[$row_index][card_number]", $payment_line['card_number'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.card_no'),
                'id' => "card_number_$row_index",
            ]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label("card_holder_name_$row_index", __('lang_v1.card_holder_name')) !!}
            {!! Form::text("payment[$row_index][card_holder_name]", $payment_line['card_holder_name'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.card_holder_name'),
                'id' => "card_holder_name_$row_index",
            ]) !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!! Form::label("card_transaction_number_$row_index", __('lang_v1.card_transaction_no')) !!}
            {!! Form::text("payment[$row_index][card_transaction_number]", $payment_line['card_transaction_number'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.card_transaction_no'),
                'id' => "card_transaction_number_$row_index",
            ]) !!}
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label("card_type_$row_index", __('lang_v1.card_type')) !!}
            {!! Form::select(
                "payment[$row_index][card_type]",
                ['credit' => 'Credit Card', 'debit' => 'Debit Card', 'visa' => 'Visa', 'master' => 'MasterCard'],
                $payment_line['card_type'],
                ['class' => 'form-control', 'id' => "card_type_$row_index"],
            ) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label("card_month_$row_index", __('lang_v1.month')) !!}
            {!! Form::text("payment[$row_index][card_month]", $payment_line['card_month'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.month'),
                'id' => "card_month_$row_index",
            ]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label("card_year_$row_index", __('lang_v1.year')) !!}
            {!! Form::text("payment[$row_index][card_year]", $payment_line['card_year'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.year'),
                'id' => "card_year_$row_index",
            ]) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label("card_security_$row_index", __('lang_v1.security_code')) !!}
            {!! Form::text("payment[$row_index][card_security]", $payment_line['card_security'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.security_code'),
                'id' => "card_security_$row_index",
            ]) !!}
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="payment_details_div @if ($payment_line['method'] !== 'cheque') {{ 'hide' }} @endif" data-type="cheque">
    <div class="col-md-12">

        <div class='row'>
            {{--  --}}
            <div class="form-group  col-md-4">
                {!! Form::label("cheque_type_$row_index", __('messages.cheque_type')) !!}
                <div class="input-group">
                    <span class="input-group-addon">
              <i class="fas fa-money-check"></i>
                    </span>
                    {!! Form::select(
                        "payment[$row_index][cheque_type]",
                        ['Cheque' => 'Cheque', 'Effet' => 'Effet'],
                        isset($payment_line['cheque_type']) ? $payment_line['cheque_type'] : 'Cheque',
                        [
                            'class' => 'form-control',
                            'placeholder' => __('messages.all'),
                        ]
                    ) !!}
                </div>
            </div>
            {{--  --}}

            <div class="form-group  col-md-8">
            {!! Form::label("cheque_number_$row_index", __('lang_v1.cheque_no')) !!}
            {!! Form::text("payment[$row_index][cheque_number]", $payment_line['cheque_number'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.cheque_no'),
                'id' => "cheque_number_$row_index",
            ]) !!}
           </div>
           
        </div>
{{--  --}}
        <div class="form-group">
            {!! Form::label("bank_name_$row_index",__('messages.bank_name')) !!}
            {!! Form::text("payment[$row_index][bank_name]", $payment_line['bank_name'], [
                'class' => 'form-control',
                'placeholder' => __('messages.bank_name'),
                'id' => "bank_name_$row_index",
            ]) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label("cheque_owner_$row_index",__('messages.cheque_owner')) !!}
            {!! Form::text("payment[$row_index][cheque_owner]", $payment_line['cheque_owner'], [
                'class' => 'form-control',
                'placeholder' => __('messages.cheque_owner'),
                'id' => "cheque_owner_$row_index",
            ]) !!}
        </div>
{{--  --}}
         <div class="form-group">
            {!! Form::label("cheque_echeance_$row_index", __('messages.Cheque_Echeance')) !!}
            {!! Form::date("payment[$row_index][cheque_echeance]", $payment_line['cheque_echeance'], [
                'class' => 'form-control',
                'placeholder' => __('messages.Cheque_Echeance'),
                'id' => "cheque_echeance_$row_index",
            ]) !!}
        </div>

        <div class="form-group">
            {!! Form::label("cheque_status_$row_index", __('messages.cheque_status')) !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-money-bill-alt"></i>
                </span>
                {!! Form::select(
                    "payment[$row_index][cheque_status]",
                    ['En cours' => 'En cours', 'Déposé' => 'Déposé', 'Encaissé' => 'Encaissé', 'Impayé' => 'Impayé'],
                     $payment_line->cheque_status ?? 'En cours',
                    [
                        'class' => 'form-control',
                        'placeholder' => __('messages.all'),
                        'id' => "cheque_status_$row_index",
                    ]
                ) !!}
            </div>
        </div> 
        
    </div>
</div>

<div class="payment_details_div @if ($payment_line['method'] !== 'bank_transfer') {{ 'hide' }} @endif" data-type="bank_transfer">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label("bank_account_number_$row_index", __('lang_v1.bank_account_number')) !!}
            {!! Form::text("payment[$row_index][bank_account_number]", $payment_line['bank_account_number'], [
                'class' => 'form-control',
                'placeholder' => __('lang_v1.bank_account_number'),
                'id' => "bank_account_number_$row_index",
            ]) !!}
        </div>
    </div>
</div>

@for ($i = 1; $i < 8; $i++)
    <div class="payment_details_div @if ($payment_line['method'] !== 'custom_pay_' . $i) {{ 'hide' }} @endif"
        data-type="custom_pay_{{ $i }}">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label("transaction_no_{$i}_{$row_index}", __('lang_v1.transaction_no')) !!}
                {!! Form::text("payment[$row_index][transaction_no_{$i}]", $payment_line['transaction_no'], [
                    'class' => 'form-control',
                    'placeholder' => __('lang_v1.transaction_no'),
                    'id' => "transaction_no_{$i}_{$row_index}",
                ]) !!}
            </div>
        </div>
    </div>
@endfor


