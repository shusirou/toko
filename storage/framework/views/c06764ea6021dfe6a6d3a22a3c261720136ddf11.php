<?php $__env->startSection('title', __('purchase.purchases')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header no-print">
    <h1><?php echo app('translator')->getFromJson('purchase.purchases'); ?>
        <small></small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content no-print">

	<div class="box">
        <div class="box-header">
        	<h3 class="box-title"><?php echo app('translator')->getFromJson('purchase.all_purchases'); ?></h3>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase.create')): ?>
            	<div class="box-tools">
                    <a class="btn btn-block btn-primary" href="<?php echo e(action('PurchaseController@create')); ?>">
    				<i class="fa fa-plus"></i> <?php echo app('translator')->getFromJson('messages.add'); ?></a>
                </div>
            <?php endif; ?>
        </div>
        <div class="box-body">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('purchase.view')): ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group">
                              <button type="button" class="btn btn-primary" id="daterange-btn">
                                <span>
                                  <i class="fa fa-calendar"></i> <?php echo e(__('messages.filter_by_date')); ?>

                                </span>
                                <i class="fa fa-caret-down"></i>
                              </button>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="table-responsive">
            	<table class="table table-bordered table-striped ajax_view" id="purchase_table">
            		<thead>
            			<tr>
            				<th><?php echo app('translator')->getFromJson('messages.date'); ?></th>
    						<th><?php echo app('translator')->getFromJson('purchase.ref_no'); ?></th>
                            <th><?php echo app('translator')->getFromJson('purchase.location'); ?></th>
    						<th><?php echo app('translator')->getFromJson('purchase.supplier'); ?></th>
            				<th><?php echo app('translator')->getFromJson('purchase.purchase_status'); ?></th>
                            <th><?php echo app('translator')->getFromJson('purchase.payment_status'); ?></th>
    						<th><?php echo app('translator')->getFromJson('purchase.grand_total'); ?></th>
                            <th><?php echo app('translator')->getFromJson('purchase.payment_due'); ?> &nbsp;&nbsp;<i class="fa fa-info-circle text-info" data-toggle="tooltip" data-placement="bottom" data-html="true" data-original-title="<?php echo e(__('messages.purchase_due_tooltip')); ?>" aria-hidden="true"></i></th>
    						<th><?php echo app('translator')->getFromJson('messages.action'); ?></th>
            			</tr>
            		</thead>
                    <tfoot>
                        <tr class="bg-gray font-17 text-center footer-total">
                            <td colspan="4"><strong><?php echo app('translator')->getFromJson('sale.total'); ?>:</strong></td>
                            <td id="footer_status_count"></td>
                            <td id="footer_payment_status_count"></td>
                            <td><span class="display_currency" id="footer_purchase_total" data-currency_symbol ="true"></span></td>
                            <td><span class="display_currency" id="footer_total_due" data-currency_symbol ="true"></span></td>
                            <td></td>
                        </tr>
                    </tfoot>
            	</table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade product_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade payment_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

</section>

<section id="receipt_section" class="print_section"></section>

<!-- /.content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(asset('js/purchase.js?v=' . $asset_v)); ?>"></script>
<script src="<?php echo e(asset('js/payment.js?v=' . $asset_v)); ?>"></script>
<script>
    $(document).ready(function(){
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            dateRangeSettings,
            function (start, end) {
                $('#daterange-btn span').html(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                purchase_table.ajax.reload();
            }
            /*function (start, end) {
                $('#daterange-btn span').html(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                purchase_table.ajax.url( '/purchases?start_date=' + moment() +
                    '&end_date=' + moment() ).load();
            }*/
        );
        /*$('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
            purchase_table.ajax.url( '/purchases').load();
            $('#daterange-btn span').html('<i class="fa fa-calendar"></i> <?php echo e(__("messages.filter_by_date")); ?>');
        });*/
         $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
            $('#daterange-btn').html('<i class="fa fa-calendar"></i> <?php echo e(__("messages.filter_by_date")); ?>');
            purchase_table.ajax.reload();
        });

        //Purchase table
        purchase_table = $('#purchase_table').DataTable({
            processing: true,
            serverSide: true,
            aaSorting: [[0, 'desc']],
            "ajax": {
                "url": "/purchases",
                "data": function ( d ) {
                    var start = $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var end = $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    d.start_date = start;
                    d.end_date = end;
                    d.is_direct_sale = 1;
                }
            },
            columnDefs: [ {
                "targets": [7,8],
                "orderable": false,
                "searchable": false
            } ],
            columns: [
                { data: 'transaction_date', name: 'transaction_date'  },
                { data: 'ref_no', name: 'ref_no'},
                { data: 'location_name', name: 'BS.name'},
                { data: 'name', name: 'contacts.name'},
                { data: 'status', name: 'status'},
                { data: 'payment_status', name: 'payment_status'},
                { data: 'final_total', name: 'final_total'},
                { data: 'payment_due', name: 'payment_due'},
                { data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function (oSettings) {
                var total_purchase = sum_table_col($('#purchase_table'), 'final_total');
                $('#footer_purchase_total').text(total_purchase);

                var total_due = sum_table_col($('#purchase_table'), 'payment_due');
                $('#footer_total_due').text(total_due);

                $('#footer_status_count').html(__sum_status_html($('#purchase_table'), 'status-label'));
                
                $('#footer_payment_status_count').html(__sum_status_html($('#purchase_table'), 'payment-status-label'));
                
                __currency_convert_recursively($('#purchase_table'));
            },
            createdRow: function( row, data, dataIndex ) {
                $( row ).find('td:eq(5)').attr('class', 'clickable_td');
            }
        });
    })
   

</script>
	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>