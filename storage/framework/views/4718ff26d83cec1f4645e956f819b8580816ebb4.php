<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close no-print" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h3 class="modal-title"><?php echo app('translator')->getFromJson( 'cash_register.register_details' ); ?> ( <?php echo e(\Carbon::createFromFormat('Y-m-d H:i:s', $register_details->open_time)->format('jS M, Y h:i A')); ?> - <?php echo e(\Carbon::now()->format('jS M, Y h:i A')); ?>)</h3>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">
          <table class="table">
            <tr>
              <td>
                <?php echo app('translator')->getFromJson('cash_register.cash_in_hand'); ?>:
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->cash_in_hand); ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo app('translator')->getFromJson('cash_register.cash_payment'); ?>:
              </th>
              <td>
                <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_cash); ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo app('translator')->getFromJson('cash_register.checque_payment'); ?>:
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_cheque); ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo app('translator')->getFromJson('cash_register.card_payment'); ?>:
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_card); ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo app('translator')->getFromJson('cash_register.bank_transfer'); ?>:
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_bank_transfer); ?></span>
              </td>
            </tr>
            <?php if(config('constants.enable_custom_payment_1')): ?>
              <tr>
                <td>
                  <?php echo app('translator')->getFromJson('lang_v1.custom_payment_1'); ?>:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_custom_pay_1); ?></span>
                </td>
              </tr>
            <?php endif; ?>
            <?php if(config('constants.enable_custom_payment_2')): ?>
              <tr>
                <td>
                  <?php echo app('translator')->getFromJson('lang_v1.custom_payment_2'); ?>:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_custom_pay_2); ?></span>
                </td>
              </tr>
            <?php endif; ?>
            <?php if(config('constants.enable_custom_payment_3')): ?>
              <tr>
                <td>
                  <?php echo app('translator')->getFromJson('lang_v1.custom_payment_3'); ?>:
                </td>
                <td>
                  <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_custom_pay_3); ?></span>
                </td>
              </tr>
            <?php endif; ?>
            <tr>
              <td>
                <?php echo app('translator')->getFromJson('cash_register.other_payments'); ?>:
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_other); ?></span>
              </td>
            </tr>
            <tr>
              <td>
                <?php echo app('translator')->getFromJson('cash_register.total_sales'); ?>:
              </td>
              <td>
                <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_sale); ?></span>
              </td>
            </tr>
            <tr class="success">
              <th>
                <?php echo app('translator')->getFromJson('cash_register.total_refund'); ?>
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_refund); ?></span></b><br>
                <small>
                <?php if($register_details->total_cash_refund != 0): ?>
                  Cash: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_cash_refund); ?></span><br>
                <?php endif; ?>
                <?php if($register_details->total_cheque_refund != 0): ?> 
                  Cheque: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_cheque_refund); ?></span><br>
                <?php endif; ?>
                <?php if($register_details->total_card_refund != 0): ?> 
                  Card: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_card_refund); ?></span><br> 
                <?php endif; ?>
                <?php if($register_details->total_bank_transfer_refund != 0): ?>
                  Bank Transfer: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_bank_transfer_refund); ?></span><br>
                <?php endif; ?>
                <?php if(config('constants.enable_custom_payment_1') && $register_details->total_custom_pay_1_refund != 0): ?>
                    <?php echo app('translator')->getFromJson('lang_v1.custom_payment_1'); ?>: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_custom_pay_1_refund); ?></span>
                <?php endif; ?>
                <?php if(config('constants.enable_custom_payment_2') && $register_details->total_custom_pay_2_refund != 0): ?>
                    <?php echo app('translator')->getFromJson('lang_v1.custom_payment_2'); ?>: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_custom_pay_2_refund); ?></span>
                <?php endif; ?>
                <?php if(config('constants.enable_custom_payment_3') && $register_details->total_custom_pay_3_refund != 0): ?>
                    <?php echo app('translator')->getFromJson('lang_v1.custom_payment_3'); ?>: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_custom_pay_3_refund); ?></span>
                <?php endif; ?>
                <?php if($register_details->total_other_refund != 0): ?>
                  Other: <span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->total_other_refund); ?></span>
                <?php endif; ?>
                </small>
              </td>
            </tr>
            <tr class="success">
              <th>
                <?php echo app('translator')->getFromJson('cash_register.total_cash'); ?>
              </th>
              <td>
                <b><span class="display_currency" data-currency_symbol="true"><?php echo e($register_details->cash_in_hand + $register_details->total_cash - $register_details->total_cash_refund); ?></span></b>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <?php echo $__env->make('cash_register.register_product_details', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      
      <div class="row">
        <div class="col-sm-12">
          <b><?php echo app('translator')->getFromJson('report.user'); ?>:</b> <?php echo e($register_details->user_name); ?><br>
          <b>Email:</b> <?php echo e($register_details->email); ?>

        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-primary no-print" 
        aria-label="Print" 
          onclick="$(this).closest('div.modal').printThis();">
        <i class="fa fa-print"></i> <?php echo app('translator')->getFromJson( 'messages.print' ); ?>
      </button>

      <button type="button" class="btn btn-default no-print" 
        data-dismiss="modal"><?php echo app('translator')->getFromJson( 'messages.cancel' ); ?>
      </button>
    </div>

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->