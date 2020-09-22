<?php $__env->startSection('title', 'Pembayaran Piutang'); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Pembayaran Piutang
        <small>Kelola Pembayaran Piutang</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title">Kelola Pembayaran Piutang</h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('jurnal.create')): ?>
        	<div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                	data-href="<?php echo e(action('PembayaranPiutangController@create')); ?>" 
                	data-container=".jurnal_modal">
                	<i class="fa fa-plus"></i> Tambah</button>
            </div>
            <?php endif; ?>
        </div>
        <div class="box-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pembayaran_piutang.view')): ?>
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="pembayaran_piutang_table">
        		<thead>
        			<tr>
        				<th>Transaction Ref No</th>
                        <th>Payment Ref No</th>
                        <th>Transaction Date</th>
                        <th>Amount</th>
                        <th><?php echo app('translator')->getFromJson( 'messages.action' ); ?></th>
        			</tr>
        		</thead>
        	</table>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade pembayaran_piutang_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
    var pembayaran_hutang_table = $('#pembayaran_piutang_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '<?php echo e(action("PembayaranPiutangController@index")); ?>',
        columnDefs: [ {
            "targets": 2,
            "orderable": false,
            "searchable": false
        } ]
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>