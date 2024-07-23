@extends('layouts.app')
@section('title', 'cheques des garanties')

@section('content')
    <section class="content-header">
        <h1> @lang('lang_v1.customer_cheques')</h1>
        <br>
    </section>

    @component('components.widget', ['class' => 'box-primary'])
    <div class="modal-body">
        {!! Form::model($cheque_client, [
            'url' => action([\App\Http\Controllers\ChqsClientController::class, 'update'], [$cheque_client->id]),
            'method' => 'put',
            'id' => 'cheque_garant_form',
        ]) !!}

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('contact_id', __('contact.customer') . ':*') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    {!! Form::select('contact_id',[$customers->name], null, [
                        'class' => 'form-control mousetrap',
                        'id' => 'customer_id',
                        'placeholder' => 'Enter Customer name / phone',
                        'required',
                    ]) !!}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('cheque_echeance', 'Echeance du cheque*') !!}
                {!! Form::date('cheque_echeance', $cheque_client->cheque_echeance, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => 'Cheque Echeance',
                    'id' => 'cheque_echeance',
                ]) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('amount', 'Montant:*') !!}
                {!! Form::number('amount', $cheque_client->amount, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => 'Amount',
                    'id' => 'amount',
                ]) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('cheque_number', 'Numero du cheque:*') !!}
                {!! Form::text('cheque_number', $cheque_client->cheque_number, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => 'Cheque Number',
                    'id' => 'cheque_number',
                ]) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('cheque_status', 'Statut du cheque:*') !!}
                {!! Form::select('cheque_status', ['Activate' => 'Activate', 'Desactivate' => 'Desactivate'], $cheque_client->cheque_status, [
                    'class' => 'form-control',
                    'required',
                    'id' => 'cheque_status',
                ]) !!}
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('cheque_dateP', 'Date de Paiment:*') !!}
                {!! Form::date('cheque_dateP', $cheque_client->cheque_dateP, [
                    'class' => 'form-control',
                    'required',
                    'placeholder' => 'Cheque DateP',
                    'id' => 'cheque_dateP',
                ]) !!}
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">@lang('messages.submit')</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>
        {!! Form::close() !!}
    </div>
@endcomponent

@endsection

@section('javascript')
<script src="{{ asset('js/pos.js?v=' . $asset_v) }}"></script>
@endsection