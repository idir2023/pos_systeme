<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style="text-align: center;
                font-size: large;
                color: #2b88df;">
            <b >Operation de Facturation</b>
            <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form method="post" action="{{ route('sells.postfacture', ['id' => $transaction->id]) }}"> <!-- Corrected the form action -->
            @csrf <!-- Add CSRF token for security -->
            @method('put')
                <div class="modal-body">
                    <b style="text-align: center; font-size: 20px">@lang('messages.Factur_Number') : <span style="color: #FF0000;"> {{$transactionMax + 1 }}</span>
                    <input type="hidden" name="facture_numero" value="{{ $transactionMax + 1 }}"></b>
                </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                <button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang('messages.close')</button>
            </div>
        </form>   
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
