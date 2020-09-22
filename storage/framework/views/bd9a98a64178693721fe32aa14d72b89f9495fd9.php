<?php $__env->startSection('title', 'Pembayaran Hutang'); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Pembayaran Hutang
        <small>Form Pembayaran Hutang</small>
    </h1>
    <!-- <ol class="bre adcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
  
	<div class="box">
    <?php echo Form::open(['url' => action('PembayaranHutangController@store'), 'method' => 'post', 'id' => 'pembayaran_hutang_form' ]); ?>

       <div class="box-header">
          <h3 class="box-title">Form Pembayaran Hutang</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
               <div class="form-group">
                   <label>Tanggal Hutang</label><br>
                   <p><?php echo e($tp->transaction_date); ?></p>
                   <input type="hidden" name="id_payment" id="id_payment" value="<?php echo e($tp->id); ?>">
               </div>
               <div class="form-group">
                   <label>Payment Ref No</label><br>
                   <p><?php echo e($tp->payment_ref_no); ?></p>
                   <input type="hidden" name="payment_ref_no" id="payment_ref_no" value="<?php echo e($tp->payment_ref_no); ?>">
               </div>
               <div class="form-group">
                   <label>Jumlah Hutang</label><br>
                   <p>Rp <?php echo e(number_format($tp->amount)); ?></p>
                   <input type="hidden" name="jumlah_hutang" id="jumlah_hutang" value="<?php echo e($tp->amount); ?>">
               </div>
               <div class="form-group">
                   <label>Sisa Hutang</label><br>
                   <p>Rp <?php echo e(number_format($tp->amount - $terbayar->terbayar)); ?></p>
                   <input type="hidden" name="sisa_hutang" id="sisa_hutang" value="<?php echo e($tp->amount - $terbayar->terbayar); ?>">
               </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Cara Bayar</label>
                <select class="form-control" name="cara_bayar">
                  <option value="kas">Kas</option>
                  <option value="bank">Bank</option>
                </select>
              </div>
              <div class="form-group">
                <label>Nomor Rekening</label>
                <input type="text" class="form-control" placeholder="isikan jika cara bayar bank" name="no_rekening" id="no_rekening">
              </div>
              <div class="form-group">
                <label>Atas Rekening</label>
                <input type="text" class="form-control" placeholder="isikan jika cara bayar bank" name="atas_nama_rekening" id="atas_rekening">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
               <label for="transaction_date">Tanggal Bayar</label>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </span>
                  <input class="form-control" required="" name="tgl_bayar" type="text" value="<?php echo e(date('m/d/Y')); ?>" id="tgl_bayar" required="">
                </div>
              </div>
              <div class="form-group">
                <label>Jumlah Bayar</label>
                <input type="number" class="form-control" name="jumlah_bayar" id="jumlah_bayar" required="">
              </div>
              <hr>
              <div class="form-group">
                <a class="btn btn-success" href="<?php echo e(url('pembayaran_hutang')); ?>" type="button">Kembali</a>
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </div>
          </div>
        </div>
    <?php echo Form::close();; ?>

        <table class="table table-bordered table-striped">
          <thead style="background-color: #eee;">
            <tr>
              <th width="10">No</th>
              <th>Tanggal Bayar</th>
              <th>No Rekening</th>
              <th>An. Rekening</th>
              <th>Nominal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $ttl = 0; ?>
            <?php $__currentLoopData = $utangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($loop->iteration); ?></td>
              <td><?php echo e($ut->tgl_bayar->format('d F Y')); ?></td>
              <td><?php echo e($ut->no_rekening); ?></td>
              <td><?php echo e($ut->atas_nama_rekening); ?></td>
              <td align="right">Rp <?php echo e(number_format($ut->nominal)); ?></td>
              <td><a href="<?php echo e(route('hapus_pembayaran_hutang',['id'=>$ut->id,'payment_id'=>$ut->id_payment])); ?>"><i class="fa fa-trash"></i></a></td>
            </tr>
            <?php $ttl += $ut->nominal ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td colspan="4" align="right">Total</td>
              <td align="right">Rp <?php echo e(number_format($ttl)); ?></td>
            </tr>
          </tbody>
        </table>
    </div>
</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
  <?php if(session('success')): ?>
        toastr.success('<?php echo session('success'); ?>');
    <?php endif ?>
  $(function(){
    $('#tgl_bayar').datepicker({autoclose:true});

    $('#jumlah_bayar').on('keyup',function(){
  
        if(eval($('#jumlah_bayar').val()) > eval(eval($('#sisa_hutang').val()))){
           toastr.error('Jumlah bayar melebihi jumlah hutang!');
           $('#jumlah_bayar').val('');

           return;
        }
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>