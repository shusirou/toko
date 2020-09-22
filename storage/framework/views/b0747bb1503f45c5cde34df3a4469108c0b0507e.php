<?php $__env->startSection('title', 'Jurnal Umum'); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Jurnal Umum
        <small>Kelola Jurnal Umum</small>
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
        	<h3 class="box-title">Kelola Jurnal Umum</h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('jurnal.create')): ?>
        	<div class="box-tools">
                <button type="button" class="btn btn-block btn-primary btn-modal" 
                	data-href="<?php echo e(action('JurnalController@create')); ?>" 
                	data-container=".jurnal_modal">
                	<i class="fa fa-plus"></i> Tambah</button>
            </div>
            <?php endif; ?>
        </div>
        <div class="box-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('jurnal.view')): ?>
            <div class="table-responsive">
        	<table class="table table-bordered table-striped" id="jurnal_table">
        		<thead>
        			<tr>
        				<th>Jenis Buku</th>
        				<th>Rekening Debit</th>
                        <th>Rekening Kredit</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th><?php echo app('translator')->getFromJson( 'messages.action' ); ?></th>
        			</tr>
        		</thead>
        	</table>
            </div>
           <?php endif; ?>
        </div>
    </div>

    <div class="modal fade jurnal_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
    $(function(){
        $('.jurnal_modal').on('shown.bs.modal', function (e) {
            $('.select2').select2();
            $('.jurnal_modal .hutangdiv').hide();
            if($('#jenisbuku').val() == '211' || $('#jenisbuku').val() == '212' || $('#jenisbuku').val() == '213'){
                $('.jurnal_modal .hutangdiv').show();
            }else{
                $('.jurnal_modal .hutangdiv').hide();
            }
            $('.jurnal_modal #tanggaljurnal').datepicker({autoclose:true});
            $('.jurnal_modal #jenisbuku').on('change',function(e){
               getRekening($(this).val());
            });
            $('.jurnal_modal #namarekening').on('change',function(e){
               getPasangan($(this).find(":selected").data("pasangan"));
            });
            
            $('.jurnal_modal #refhutang').on('change',function(e){
               getHutang($(this).val());
            });
        }); 
    });
    var jurnal_table = $('#jurnal_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '<?php echo e(action("JurnalController@index")); ?>',
                    columnDefs: [ {
                        "targets": 2,
                        "orderable": false,
                        "searchable": false
                    } ]
                });
    $(document).on('click', 'button.edit_jurnal_button', function(){

        $( "div.jurnal_modal" ).load( $(this).data('href'), function(){

            $(this).modal('show');
           
            getRekening($('#jurnal_edit_form #jenisbuku').val(),$('#jurnal_edit_form #kd_rekening').val());
            
            getPasangan($('#jurnal_edit_form #kd_rekening_pasangan').val());

            $('form#jurnal_edit_form').submit(function(e){
                e.preventDefault();
                var data = $(this).serialize();

                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    success: function(result){
                        if(result.success === true){
                            $('div.jurnal_modal').modal('hide');
                            toastr.success(result.msg);
                            jurnal_table.ajax.reload();
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            });
        });
    });

    function getRekening(id,kd_rekening=null){
         if($('#jenisbuku').val() == '211' || $('#jenisbuku').val() == '212' || $('#jenisbuku').val() == '213'){
                $('.jurnal_modal .hutangdiv').show();
            }else{
                $('.jurnal_modal .hutangdiv').hide();
            }
        $.ajax({
            type:'GET',
            url : '<?php echo e(route("jurnal.get_rekening",["id"=>null])); ?>/'+id,
            data:null,
            dataType:'json',
            success:function(i){

                var html = '';
                    html += '<option value="">- pilih rekening terlebih dahulu</option>';
                $.each(i.rekening,function(k,v){
                    if(kd_rekening !=null){
                        if(kd_rekening == v.kd_rekening){

                            html += '<option value="'+v.kd_rekening+'" selected="" data-pasangan="'+v.pasangan+'">'+v.kd_rekening+' - '+v.nama_rekening+'</option>';
                        }else{

                            html += '<option value="'+v.kd_rekening+'" data-pasangan="'+v.pasangan+'">'+v.kd_rekening+' - '+v.nama_rekening+'</option>';
                        }
                    }else{
                        html += '<option value="'+v.kd_rekening+'" data-pasangan="'+v.pasangan+'">'+v.kd_rekening+' - '+v.nama_rekening+'</option>';
                    }
                });
                $('.jurnal_modal #namarekening').html(html);
            }
       });
    }

    function getPasangan(id){
        
        $.ajax({
            type:'GET',
            url : '<?php echo e(route("jurnal.get_pasangan",["id"=>null])); ?>/'+id,
            data:null,
            dataType:'json',
            success:function(i){
               html = '<option value="'+i.pasangan.kd_rekening+'">'+i.pasangan.kd_rekening+' - '+i.pasangan.nama_rekening+'</option>';
                $('.jurnal_modal #namarekeningpasangan').html(html);
                //dibalik karena berlawanan dengan kd rekening
                if(i.pasangan.jenis_mutasi == 'kredit'){
                    html2 = '<option value="debit">Debit</option>';
                }else{
                    html2 = '<option value="kredit">Kredit</option>';
                }
               
                $('.jurnal_modal #jenismutasi').html(html2);
            }
       });
    }

    function getHutang(id){
        
        $.ajax({
            type:'GET',
            url : '<?php echo e(route("jurnal.get_hutang",["id"=>null])); ?>/'+id,
            data:null,
            dataType:'json',
            success:function(i){
               $('.jurnal_modal #nominal').val(i.tp);
            }
       });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>