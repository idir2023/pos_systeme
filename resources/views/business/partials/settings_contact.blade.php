<!--Purchase related settings -->
<div class="pos-tab-content">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                {!! Form::label('default_credit_limit',__('lang_v1.default_credit_limit') . ':') !!}
                {!! Form::text('common_settings[default_credit_limit]', $common_settings['default_credit_limit'] ?? '', ['class' => 'form-control input_number',
                'placeholder' => __('lang_v1.default_credit_limit'), 'id' => 'default_credit_limit']); !!}
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('customer_groups', 1, $business->customer_groups, ['class' => 'input-icheck']) !!} {{ __('lang_v1.customer_groups') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('import_contacts', 1, $business->import_contacts, ['class' => 'input-icheck']) !!} {{ __('lang_v1.import_contacts') }}
                    </label>
                </div>
            </div>
        </div>
        {{--  --}}
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('active_avance', 1, $business->active_avance, ['class' => 'input-icheck']) !!} {{ __('Active Avance') }}
                    </label>
                </div>
            </div>
        </div>
        {{--  --}}
    </div>
</div>