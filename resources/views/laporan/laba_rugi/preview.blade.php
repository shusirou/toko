<!DOCTYPE html>
<html>
<head>
	<title>Laba Rugi</title>
</head>
<body>
	<table width="97%" border="0" align="center" cellpadding="3" cellspacing="0">
       <tbody>
       	  <tr>
			<td height="20" colspan="2" class="bottom" width="5%">
				<div class="style9 text-align-left"><img class="" alt="..." src="../../../images/logo/1.png" style="float:left; width:50; margin-right:5px;"></div></td>
                 	  <td class="bottom">
                 <div class="style9"><h3><b>{{$bl->name}}</b></h3>{{$bl->city}},{{$bl->state}},{{$bl->zip_code}}</div>      
				
			</td>
			<td height="20" colspan="2" class="bottom"><div align="right" class="style9"></div></td>
	  	  </tr> 
	   </tbody>
	</table>
	<hr>
    	<?php $bulan=array("01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April","05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus","09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember");?>

		<h3 style="text-align: center;"><br>LAPORAN RUGI LABA {{Request::get('bln')!=null ? strtoupper(array_search(Request::get('bln'), array_flip($bulan)))  : strtoupper(array_search(date('m'),array_flip($bulan)))}} {{Request::get('thn')!=null ? Request::get('thn') : ''}}</h3>
	<?php 
		$t_pendapatan_sd_bulan_lalu = 0;
		$t_pendapatan_bulan_ini = 0;
		$t_pendapatan_sd_bulan_ini = 0;
		$t_pendapatan = 0;
		$t_biaya_sd_bulan_lalu = 0;
		$t_biaya_bulan_ini = 0;
		$t_biaya_sd_bulan_ini = 0;
		$t_biaya 	  = 0;
	 ?>
	<table width="96%" border="1" style="border-collapse: collapse;" align="center" cellpadding="3" cellspacing="0" class="style9">
		<tbody>
			<tr height="35">
				<th colspan="2" class="left bottom top">Rekening</th>
				<th class="left bottom top">s.d. Bulan Lalu</th>
				<th class="left bottom top">Bulan Ini</th>
				<th class="all">s.d. Bulan Ini</th>
			</tr>
			<tr height="25">
				<td colspan="5" class="left right style27">4. PENDAPATAN</td>
			</tr>
			@foreach($jb_pendapatan as $jp)
			<tr>
				<td colspan="2">{{$jp->kd_jb.'. '.$jp->nama_jb}}</td>	
				<td></td>	
				<td></td>	
				<td></td>	
			</tr>
				@foreach($jp->getRekeningByIdJenisBuku($jp->kd_jb) as $rp)
				<?php 
					$awal = $jp->getValueAwalByRekening($rp->kd_rekening);

					$pend_sd_bulan_lalu = $jp->getValueLabaRugiByIdRekening($rp->kd_rekening,'pendapatan',Request::get('tgl'),Request::get('bln'),Request::get('thn'),'sd_bulan_lalu');
					$pend_bulan_ini = $jp->getValueLabaRugiByIdRekening($rp->kd_rekening,'pendapatan',Request::get('tgl'),Request::get('bln'),Request::get('thn'),'bulan_ini');
					$pend_sd_bulan_ini = $jp->getValueLabaRugiByIdRekening($rp->kd_rekening,'pendapatan',Request::get('tgl'),Request::get('bln'),Request::get('thn'),'sd_bulan_ini');
				?>
				<tr>
					<td></td>
					<td>{{$rp->kd_rekening.'. '.$rp->nama_rekening}}</td>
					<td align="right">{{number_format($awal + $pend_sd_bulan_lalu)}}</td>
					<td align="right">{{number_format($pend_bulan_ini)}}</td>
					<td align="right">{{number_format($awal + $pend_sd_bulan_ini)}}</td>
				</tr>
				<?php $t_pendapatan_sd_bulan_lalu += ($awal + $pend_sd_bulan_lalu);
					  $t_pendapatan_bulan_ini += ($pend_bulan_ini);
					  $t_pendapatan_sd_bulan_ini += ($awal + $pend_sd_bulan_ini);	
				 ?>
				@endforeach
			@endforeach
			<tr>
				<td colspan="2" align="right">TOTAL PENDAPATAN</td>
				<td align="right">{{number_format($t_pendapatan_sd_bulan_lalu)}}</td>
				<td align="right">{{number_format($t_pendapatan_bulan_ini)}}</td>
				<td align="right">{{number_format($t_pendapatan_sd_bulan_ini)}}</td>
			</tr>
			<tr height="25">
				<td colspan="5" class="left right style27">5. BIAYA</td>
			</tr>
			@foreach($jb_biaya as $jb)
			<tr>
				<td colspan="2">{{$jb->kd_jb.'. '.$jb->nama_jb}}</td>	
				<td></td>	
				<td></td>	
				<td></td>	
			</tr>
				@foreach($jb->getRekeningByIdJenisBuku($jb->kd_jb) as $rb)
				<?php 
					$awalb = $jb->getValueAwalByRekening($rb->kd_rekening);
					$biaya_sd_bulan_lalu = $jb->getValueLabaRugiByIdRekening($rb->kd_rekening,'biaya',Request::get('tgl'),Request::get('bln'),Request::get('thn'),'sd_bulan_lalu');
					$biaya_bulan_ini = $jb->getValueLabaRugiByIdRekening($rb->kd_rekening,'biaya',Request::get('tgl'),Request::get('bln'),Request::get('thn'),'bulan_ini');
					$biaya_sd_bulan_ini = $jb->getValueLabaRugiByIdRekening($rb->kd_rekening,'biaya',Request::get('tgl'),Request::get('bln'),Request::get('thn'),'sd_bulan_ini');
				?>
				<tr>
					<td></td>
					<td>{{$rb->kd_rekening.'. '.$rb->nama_rekening}}</td>
					<td align="right">{{number_format($awalb + $biaya_sd_bulan_lalu)}}</td>
					<td align="right">{{number_format($biaya_bulan_ini)}}</td>
					<td align="right">{{number_format($awalb + $biaya_sd_bulan_ini)}}</td>
				</tr>
				<?php $t_biaya_sd_bulan_lalu += ($awalb + $biaya_sd_bulan_lalu);
					  $t_biaya_bulan_ini += ($biaya_bulan_ini);
					  $t_biaya_sd_bulan_ini += ($awalb + $biaya_sd_bulan_ini);	
				 ?>
				@endforeach
			@endforeach
			<tr>
				<td colspan="2" align="right">TOTAL BIAYA</td>
				<td align="right">{{number_format($t_biaya_sd_bulan_lalu)}}</td>
				<td align="right">{{number_format($t_biaya_bulan_ini)}}</td>
				<td align="right">{{number_format($t_biaya_sd_bulan_ini)}}</td>
			</tr>
			<tr>
				<?php 
					$sd_sd_bulan_lalu = $t_pendapatan_sd_bulan_lalu - $t_biaya_sd_bulan_lalu;
					$sd_bulan_ini = $t_pendapatan_bulan_ini - $t_biaya_bulan_ini;
					$sd_sd_bulan_ini = $t_pendapatan_sd_bulan_ini - $t_biaya_sd_bulan_ini;
				 ?>
				<td colspan="2" align="right">SURPLUS / DEFISIT</td>
				<td align="right">{{number_format($sd_sd_bulan_lalu)}}</td>
				<td align="right">{{number_format($sd_bulan_ini)}}</td>
				<td align="right">{{number_format($sd_sd_bulan_ini)}}</td>
			</tr>
		</tbody>
	</table>
</body>
</html>
