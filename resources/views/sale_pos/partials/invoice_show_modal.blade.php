<!-- Edit Order tax Modal -->
<style type="text/css">
    .styleInvoice{
          width:800px !important;
        }
    @media (max-width: 767px) {
        .styleInvoice{
          width:auto !important;
        }
    }

</style>
<div class="modal-dialog styleInvoice" role="document" >
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   <div class="col-md-12 text-left mb-12">
                @if(!empty($payment_link))
                    <a href="{{$payment_link}}" class="btn btn-info no-print" style="margin-right: 20px;"><i class="fas fa-money-check-alt" title="@lang('lang_v1.pay')"></i> @lang('lang_v1.pay')
                    </a>
                @endif
                <button type="button" class="btn btn-primary no-print btn-sm print-invoice" aria-label="Print"><i class="fas fa-print"></i> @lang('messages.print')</button>
                @auth
                    <a href="{{action([\App\Http\Controllers\SellController::class, 'index'])}}" class="btn btn-success no-print btn-sm"><i class="fas fa-backward"></i></a>
                @endauth
            </div>
        </div>
        <div class="modal-body">
         
            <div class="row">
                <div class="col-md-12 col-sm-12" style="border: 1px solid #ccc;">
                    <div class="spacer"></div>
                    <div id="invoice_content">
                        {!! $receipt['html_content'] !!}
                    </div>
                    <div class="spacer"></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.close')</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script type="text/javascript">
    $(document).ready(function(){
        $('.print-invoice').click(function(){
            $('#invoice_content').printThis();
        });

        // Select and focus on input with ID invoice_url
        $('input#invoice_url').click(function(){
            $(this).select().focus();
        });
    });
</script>
