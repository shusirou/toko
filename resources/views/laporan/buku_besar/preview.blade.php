<?php 
	use App\JenisBuku;
	$jenis_buku   = new JenisBuku;
	$saldo_debit  = $jenis_buku->getSaldoAwal($kode_buku,'debit');
	$saldo_kredit = $jenis_buku->getSaldoAwal($kode_buku,'kredit');
	$awal_debit   = $saldo_debit;
	$awal_kredit  = $saldo_kredit;
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Buku Besar</title>
	<style type="text/css">
		body{
			font-size:12px;
		}
	</style>
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
    	<?php $bulan=array("01"=>"Januari",
    					   "02"=>"Februari",
    					   "03"=>"Maret",
    					   "04"=>"April",
    					   "05"=>"Mei",
    					   "06"=>"Juni",
    					   "07"=>"Juli",
    					   "08"=>"Agustus",
    					   "09"=>"September",
    					   "10"=>"Oktober",
    					   "11"=>"November",
    					   "12"=>"Desember");?>

		<br>
			<h3 style="text-align: center;">
				BUKU {{strtoupper($nama_buku)}}<br>
				{{Request::get('bln')!=null ? strtoupper(array_search(Request::get('bln'), array_flip($bulan)))  : ''}} {{Request::get('thn')!=null ? Request::get('thn') : ''}}
			</h3>

	<table width="96%" border="1" style="border-collapse: collapse;" align="center" cellpadding="3" cellspacing="0" class="style9">
        <tbody>
			<tr style="background-color: #ccc">
				<th>No</th>
				<th>Tanggal</th>
				<th>ID. Trx</th>
				<th>KD. Rekening</th>
				<th>Keterangan</th>
				<th>Debet</th>
				<th>Kredit</th>
				<th>Saldo</th>
				<th>P</th>
			</tr>
			<?php $no=1; $t_debit=0; $t_kredit=0; $saldo=0; ?>
			
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>Saldo Awal {{date('Y')}}</td>
				<td align="right">{{number_format($awal_debit->ttltahunlalu)}}</td>
				<td align="right">{{number_format($awal_kredit->ttltahunlalu)}}</td>
				<?php 
				    $saldo_awal_tahun = 0; 
					if($posisi == 'aktiva/biaya'){
						$saldo_awal_tahun = $awal_debit->ttltahunlalu - $awal_kredit->ttltahunlalu;
					}else{
						$saldo_awal_tahun = $awal_kredit->ttltahunlalu - $awal_debit->ttltahunlalu;
					}

				?>
				<td align="right">{{number_format($saldo_awal_tahun)}}</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<?php 

					$awal_pakai_debit  = $awal_debit->ttlawalpakai + $sd_bln_lalu_debit;
					$awal_pakai_kredit = $awal_kredit->ttlawalpakai + $sd_bln_lalu_kredit;

					$saldo_awal_pakai = 0;

					if($posisi == 'aktiva/biaya'){
						$saldo_awal_pakai = $awal_pakai_debit - $awal_pakai_kredit;
					}else{
						$saldo_awal_pakai = $awal_pakai_kredit - $awal_pakai_debit;
					}

				?>
				<td>Saldo Awal {{Request::get('bln')!=null ? strtoupper(array_search(Request::get('bln'), array_flip($bulan)))  : ''}} {{Request::get('thn')!=null ? Request::get('thn') : ''}}</td>
				<td align="right">{{number_format($awal_pakai_debit)}}</td>
				<td align="right">{{number_format($awal_pakai_kredit)}}</td>
				<td align="right">{{number_format($saldo_awal_tahun + $saldo_awal_pakai)}}</td>
				<td></td>
			</tr>
			@if(count($trx) > 0)
			@foreach($trx as $t=>$v)
			<tr>
				<td align="center">{{$no++}}</td>
				<td align="center">{{\Carbon::parse($v['tanggal'])->format('d-m-Y')}}</td>
				<td align="center">{{$v['invoice_no'] != null ? $v['invoice_no'] : $v['ref_id']}}</td>
				<td align="center">{{isset($v['kd_rekening_debit']) ? $v['kd_rekening_debit'] : $v['kd_rekening_kredit']}}</td>
				<td>{{$v['nama_rekening']." : ".$v['invoice_no']."-".$v['nama_kontak']."-".$v['id_kontak']}}</td>
				<td align="right">{{isset($v['kd_rekening_debit']) ? number_format($v['nominal']) : 0}}</td>
				<td align="right">{{isset($v['kd_rekening_kredit']) ? number_format($v['nominal']) : 0}}</td>
				<td align="right">
					<?php 
						if($posisi == 'aktiva/biaya'){
							if(isset($v['kd_rekening_debit']))
							{

								$saldo += $v['nominal'];
							}
							else
							{

								$saldo -= $v['nominal'];
							}
						}else{
							if(isset($v['kd_rekening_kredit']))
							{

								$saldo += $v['nominal'];
							}
							else
							{

								$saldo -= $v['nominal'];
							}
						}
						
					?>
					{{number_format($saldo_awal_tahun + $saldo_awal_pakai + $saldo)}}
				</td>
				<td align="center">{{strtoupper($v['initial'])}}</td>
			</tr>
			<?php 
				$t_debit += isset($v['kd_rekening_debit']) ? $v['nominal'] : 0;
				$t_kredit += isset($v['kd_rekening_kredit']) ? $v['nominal'] : 0;

				 ?>
			@endforeach
			@else
			<tr>
				<td colspan="8" align="center">- Tak ada data -</td>
			</tr>
			@endif
			<tr>
				<td colspan="5">Transaksi Bulan {{Request::get('bln')!=null ? ucwords(array_search(Request::get('bln'), array_flip($bulan)))  : ''}} {{Request::get('thn')!=null ? Request::get('thn') : ''}}</td>
				<td align="right"><b>{{number_format($t_debit)}}</b></td>
				<td align="right"><b>{{number_format($t_kredit)}}</b></td>
				<td align="center" colspan="2"><b>SALDO</b></td>
			</tr>
			<tr>
				<td colspan="5">Transaksi sampai dengan Bulan {{Request::get('bln')!=null ? ucwords(array_search(Request::get('bln'), array_flip($bulan)))  : ''}} {{Request::get('thn')!=null ? Request::get('thn') : ''}}</td>
				<td align="right"><b>{{number_format($sd_bln_ini_debit)}}</b></td>
				<td align="right"><b>{{number_format($sd_bln_ini_kredit)}}</b></td>
				<td align="center" rowspan="2" colspan="2"><b>{{number_format($saldo_awal_tahun + $saldo_awal_pakai + $saldo)}}</b></td>
			</tr>
			<tr>
				<td colspan="5">Transaksi Komulatif sampai dengan Tahun {{Request::get('thn')!=null ? Request::get('thn') : ''}}</td>
				<td align="right"><b>{{number_format($th_ini_debit)}}</b></td>
				<td align="right"><b>{{number_format($th_ini_kredit)}}</b></td>
			</tr>
		</tbody>
	</table>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
	<tbody><tr>
		  <td class="style27 align-center" valign="top" width="31%">
		  	  <br>Diperiksa Oleh:<br>BADAN PENGAWAS<br>
			
				<table width="100%">
				<tbody><tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3">&nbsp;</td></tr>
	            <tr><td colspan="3">&nbsp;</td></tr>
					<tr><td class="style9" width="auto"><center>Manajer</center></td></tr>
				</tbody></table>		
			
		  </td>

		  <td class="style27 align-center" valign="top" width="31%"><br>Dilaporkan Oleh:<br>Unit Pengelola {{$bl->name}}<br>
		  
				<table width="100%">
					<tbody><tr><td colspan="3">&nbsp;</td></tr>
					<tr><td colspan="3">&nbsp;</td></tr>
					<tr><td colspan="3">&nbsp;</td></tr>
					<tr><td class="style9" width="auto"><center>Bag. Administrasi</center></td><td class="style9" width="auto"><center>Keuangan</center></td></tr>
				</tbody></table>	  </td>
	  </tr>


	 <!--  <tr>
	  	<td class="style27 align-center" colspan="3">
			<br>Mengetahui/Menerima:<br>Badan Kerjasama Antar Desa<br>
			<table width="100%">

					<tbody><tr><td colspan="5">&nbsp;</td></tr>
					<tr><td colspan="5">&nbsp;</td></tr>
					<tr><td colspan="5">&nbsp;</td></tr>
					<tr><td class="style9" width="auto"><center><u>Muhammad Ayub</u><br>Ketua</center></td></tr>
				</tbody>
			</table>
		</td>
	</tr> -->
	<tr>
		<td colspan="3">&nbsp;</td></tr>	
	<!-- <tr>
		<td class="style10 top align-right" colspan="3">Dicetak Oleh: Muhammad Hasim; pada: 02/01/2020 09:27:41 AM</td>
	</tr> -->
	</tbody>
	</table>
	</body>
</html>