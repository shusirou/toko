<div class="modal-dialog" role="document">
  <div class="modal-content">
    <?php echo Form::open(['url' => action('JurnalController@store'), 'method' => 'post', 'id' => 'jurnal_add_form' ]); ?>

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Tambah Jurnal Umum</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        <label>Jenis Buku</label>
        <select class="form-control select2" name="jenisbuku" id="jenisbuku" required="">
            <option value="">- pilih jenis buku</option>
            <?php $__currentLoopData = $jenisbuku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($jb->kd_jb); ?>"><?php echo e($jb->kd_jb.' - '.$jb->nama_jb); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="form-group">
        <label>Nama Rekening</label>
        <select class="form-control" name="namarekening" id="namarekening" required="">
          <option value="">- pilih jenis buku terlebih dahulu</option>
        </select>
      </div>
      <div class="form-group">
        <label>Nama Rekening Pasangan</label>
        <select class="form-control select2" name="namarekeningpasangan" id="namarekeningpasangan" readonly="" required="">
          <option value="">- pilih jenis buku terlebih dahulu</option>
        </select>
      </div>
      <div class="form-group">
        <label>Jenis Mutasi</label>
        <select class="form-control select2" name="jenismutasi" id="jenismutasi">
          <option value="debit">Debit</option>
          <option value="kredit">Kredit</option>
        </select>
      </div>
      <div class="form-group  hutangdiv">
        <label>Ref Hutang</label>
        <select class="form-control select2" name="refhutang" id="refhutang">
         <option value="">- pilih ref hutang terlebih dahulu</option> 
         <?php $__currentLoopData = $hutang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <option value="<?php echo e($h->id); ?>"><?php echo e($h->payment_ref_no); ?></option>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
      <div class="form-group">
        <label for="transaction_date">Tanggal</label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          <input class="form-control" readonly="" required="" name="tanggaljurnal" type="text" value="<?php echo e(date('m/d/Y')); ?>" id="tanggaljurnal">
        </div>
      </div>
      <div class="form-group">
        <label>Keterangan</label>
        <textarea class="form-control" style="min-height: 120px;" name="keterangan" id="keterangan"></textarea>
      </div>
      <div class="form-group">
        <label>Nominal</label>
        <input class="form-control input_number" required="" name="nominal" type="text" value="0" id="nominal">
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson( 'messages.save' ); ?></button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->getFromJson( 'messages.close' ); ?></button>
    </div>

    <?php echo Form::close(); ?>


  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
