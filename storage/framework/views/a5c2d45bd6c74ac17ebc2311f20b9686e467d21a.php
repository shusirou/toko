<div class="payment_details_div <?php if( $payment_line->method !== 'card' ): ?> <?php echo e('hide'); ?> <?php endif; ?>" data-type="card" >
	<div class="col-md-4">
		<div class="form-group">
			<?php echo Form::label("card_number", 'Card No'); ?>

			<?php echo Form::text("card_number", $payment_line->card_number, ['class' => 'form-control', 'placeholder' => 'Card No']);; ?>

		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?php echo Form::label("card_holder_name", 'Card Holder Name'); ?>

			<?php echo Form::text("card_holder_name", $payment_line->card_holder_name, ['class' => 'form-control', 'placeholder' => 'Card Holder Name']);; ?>

		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<?php echo Form::label("card_transaction_number",'Card Transaction Number'); ?>

			<?php echo Form::text("card_transaction_number", $payment_line->card_transaction_number, ['class' => 'form-control', 'placeholder' => 'Card Transaction Number']);; ?>

		</div>
	</div>
	<div class="clearfix"></div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_type", 'Card Type'); ?>

			<?php echo Form::select("card_type", ['credit' => 'Credit Card', 'debit' => 'Debit Card', 'visa' => 'Visa', 'master' => 'MasterCard'], $payment_line->card_type,['class' => 'form-control select2']);; ?>

		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_month", 'Month'); ?>

			<?php echo Form::text("card_month", $payment_line->card_month, ['class' => 'form-control', 
			'placeholder' => 'Month' ]);; ?>

		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_year", 'Year'); ?>

			<?php echo Form::text("card_year", $payment_line->card_year, ['class' => 'form-control', 'placeholder' => 'Year' ]);; ?>

		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<?php echo Form::label("card_security",'Security Code'); ?>

			<?php echo Form::text("card_security", $payment_line->card_security, ['class' => 'form-control', 'placeholder' => 'Security Code']);; ?>

		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div class="payment_details_div <?php if( $payment_line->method !== 'cheque' ): ?> <?php echo e('hide'); ?> <?php endif; ?>" data-type="cheque" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("cheque_number",'Cheque No'); ?>

			<?php echo Form::text("cheque_number", $payment_line->cheque_number, ['class' => 'form-control', 'placeholder' => 'Check No']);; ?>

		</div>
	</div>
</div>
<div class="payment_details_div <?php if( $payment_line->method !== 'bank_transfer' ): ?> <?php echo e('hide'); ?> <?php endif; ?>" data-type="bank_transfer" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("bank_account_number",'Bank Account No'); ?>

			<?php echo Form::text( "bank_account_number", $payment_line->bank_account_number, ['class' => 'form-control', 'placeholder' => 'Bank Account No']);; ?>

		</div>
	</div>
</div>
<div class="payment_details_div <?php if( $payment_line->method !== 'custom_pay_1' ): ?> <?php echo e('hide'); ?> <?php endif; ?>" data-type="custom_pay_1" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("transaction_no_1", __('lang_v1.transaction_no')); ?>

			<?php echo Form::text("transaction_no_1", $payment_line->transaction_no, ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no')]);; ?>

		</div>
	</div>
</div>
<div class="payment_details_div <?php if( $payment_line->method !== 'custom_pay_2' ): ?> <?php echo e('hide'); ?> <?php endif; ?>" data-type="custom_pay_2" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("transaction_no_2", __('lang_v1.transaction_no')); ?>

			<?php echo Form::text("transaction_no_2", $payment_line->transaction_no, ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no')]);; ?>

		</div>
	</div>
</div>
<div class="payment_details_div <?php if( $payment_line->method !== 'custom_pay_3' ): ?> <?php echo e('hide'); ?> <?php endif; ?>" data-type="custom_pay_3" >
	<div class="col-md-12">
		<div class="form-group">
			<?php echo Form::label("transaction_no_3", __('lang_v1.transaction_no')); ?>

			<?php echo Form::text("transaction_no_3", $payment_line->transaction_no, ['class' => 'form-control', 'placeholder' => __('lang_v1.transaction_no')]);; ?>

		</div>
	</div>
</div>