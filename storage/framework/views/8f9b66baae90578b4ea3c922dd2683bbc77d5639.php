<div class="box box-widget">
	<div class="box-header with-border">

	<?php if(!empty($categories)): ?>
		<select class="select2" id="product_category" style="width:45% !important">

			<option value="all"><?php echo app('translator')->getFromJson('lang_v1.all_category'); ?></option>

			<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<option value="<?php echo e($category['id']); ?>"><?php echo e($category['name']); ?></option>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(!empty($category['sub_categories'])): ?>
					<optgroup label="<?php echo e($category['name']); ?>">
						<?php $__currentLoopData = $category['sub_categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<i class="fa fa-minus"></i> <option value="<?php echo e($sc['id']); ?>"><?php echo e($sc['name']); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</optgroup>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</select>
	<?php endif; ?>

	<?php if(!empty($brands)): ?>
		&nbsp;
		<?php echo Form::select('size', $brands, null, ['id' => 'product_brand', 'class' => 'select2', 'name' => null, 'style' => 'width:45% !important']); ?>

		
	<?php endif; ?>

	

	<div class="box-tools pull-right">
		<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
	</div>

	<!-- /.box-tools -->
	</div>
	<!-- /.box-header -->

	<div class="box-body" id="product_list_body">
		
	</div>
	<!-- /.box-body -->
</div>