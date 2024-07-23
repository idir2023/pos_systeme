<div class="modal-dialog" role="document">
    <div class="modal-content">
  
     {!! Form::open(['url' => action([\App\Http\Controllers\TransactionPaymentController::class, 'updateChequeParentClient'], [$payment_line->id]), 'method' => 'put', 'id' => 'transaction_payment_add_form', 'files' => true ]) !!}
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="text-danger modal-title" style="text-align:center;">Régler la situation du client</h4>
      </div>
  
      <div class="modal-body">
        <div class="row">
    
        </div>
        <div class="row payment_row">
          <div class="clearfix"></div>
            @include('transaction_payment.payment_type_details')
        </div>
      </div>
  
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
        <button type="button" id="closeModal" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
      </div>
  
      {!! Form::close() !!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->

  <script>
    $(document).ready(function() {
        // Rafraîchir la page lorsque le bouton "Fermer" est cliqué
        $('#closeModal').on('click', function() {
            location.reload();
        });
    });
</script>