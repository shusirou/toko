<?php
    $variation_name = !empty($variation_name) ? $variation_name : null;
    $variation_value_id = !empty($variation_value_id) ? $variation_value_id : null;

    $name = (empty($row_type) || $row_type == 'add') ? 'product_variation' : 'product_variation_edit';

    $readonly = !empty($variation_value_id) ? 'readonly' : '';
?>

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

<tr>
    <td>
        <?php echo Form::text($name . '[' . $variation_index . '][variations][' . $value_index . '][sub_sku]', null, ['class' => 'form-control input-sm']);; ?>


        <?php echo Form::hidden($name . '[' . $variation_index . '][variations][' . $value_index . '][variation_value_id]', $variation_value_id); ?>

    </td>
    <td>
        <?php echo Form::text($name . '[' . $variation_index . '][variations][' . $value_index . '][value]', $variation_name, ['class' => 'form-control input-sm variation_value_name', 'required', $readonly]);; ?>

    </td>
    <td class="<?php echo e($class); ?>">
        <div class="col-sm-6">
            <?php echo Form::text($name . '[' . $variation_index . '][variations][' . $value_index . '][default_purchase_price]', $default, ['class' => 'form-control input-sm variable_dpp input_number', 'placeholder' => 'Excluding Tax', 'required']);; ?>

        </div>

        <div class="col-sm-6">
            <?php echo Form::text($name . '[' . $variation_index . '][variations][' . $value_index . '][dpp_inc_tax]', $default, ['class' => 'form-control input-sm variable_dpp_inc_tax input_number', 'placeholder' => 'Including Tax', 'required']);; ?>

        </div>
    </td>
    <td class="<?php echo e($class); ?>">
        <?php echo Form::text($name . '[' . $variation_index . '][variations][' . $value_index . '][profit_percent]', $profit_percent, ['class' => 'form-control input-sm variable_profit_percent input_number', 'required']);; ?>

    </td>
    <td class="<?php echo e($class); ?>">
        <?php echo Form::text($name . '[' . $variation_index . '][variations][' . $value_index . '][default_sell_price]', $default, ['class' => 'form-control input-sm variable_dsp input_number', 'placeholder' => 'Excluding tax', 'required']);; ?>


        <?php echo Form::text($name . '[' . $variation_index . '][variations][' . $value_index . '][sell_price_inc_tax]', $default, ['class' => 'form-control input-sm variable_dsp_inc_tax input_number', 'placeholder' => 'Including tax', 'required']);; ?>

    </td>
    <td>
        <button type="button" class="btn btn-danger btn-xs remove_variation_value_row">-</button>
        <input type="hidden" class="variation_row_index" value="<?php echo e($value_index); ?>">
    </td>
</tr>