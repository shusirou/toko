<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    <?php echo Form::open(['url' => action('ContactController@update', [$contact->id]), 'method' => 'PUT', 'id' => 'contact_edit_form']); ?>


    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title"><?php echo app('translator')->getFromJson('contact.edit_contact'); ?></h4>
    </div>

    <div class="modal-body">

      <div class="row">

        <div class="col-md-6">
          <div class="form-group">
              <?php echo Form::label('type', __('contact.contact_type') . ':*' ); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  <?php echo Form::select('type', $types, $contact->type, ['class' => 'form-control', 'id' => 'contact_type','placeholder' => __('messages.please_select'), 'required']);; ?>

              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <?php echo Form::label('name', __('contact.name') . ':*'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-user"></i>
                  </span>
                  <?php echo Form::text('name', $contact->name, ['class' => 'form-control','placeholder' => __('contact.name'), 'required']);; ?>

              </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 supplier_fields">
          <div class="form-group">
              <?php echo Form::label('supplier_business_name', __('business.business_name') . ':*'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-briefcase"></i>
                  </span>
                  <?php echo Form::text('supplier_business_name', 
                  $contact->supplier_business_name, ['class' => 'form-control', 'required', 'placeholder' => __('business.business_name')]);; ?>

              </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <?php echo Form::label('contact_id', __('lang_v1.contact_id') . ':'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-id-badge"></i>
                  </span>
                  <input type="hidden" id="hidden_id" value="<?php echo e($contact->id); ?>">
                  <?php echo Form::text('contact_id', $contact->contact_id, ['class' => 'form-control','placeholder' => __('lang_v1.contact_id')]);; ?>

              </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <?php echo Form::label('tax_number', __('contact.tax_no') . ':'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-info"></i>
                  </span>
                  <?php echo Form::text('tax_number', $contact->tax_number, ['class' => 'form-control', 'placeholder' => __('contact.tax_no')]);; ?>

              </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
              <?php echo Form::label('opening_balance', __('lang_v1.opening_balance') . ':'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-money"></i>
                  </span>
                  <?php echo Form::text('opening_balance', $opening_balance, ['class' => 'form-control input_number']);; ?>

              </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <div class="multi-input">
              <?php echo Form::label('pay_term_number', __('contact.pay_term') . ':'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto" 
                    data-content="' . __('tooltip.pay_term') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?>
              <br/>
              <?php echo Form::number('pay_term_number', $contact->pay_term_number, ['class' => 'form-control width-40 pull-left', 'placeholder' => __('contact.pay_term')]);; ?>


              <?php echo Form::select('pay_term_type', ['months' => __('lang_v1.months'), 'days' => __('lang_v1.days')], $contact->pay_term_type, ['class' => 'form-control width-60 pull-left','placeholder' => __('messages.please_select')]);; ?>

            </div>
          </div>
        </div>
        
       <!--  <div class="col-md-4 customer_fields">
          <div class="form-group">
              <?php echo Form::label('customer_group_id', __('lang_v1.customer_group') . ':'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-users"></i>
                  </span>
                  <?php echo Form::select('customer_group_id', $customer_groups, $contact->customer_group_id, ['class' => 'form-control']);; ?>

              </div>
          </div>
        </div> -->
         <div class="col-md-4 customer_fields">
          <div class="form-group">
              <?php echo Form::label('price_group_id', __('lang_v1.price_group') . ':'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-users"></i>
                  </span>
                  <?php echo Form::select('selling_price_group_id', $price_groups, $contact->selling_price_group_id, ['class' => 'form-control']);; ?>

              </div>
          </div>
        </div>
        <div class="col-md-4 customer_fields">
          <div class="form-group">
              <?php echo Form::label('credit_limit', __('lang_v1.credit_limit') . ':'); ?>

              <div class="input-group">
                  <span class="input-group-addon">
                      <i class="fa fa-money"></i>
                  </span>
                  <?php echo Form::text('credit_limit', $contact->credit_limit, ['class' => 'form-control input_number']);; ?>

              </div>
              <p class="help-block"><?php echo app('translator')->getFromJson('lang_v1.credit_limit_help'); ?></p>
          </div>
        </div>
      <div class="col-md-12">
        <hr/>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('email', __('business.email') . ':'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                <?php echo Form::email('email', $contact->email, ['class' => 'form-control','placeholder' => __('business.email')]);; ?>

            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('mobile', __('contact.mobile') . ':*'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-mobile"></i>
                </span>
                <?php echo Form::text('mobile', $contact->mobile, ['class' => 'form-control', 'required', 'placeholder' => __('contact.mobile')]);; ?>

            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('alternate_number', __('contact.alternate_contact_number') . ':'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                <?php echo Form::text('alternate_number', $contact->alternate_number, ['class' => 'form-control', 'placeholder' => __('contact.alternate_contact_number')]);; ?>

            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('landline', __('contact.landline') . ':'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-phone"></i>
                </span>
                <?php echo Form::text('landline', $contact->landline, ['class' => 'form-control', 'placeholder' => __('contact.landline')]);; ?>

            </div>
        </div>
      </div>
      <div class="clearfix"></div>

      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('city', __('business.city') . ':'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                <?php echo Form::text('city', $contact->city, ['class' => 'form-control', 'placeholder' => __('business.city')]);; ?>

            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('state', __('business.state') . ':'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                <?php echo Form::text('state', $contact->state, ['class' => 'form-control', 'placeholder' => __('business.state')]);; ?>

            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('country', __('business.country') . ':'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-globe"></i>
                </span>
                <?php echo Form::text('country', $contact->country, ['class' => 'form-control', 'placeholder' => __('business.country')]);; ?>

            </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('landmark', __('business.landmark') . ':'); ?>

            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-map-marker"></i>
                </span>
                <?php echo Form::text('landmark', $contact->landmark, ['class' => 'form-control', 'placeholder' => __('business.landmark')]);; ?>

            </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12">
        <hr/>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('custom_field1', __('lang_v1.custom_field', ['number' => 1]) . ':'); ?>

            <?php echo Form::text('custom_field1', $contact->custom_field1, ['class' => 'form-control', 
                'placeholder' => __('lang_v1.custom_field', ['number' => 1])]);; ?>

        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('custom_field2', __('lang_v1.custom_field', ['number' => 2]) . ':'); ?>

            <?php echo Form::text('custom_field2', $contact->custom_field2, ['class' => 'form-control', 
                'placeholder' => __('lang_v1.custom_field', ['number' => 2])]);; ?>

        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('custom_field3', __('lang_v1.custom_field', ['number' => 3]) . ':'); ?>

            <?php echo Form::text('custom_field3', $contact->custom_field3, ['class' => 'form-control', 
                'placeholder' => __('lang_v1.custom_field', ['number' => 3])]);; ?>

        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
            <?php echo Form::label('custom_field4', __('lang_v1.custom_field', ['number' => 4]) . ':'); ?>

            <?php echo Form::text('custom_field4', $contact->custom_field4, ['class' => 'form-control', 
                'placeholder' => __('lang_v1.custom_field', ['number' => 4])]);; ?>

        </div>
      </div>
      <div class="clearfix"></div>

    </div>

    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary"><?php echo app('translator')->getFromJson( 'messages.update' ); ?></button>
      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo app('translator')->getFromJson( 'messages.close' ); ?></button>
    </div>

    <?php echo Form::close(); ?>


  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->