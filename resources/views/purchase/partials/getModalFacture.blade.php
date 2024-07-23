<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header" style="text-align: center;
                font-size: large;
                color: #2b88df;">
                 <b >Operation de Facturation</b>
            <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            
        </div>
        <form method="post" action="{{ route('purchases.postfacture', ['id' => $transaction->id]) }}"> <!-- Corrected the form action -->
            @csrf <!-- Add CSRF token for security -->
            @method('put')
            <div class="modal-body">
                <label for="facture_numero">Le numéro de facture :</label>
                <input type="number" class="form-control" id="facture_numero" name="facture_numero" value="">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                <button type="button" class="btn btn-default no-print" data-dismiss="modal">@lang('messages.close')</button>
            </div>
        </form>   
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
