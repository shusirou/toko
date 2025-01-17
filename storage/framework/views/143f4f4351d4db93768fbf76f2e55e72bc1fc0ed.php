<!-- Edit Shipping Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="posShippingModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><?php echo app('translator')->getFromJson('sale.shipping'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
				        <div class="form-group">
				            <?php echo Form::label('shipping_details_modal', __('sale.shipping_details') . ':*' ); ?>

				            <?php echo Form::textarea('shipping_details_modal',$shipping_details, ['class' => 'form-control','placeholder' => __('sale.shipping_details'), 'required' ,'rows' => '4']);; ?>

				        </div>
				    </div>

				    <div class="col-md-6">
				        <div class="form-group">
				            <?php echo Form::label('shipping_charges_modal', __('sale.shipping_charges') . ':*' ); ?>

				            <div class="input-group">
				                <span class="input-group-addon">
				                    <i class="fa fa-info"></i>
				                </span>
				                <?php echo Form::text('shipping_charges_modal', number_format($shipping_charges, 2, session('currency')['decimal_separator'], session('currency')['thousand_separator']), ['class' => 'form-control input_number','placeholder' => __('sale.shipping_charges')]);; ?>

				            </div>
				        </div>
				    </div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="posShippingModalUpdate"><?php echo app('translator')->getFromJson('messages.update'); ?></button>
			    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->getFromJson('messages.cancel'); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->