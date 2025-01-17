<div class="modal-dialog" role="document">
  <div class="modal-content">

    <?php echo Form::open(['url' => action('InvoiceSchemeController@store'), 'method' => 'post', 'id' => 'invoice_scheme_add_form' ]); ?>


    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title"><?php echo app('translator')->getFromJson( 'invoice.add_invoice' ); ?></h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="option-div-group">
          <div class="col-sm-4">
            <div class="form-group">
              <div class="option-div">
                <h4>FORMAT: <br>XXXX <i class="fa fa-check-circle pull-right icon"></i></h4>
                <?php echo Form::radio('scheme_type', 'blank');; ?>

              </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group">
              <div class="option-div">
                <h4>FORMAT: <br><?php echo e(date('Y')); ?>-XXXX <i class="fa fa-check-circle pull-right icon"></i></h4>
                <?php echo Form::radio('scheme_type', 'year');; ?>

              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="form-group">
            <label><?php echo app('translator')->getFromJson('invoice.preview'); ?>:</label>
            <div id="preview_format"><?php echo app('translator')->getFromJson('invoice.not_selected'); ?></div>
          </div>
        </div>
        <div class="col-sm-12">
          <div class="form-group">
            <?php echo Form::label('name', __( 'invoice.name' ) . ':*'); ?>

              <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'invoice.name' ) ]);; ?>

          </div>
        </div>
        <div id="invoice_format_settings" class="hide">
        <div class="col-sm-6">
          <div class="form-group">
            <?php echo Form::label('prefix', __( 'invoice.prefix' ) . ':'); ?>

            <div class="input-group col-md-12 col-sm-12">
              <span class="input-group-addon">
                  <i class="fa fa-info"></i>
              </span>
                <?php echo Form::text('prefix', null, ['class' => 'form-control', 'placeholder' => '']);; ?>

            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <?php echo Form::label('start_number', __( 'invoice.start_number' ) . ':'); ?>

            <div class="input-group col-md-12 col-sm-12">
              <span class="input-group-addon">
                  <i class="fa fa-info"></i>
              </span>
                <?php echo Form::number('start_number', 0, ['class' => 'form-control', 'required', 'min' => 0 ]);; ?>

            </div>
          </div>
        </div>
        <div class="clearfix">
        <div class="col-sm-6">
          <div class="form-group">
            <?php echo Form::label('total_digits', __( 'invoice.total_digits' ) . ':'); ?>

            <div class="input-group col-md-12 col-sm-12">
              <span class="input-group-addon">
                  <i class="fa fa-info"></i>
              </span>
              <?php echo Form::select('total_digits', ['4' => '4', '5' => '5', '6' => '6', '7' => '7', 
              '8' => '8', '9'=>'9', '10' => '10'], 4, ['class' => 'form-control', 'required']);; ?>

            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <br>
            <div class="checkbox">
              <label>
                <?php echo Form::checkbox('is_default', 1);; ?> <?php echo app('translator')->getFromJson('barcode.set_as_default'); ?></label>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson( 'messages.save' ); ?></button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->getFromJson( 'messages.close' ); ?></button>
    </div>

    <?php echo Form::close(); ?>


  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->