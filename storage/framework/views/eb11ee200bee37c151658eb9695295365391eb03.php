<?php $__env->startSection('title', __('expense.add_expense')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo app('translator')->getFromJson('expense.add_expense'); ?></h1>
</section>

<!-- Main content -->
<section class="content">
	<?php echo Form::open(['url' => action('ExpenseController@store'), 'method' => 'post', 'id' => 'add_expense_form', 'files' => true ]); ?>

	<div class="box box-solid">
		<div class="box-body">
			<div class="row">

				<?php if(count($business_locations) == 1): ?>
					<?php 
						$default_location = current(array_keys($business_locations->toArray())) 
					?>
				<?php else: ?>
					<?php $default_location = null; ?>
				<?php endif; ?>
				<div class="col-sm-4">
					<div class="form-group">
						<?php echo Form::label('location_id', __('purchase.business_location').':*'); ?>

						<?php echo Form::select('location_id', $business_locations, $default_location, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']);; ?>

					</div>
				</div>

				<div class="col-sm-4">
					<div class="form-group">
						<?php echo Form::label('expense_category_id', __('expense.expense_category').':'); ?>

						<?php echo Form::select('expense_category_id', $expense_categories, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]);; ?>

					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<?php echo Form::label('ref_no', __('purchase.ref_no').':'); ?>

						<?php echo Form::text('ref_no', null, ['class' => 'form-control']);; ?>

					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<?php echo Form::label('transaction_date', __('messages.date') . ':*'); ?>

						<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
							<?php echo Form::text('transaction_date', \Carbon::createFromTimestamp(strtotime('now'))->format(session('business.date_format')), ['class' => 'form-control', 'readonly', 'required', 'id' => 'expense_transaction_date']);; ?>

						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<?php echo Form::label('final_total', __('sale.total_amount') . ':*'); ?>

						<?php echo Form::text('final_total', null, ['class' => 'form-control input_number', 'placeholder' => __('sale.total_amount'), 'required']);; ?>

					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<?php echo Form::label('expense_for', __('expense.expense_for').':'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto" 
                    data-content="' . __('tooltip.expense_for') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
						<?php echo Form::select('expense_for', $users, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select')]);; ?>

					</div>
				</div>
				<div class="col-sm-4">
                    <div class="form-group">
                        <?php echo Form::label('document', __('purchase.attach_document') . ':'); ?>

                        <?php echo Form::file('document', ['id' => 'upload_document']);; ?>

                        <p class="help-block"><?php echo app('translator')->getFromJson('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]); ?></p>
                    </div>
                </div>
				<div class="col-sm-4">
					<div class="form-group">
						<?php echo Form::label('additional_notes', __('expense.expense_note') . ':'); ?>

								<?php echo Form::textarea('additional_notes', null, ['class' => 'form-control', 'rows' => 3]);; ?>

					</div>
				</div>
				<div class="col-sm-4">
					 <div class="form-group">
				        <label>Rekening</label>
				        <select class="form-control" id="rekening" name="rekening" required="">
				          <option>- pilih rekening biaya</option>
				          <?php $__currentLoopData = $rekening; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				          <option value="<?php echo e($rk->kd_rekening); ?>"><?php echo e($rk->kd_rekening.' - '.$rk->nama_rekening); ?></option>
				          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				        </select>  
				      </div>
				</div>
				<div class="col-sm-12">
					<button type="submit" class="btn btn-primary pull-right"><?php echo app('translator')->getFromJson('messages.save'); ?></button>
				</div>
			</div>
		</div>
	</div> <!--box end-->

<?php echo Form::close(); ?>

</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>