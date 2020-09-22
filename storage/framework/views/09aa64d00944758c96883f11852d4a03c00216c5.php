<div class="modal-dialog" role="document">
  <div class="modal-content">

    <?php echo Form::open(['url' => action('ExpenseCategoryController@store'), 'method' => 'post', 'id' => 'expense_category_add_form' ]); ?>

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title"><?php echo app('translator')->getFromJson( 'expense.add_expense_category' ); ?></h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        <?php echo Form::label('name', __( 'expense.category_name' ) . ':*'); ?>

          <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'expense.category_name' )]);; ?>

      </div>

      <div class="form-group">
        <?php echo Form::label('code', __( 'expense.category_code' ) . ':'); ?>

          <?php echo Form::text('code', null, ['class' => 'form-control', 'placeholder' => __( 'expense.category_code' )]);; ?>

      </div>

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

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson( 'messages.save' ); ?></button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->getFromJson( 'messages.close' ); ?></button>
    </div>

    <?php echo Form::close(); ?>


  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->