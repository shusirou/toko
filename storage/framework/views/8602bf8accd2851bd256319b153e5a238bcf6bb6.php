``  <!DOCTYPE html>
<html>
<head>
	<title>Laporan Stok</title>
</head>
<body>
	<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tbody>
       	  <tr>
			<td height="20" colspan="2" class="bottom" width="5%">
				<div class="style9 text-align-left"><img class="" alt="..." src="../../../images/logo/1.png" style="float:left; width:50; margin-right:5px;"></div></td>
                 	  <td class="bottom">
                 <div class="style9"><h3><b><?php echo e($bl->name); ?></b></h3><?php echo e($bl->city); ?>,<?php echo e($bl->state); ?>,<?php echo e($bl->zip_code); ?></div>      
				
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9"></div></td>
	  	  </tr> 
	   </tbody>
	</table>
	<hr>
    <br>
        <h3 style="text-align: center;">
           LAPORAN STOK
        </h3>
    <table width="100%" border="1" style="border-collapse: collapse; font-size: 12px;" align="center" cellpadding="3" cellspacing="0" class="style9">
        <thead>
           <tr style="background-color: #ccc">
              
                <th>SKU</th>
                <th><?php echo app('translator')->getFromJson('business.product'); ?></th>
                <th><?php echo app('translator')->getFromJson('sale.unit_price'); ?></th>
                <th><?php echo app('translator')->getFromJson('report.current_stock'); ?></th>
                <th><?php echo app('translator')->getFromJson('report.total_unit_sold'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.total_unit_transfered'); ?></th>
                <th><?php echo app('translator')->getFromJson('lang_v1.total_unit_adjusted'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                
                <td><?php echo e($p->sku); ?></td>
                <td><?php echo e($p->product); ?></td>
                <td align="right">
                  <?php  
                        $html = '';
                            $html .= '<span class="display_currency" data-currency_symbol=true >'
                            . $p->unit_price . '</span>';
                        echo $html;

                    ?>
                </td>
                <td align="center">
                  <?php 
                    if ($p->enable_stock) {
                        $stock = $p->stock ? $p->stock : 0 ;
                        $fstock =  (float)$stock . ' ' . $p->unit;
                    } else {
                        $fstock = 'N/A';
                    }

                 ?><?php echo e($fstock); ?>

                </td>
                <td align="center">
                    <?php 
                        $total_sold = 0;
                        if ($p->total_sold) {
                            $total_sold =  (float)$p->total_sold;
                        }

                        echo '<span class="display_currency" data-currency_symbol=false >' . $total_sold . '</span> ' . $p->unit;
                     ?>

                </td>
                <td align="center">
                   <?php $total_transfered = 0;
                            if ($p->total_transfered) {
                                $total_transfered =  (float)$p->total_transfered;
                            }

                        echo '<span class="display_currency" data-currency_symbol=false >' . $total_transfered . '</span> ' . $p->unit; ?>
                </td>
                <td align="center">
                     <?php  $total_adjusted = 0;
                            if ($p->total_adjusted) {
                                $total_adjusted =  (float)$p->total_adjusted;
                            }

                            echo '<span class="display_currency" data-currency_symbol=false >' . $total_adjusted . '</span> ' . $p->unit; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
