
<?php if(!session('business.enable_price_tax')): ?> 
    <?php
        $default = 0;
        $class = 'hide';
    ?>
<?php else: ?>
    <?php
        $default = null;
        $class = '';
    ?>
<?php endif; ?>

<tr class="variation_row">
    <td>
        <?php echo Form::select('product_variation[' . $row_index .'][variation_template_id]', $variation_templates, null, ['class' => 'form-control input-sm variation_template', 'required']);; ?>

        <input type="hidden" class="row_index" value="<?php echo e($row_index); ?>">
    </td>

    <td>
        <table class="table table-condensed table-bordered blue-header variation_value_table">
            <thead>
            <tr>
                <th><?php echo app('translator')->getFromJson('product.sku'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto" 
                    data-content="' . __('tooltip.sub_sku') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
                <th><?php echo app('translator')->getFromJson('product.value'); ?></th>
                <th class="<?php echo e($class); ?>"><?php echo app('translator')->getFromJson('product.default_purchase_price'); ?>
                    <br/>
                    <span class="pull-left"><small><i><?php echo app('translator')->getFromJson('product.exc_of_tax'); ?></i></small></span>

                    <span class="pull-right"><small><i><?php echo app('translator')->getFromJson('product.inc_of_tax'); ?></i></small></span>
                </th>
                <th class="<?php echo e($class); ?>"><?php echo app('translator')->getFromJson('product.profit_percent'); ?></th>
                <th class="<?php echo e($class); ?>"><?php echo app('translator')->getFromJson('product.default_selling_price'); ?>
                <br/>
                <small><i><span class="dsp_label"></span></i></small>
                    <!-- &nbsp;&nbsp;<b><i class="fa fa-info-circle" aria-hidden="true" data-toggle="popover" data-html="true" data-trigger="hover" data-content="<p class='text-primary'>Drag the mouse over the table cells to copy input values</p>" data-placement="top"></i></b> -->
                </th>
                <th><button type="button" class="btn btn-success btn-xs add_variation_value_row">+</button></th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td>
                    <?php echo Form::text('product_variation[' . $row_index .'][variations][0][sub_sku]', null, ['class' => 'form-control input-sm']);; ?>

                </td>
                <td>
                    <?php echo Form::text('product_variation[' . $row_index .'][variations][0][value]', null, ['class' => 'form-control input-sm variation_value_name', 'required']);; ?>

                </td>
                <td class="<?php echo e($class); ?>">
                    <div class="col-sm-6">
                        <?php echo Form::text('product_variation[' . $row_index .'][variations][0][default_purchase_price]', $default, ['class' => 'form-control input-sm variable_dpp input_number', 'placeholder' => 'Excluding Tax', 'required']);; ?>

                    </div>

                    <div class="col-sm-6">
                        <?php echo Form::text('product_variation[' . $row_index .'][variations][0][dpp_inc_tax]', $default, ['class' => 'form-control input-sm variable_dpp_inc_tax input_number', 'placeholder' => 'Including Tax', 'required']);; ?>

                    </div>
                </td>
                <td class="<?php echo e($class); ?>">
                    <?php echo Form::text('product_variation[' . $row_index .'][variations][0][profit_percent]', $profit_percent, ['class' => 'form-control input-sm variable_profit_percent input_number', 'required']);; ?>

                </td>
                <td class="<?php echo e($class); ?>">
                    <?php echo Form::text('product_variation[' . $row_index .'][variations][0][default_sell_price]', $default, ['class' => 'form-control input-sm variable_dsp input_number', 'placeholder' => 'Excluding tax', 'required']);; ?>


                     <?php echo Form::text('product_variation[' . $row_index .'][variations][0][sell_price_inc_tax]', $default, ['class' => 'form-control input-sm variable_dsp_inc_tax input_number', 'placeholder' => 'Including tax', 'required']);; ?>

                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-xs remove_variation_value_row">-</button>
                    <input type="hidden" class="variation_row_index" value="0">
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>