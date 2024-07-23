<div class="modal-dialog" role="document">
    <div class="modal-content">
  
     {!! Form::open(['url' => action([\App\Http\Controllers\TransactionPaymentController::class, 'updateChequeParent'], [$payment_line->id]), 'method' => 'put', 'id' => 'transaction_payment_add_form', 'files' => true ]) !!}
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">@lang( 'purchase.edit_payment' )</h4>
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
        <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
      </div>
  
      {!! Form::close() !!}

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->

  @if($payment_line->cheque_transfered_id)
  <button type="button" id="edit_payment" class="text-bold edit_payment hide" data-href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, 'edit3'], [$payment_line->cheque_transfered_id]) }}"></button>
 
  <script>
      $(document).ready(function() {
          $('#transaction_payment_add_form').on('submit', function(event) {
              event.preventDefault(); // Empêcher l'envoi du formulaire de manière traditionnelle
      
              // Envoyer les données via AJAX
              $.ajax({
                  url: $(this).attr('action'),
                  method: 'post',
                  data: $(this).serialize(), // Sérialiser les données pour l'envoi
                  success: function(response) {
                      $('#edit_payment').trigger('click');
                  }
              });
          });
      });
  </script>
@endif 