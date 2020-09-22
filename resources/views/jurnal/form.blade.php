<div class="modal-dialog" role="document">
  <div class="modal-content">
    {!! Form::open(['url' => action('JurnalController@store'), 'method' => 'post', 'id' => 'jurnal_add_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">Tambah Jurnal Umum</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        <label>Jenis Buku</label>
        <select class="form-control select2" name="jenisbuku" id="jenisbuku" required="">
            <option value="">- pilih jenis buku</option>
            @foreach($jenisbuku as $jb)
            <option value="{{$jb->kd_jb}}">{{$jb->kd_jb.' - '.$jb->nama_jb}}</option>
            @endforeach
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
         @foreach($hutang as $h)
         <option value="{{$h->id}}">{{$h->payment_ref_no}}</option>
         @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="transaction_date">Tanggal</label>
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </span>
          <input class="form-control" readonly="" required="" name="tanggaljurnal" type="text" value="{{date('m/d/Y')}}" id="tanggaljurnal">
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
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
