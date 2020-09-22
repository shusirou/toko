<div class="row">
	<div class="col-xs-12 text-center">
		<table class="" cellpadding="0" style="margin-left:5px; margin-right:5px; margin-bottom:5px;font-size:9px; width: 95%;">
			<tr>
				<td colspan="3" style="text-align: center;"><?php if(!empty($receipt_details->display_name)): ?><?php echo e(strtoupper($receipt_details->display_name)); ?><?php endif; ?>
				</td>
			</tr>
			<tr >
				<td colspan="3"style="text-align: center;"><small style="margin-bottom: 5px;" class="text-center">
				<?php echo $receipt_details->address; ?>

				</small></td>
			</tr>
		</table>
	</div>
	<div class="col-xs-12">
		<table class="" cellpadding="0" style="margin-right:5px;margin-left:5px;font-size:9px; width: 95%; border-top: 1px dashed black; border-bottom: 1px dashed black;">
			<tr>
				<td>Nota</td>
				<td>:</td>
				<td><?php echo e($receipt_details->invoice_no); ?></td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td>:</td>
				<td><?php echo e($receipt_details->invoice_date); ?></td>
			</tr>
			<tr>
				<td>Kasir</td>
				<td>:</td>
				<td><?php echo e(auth()->user()->first_name." ".auth()->user()->last_name); ?></td>
			</tr>
		</table>
	</div>
	<div class="col-xs-12">
		<table class="" cellpadding="0" style="margin:5px;width:85%;font-size:9px; ">
			<?php $__empty_1 = true; $__currentLoopData = $receipt_details->lines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $line): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
					<tr>
						<td colspan="4">
                            <?php echo e($line['name']); ?> <?php echo e($line['variation']); ?> 
                            <!-- <?php if(!empty($line['sub_sku'])): ?>, <?php echo e($line['sub_sku']); ?> <?php endif; ?> <?php if(!empty($line['brand'])): ?>, <?php echo e($line['brand']); ?> <?php endif; ?> <?php if(!empty($line['cat_code'])): ?>, <?php echo e($line['cat_code']); ?><?php endif; ?>
                            <?php if(!empty($line['sell_line_note'])): ?>(<?php echo e($line['sell_line_note']); ?>) <?php endif; ?> 
                            <?php if(!empty($line['lot_number'])): ?><br> <?php echo e($line['lot_number_label']); ?>:  <?php echo e($line['lot_number']); ?> <?php endif; ?> 
                            <?php if(!empty($line['product_expiry'])): ?>, <?php echo e($line['product_expiry_label']); ?>:  <?php echo e($line['product_expiry']); ?> <?php endif; ?> --> 
                        </td>
					</tr>
					<tr>
						<td><?php echo e($line['quantity']); ?> <?php echo e($line['units']); ?> x </td>
						<td style="text-align: right;"><?php echo e(number_format(round($line['unit_price_inc_tax']))); ?></td>
						<td class="text-center">:</td>
						<td style="text-align: right;"><?php echo e(number_format(round($line['line_total']))); ?></td>
					</tr>
					<?php if(!empty($line['modifiers'])): ?>
						<?php $__currentLoopData = $line['modifiers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modifier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<tr>
								<td colspan="4">
		                            <?php echo e($modifier['name']); ?> <?php echo e($modifier['variation']); ?> 
		                            <!-- <?php if(!empty($modifier['sub_sku'])): ?>, <?php echo e($modifier['sub_sku']); ?> <?php endif; ?> <?php if(!empty($modifier['cat_code'])): ?>, <?php echo e($modifier['cat_code']); ?><?php endif; ?>
		                            <?php if(!empty($modifier['sell_line_note'])): ?>(<?php echo e($modifier['sell_line_note']); ?>) <?php endif; ?>  -->
		                        </td>
		                    </tr>
		                    <td>
								<td><?php echo e($modifier['quantity']); ?> <?php echo e($modifier['units']); ?> x </td>
								<td><?php echo e($modifier['unit_price_inc_tax']); ?></td>
								<td class="text-center">:</td>
								<td><?php echo e($modifier['line_total']); ?></td>
							</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php endif; ?>

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
					<tr>
						<td colspan="4">&nbsp;</td>
					</tr>

				<?php endif; ?>
				<tr>
					<td colspan="4"><br></td>
				</tr>
				<?php if(!empty($receipt_details->total_due)): ?>
				
				<tr>
					<td></td>
					<td>Total Hutang</td>
					<td>:</td>
					<td><?php echo e(number_format(round($receipt_details->total_due))); ?></td>
				</tr>
				<?php endif; ?>
				<?php if(!empty($receipt_details->shipping_charges)): ?>
				<tr>
					<td></td>
					<td>Biaya Kirim</td>
					<td>:</td>
					<td><?php echo e(number_format(round($receipt_details->shipping_charges))); ?></td>
				</tr>
				<?php endif; ?>
				<?php if( !empty($receipt_details->discount) ): ?>
				<tr>
					<td></td>
					<td>Diskon</td>
					<td>:</td>
					<td><?php echo e(number_format(round($receipt_details->discount))); ?></td>
				</tr>
				<?php endif; ?>
				<?php if( !empty($receipt_details->tax) ): ?>
				<tr>
					<td></td>
					<td>Pajak</td>
					<td>:</td>
					<td><?php echo e(number_format(round($receipt_details->tax))); ?></td>
				</tr>
				<?php endif; ?>
				<?php if(!empty($receipt_details->total)): ?>
				<tr>
					<td></td>
					<td>Total</td>
					<td>:</td>
					<td class="text-right"><?php echo e(number_format(round($receipt_details->total))); ?></td>
				</tr>
				<?php endif; ?>
				<tr>
					<td></td>
					<td>Bayar</td>
					<td>:</td>
					<td class="text-right"><?php echo e(number_format((float)$receipt_details->bayar)); ?></td>
				</tr>
				<tr>
					<td></td>
					<td>Kembali</td>
					<td>:</td>
					<td class="text-right"><?php echo e(number_format((float)$receipt_details->kembali)); ?></td>
				</tr>
				<tr>
					<td></td>
					<td>Catatan</td>
					<td>:</td>
					<td class="text-right"><?php echo e($receipt_details->additional_notes); ?></td>
				</tr>
		</table>
	</div>
	<div class="col-xs-12">
		<table class="" cellpadding="0" style="margin:5px;font-size:9px; width: 95%;border-top: 1px dashed black; border-bottom: 1px dashed black;">
			<tr>
				<td>Pelanggan</td>
				<td>:</td>
				<td><?php echo e($receipt_details->customer_name); ?></td>
			</tr>
		</table>
		
	</div>
	<div class="col-xs-12">
		<table class="" cellpadding="0" style="margin:5px;font-size:9px; width: 95%;">
			<tr>
				<td colspan="3" style="text-align: center;">Terima Kasih</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center;">Selamat Berbelanja Kembali</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: center;"><?php if(!empty($receipt_details->display_name)): ?><?php echo e(strtoupper($receipt_details->display_name)); ?><?php endif; ?></td>
			</tr>
		</table>
	</div>
</div>