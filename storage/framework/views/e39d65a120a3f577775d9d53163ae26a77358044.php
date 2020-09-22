<?php $__env->startSection('title', 'Tutup Buku'); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Laporan
        <small>Tutup Buku</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">

	<div class="box">
       <!--  <div class="box-header">
        	<h3 class="box-title">Kelola Jurnal Umum</h3>
        </div> -->
        <div class="box-body">
           <div class="row">
               <div class="col-md-4">
                   <form method="post" action="<?php echo e(url('do_tutup_buku')); ?>" onsubmit="return confirm('Anda ingin memproses data?')">
                   <?php echo e(csrf_field()); ?>

                   <div class="form-group">
                       <label>Tahunan</label>
                       <select class="form-control select2" name="tahunan" id="tahunan" required="">
                           <option value="">- pilih tahun</option>
                           <?php for($i=date('Y'); $i>=date('Y')-32; $i-=1):?>
                           <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                           <?php endfor ?>
                       </select>
                   </div>
                   <button type="submit" class="btn btn-primary">Tutup Buku</button>
                  </form>
               </div>
           </div>
           <div class="row">
             <div class="col-md-6">
               <h3>Aktiva</h3>
               <?php $__currentLoopData = $rekening_aktiva; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <h4><?php echo e($ra->nama_rr); ?></h4>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </div>
              <div class="col-md-6">
               <h3>Passiva</h3>
               <?php $__currentLoopData = $rekening_passiva; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <h4><?php echo e($rp->nama_rr); ?></h4>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             </div>
           </div>
           
           </div>
           <hr>
        </div>
    </div>
</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">  
<?php if(session('success')): ?>
    toastr.success('<?php echo session('success'); ?>');
<?php endif ?>
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>