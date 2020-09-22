<?php $__env->startSection('title', __('report.stock_report')); ?>

<?php $__env->startSection('content'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><?php echo e(__('report.stock_report')); ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary" id="accordion">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseFilter">
                    <i class="fa fa-filter" aria-hidden="true"></i> <?php echo app('translator')->getFromJson('report.filters'); ?>
                  </a>
                </h3>
              </div>
              <div id="collapseFilter" class="panel-collapse active collapse in" aria-expanded="true">
                <div class="box-body">
                  <?php echo Form::open(['url' => action('ReportController@getStockReport'), 'method' => 'get']); ?>

                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo Form::label('location_id',  __('purchase.business_location') . ':'); ?>

                            <?php echo Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']);; ?>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo Form::label('category_id', __('category.category') . ':'); ?>

                            <?php echo Form::select('category', $categories, null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'category_id']);; ?>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo Form::label('sub_category_id', __('product.sub_category') . ':'); ?>

                            <?php echo Form::select('sub_category', array(), null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%', 'id' => 'sub_category_id']);; ?>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo Form::label('brand', __('product.brand') . ':'); ?>

                            <?php echo Form::select('brand', $brands, null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%']);; ?>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <?php echo Form::label('unit',__('product.unit') . ':'); ?>

                            <?php echo Form::select('unit', $units, null, ['placeholder' => __('messages.all'), 'class' => 'form-control select2', 'style' => 'width:100%']);; ?>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                           <label>Nama Produk:</label>
                           <input type="text" class="form-control" value="<?php echo e(Request::get('nama_produk') !=null ? Request::get('nama_produk') : ''); ?>" name="nama_produk" id="nama_produk" placeholder="Nama Produk (Keyword)">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" style="margin-top: 25px;" class="btn btn-primary">Filter</button>
                        <button type="button" style="margin-top: 25px" onclick="cetak()" class="btn btn-warning">Print</button>
                        <button type="button" style="margin-top: 25px"  onclick="pdf()" class="btn btn-danger">Export PDF</button>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="stock_report_table">
                        <thead>
                            <tr>
                                <th></th>
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
                                <td></td>
                                <td><?php echo e($p->sku); ?></td>
                                <td><?php echo e($p->product); ?></td>
                                <td class="text-right">
                                    <?php  
                                        $html = '';
                                        if ($p->type == 'single' && auth()->user()->can('access_default_selling_price')) {
                                            $html .= '<span class="display_currency" data-currency_symbol=true >'
                                            . $p->unit_price . '</span>';
                                        }

                                        if($allowed_selling_price_group){
                                            $html .= ' <button type="button" class="btn btn-primary btn-xs btn-modal" data-container=".view_modal" data-href="' . action('ProductController@viewGroupPrice', [$p->DT_RowId]) .'">' . __('lang_v1.view_group_prices') . '</button>';
                                        }

                                        echo $html;

                                    ?>
                                        
                                </td>
                                <td class="text-center"><?php 
                                    if ($p->enable_stock) {
                                        $stock = $p->stock ? $p->stock : 0 ;
                                        $fstock =  (float)$stock . ' ' . $p->unit;
                                    } else {
                                        $fstock = 'N/A';
                                    }

                                 ?><?php echo e($fstock); ?></td>
                                <td class="text-center">
                                    <?php 
                                        $total_sold = 0;
                                        if ($p->total_sold) {
                                            $total_sold =  (float)$p->total_sold;
                                        }

                                        echo '<span class="display_currency" data-currency_symbol=false >' . $total_sold . '</span> ' . $p->unit;
                                     ?>

                                </td>
                                <td class="text-center">
                                    <?php $total_transfered = 0;
                                            if ($p->total_transfered) {
                                                $total_transfered =  (float)$p->total_transfered;
                                            }

                                        echo '<span class="display_currency" data-currency_symbol=false >' . $total_transfered . '</span> ' . $p->unit; ?>
                                </td>
                                <td class="text-center">
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
                   <center> <p><?php echo e($products->appends(request()->input())->links()); ?></p></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
    function cetak()
    {
        var x = screen.width/2 - 1000/2;
        var y = screen.height/2 - 500/2;

        window.open('<?php echo e(url("reports/stock-report")); ?>?location_id='+$('#location_id').val()+'&category_id='+$('#category_id').val()+'&sub_category_id='+$('#sub_category_id').val()+'&brand='+$('#brand').val()+'&unit='+$('#unit').val()+'&nama_produk='+$('#nama_produk').val()+'&print=ok','Cetak Laporan ',"width=1000, height=500, left="+x+", top="+y+"");
    }

    function pdf()
    {
        location.href = '<?php echo e(url("reports/stock-report")); ?>?location_id='+$('#location_id').val()+'&category_id='+$('#category_id').val()+'&sub_category_id='+$('#sub_category_id').val()+'&brand='+$('#brand').val()+'&unit='+$('#unit').val()+'&nama_produk='+$('#nama_produk').val()+'&pdf=ok';
    }
</script>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>