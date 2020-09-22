<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisBuku;
use App\Business;
use App\BusinessLocation;
use App\RekeningRiil;
use App\Rekening;
use App\Exports\NeracaExport;
use PDF;
use Excel;

class LaporanController extends Controller
{
    public function index()
    {
    	$jenisbuku = JenisBuku::where('business_id',auth()->user()->business_id)->get();

    	return view('laporan.index',['jenisbuku'=>$jenisbuku]);
    }

    public function neraca(Request $req)
    {
    	$business_id = auth()->user()->business_id;

    	$ra = RekeningRiil::where('posisi',1)->get();
        $rp = RekeningRiil::whereNotIn('posisi',[1,4,5])->get();
    	$bl = BusinessLocation::where('business_id','=',$business_id)->first();
        $nr = new RekeningRiil;
        $lr = $nr->getLabaRugi($req->tgl,$req->bln,$req->thn);
        
        if($req->type == 'pdf'){
             ini_set('max_execution_time', 7200);
            $pdf = PDF::loadView('laporan.neraca.preview',['bl'=>$bl,'rekening_aktiva'=>$ra,'rekening_pasiva'=>$rp,'laba_rugi'=>$lr]);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('neraca.pdf');
        }elseif($req->type == 'excel'){
          die('Under construction');
                
        }else{
             ini_set('max_execution_time', 7200);
    	   return view('laporan.neraca.'.$req->type,['bl'=>$bl,'rekening_aktiva'=>$ra,'rekening_pasiva'=>$rp,'laba_rugi'=>$lr]);
        }

    }

    public function laba_rugi(Request $req)
    {
        $business_id = auth()->user()->business_id;

        $bl = BusinessLocation::where('business_id','=',$business_id)->first();
        $jb_pendapatan = JenisBuku::where('business_id',auth()->user()->business_id)->where('posisi',4)->get();
        $jb_biaya = JenisBuku::where('business_id',auth()->user()->business_id)->where('posisi',5)->get();
       
        if($req->type == 'pdf'){
             ini_set('max_execution_time', 7200);
            $pdf = PDF::loadView('laporan.laba_rugi.preview',compact('bl','jb_pendapatan','jb_biaya'));

            return $pdf->download('rugi_laba.pdf');
        }else{
             ini_set('max_execution_time', 7200);
    	   return view('laporan.laba_rugi.'.$req->type,compact('bl','jb_pendapatan','jb_biaya'));
        }
    }

    public function buku_besar(Request $req)
    {
        $business_id    = auth()->user()->business_id;
        $bl             = BusinessLocation::selectRaw('id,business_id,location_id,name,landmark,country,state,city,zip_code')
                                          ->where('business_id','=',$business_id)->first();
        $jenisbuku      = JenisBuku::where('business_id',auth()->user()->business_id)->where('ins',$req->jenis_buku_besar)->first();
        $reks           = Rekening::where('business_id',auth()->user()->business_id)->where('kd_jb',$jenisbuku->kd_jb)->get();
        $nama_buku      = $jenisbuku->nama_jb;
        $kode_buku      = $jenisbuku->kd_jb;

        if($jenisbuku->posisi == '1' || $jenisbuku->posisi == '5' ){
            $posisi = 'aktiva/biaya';
        }else{
            $posisi = 'passiva';
        }

        $trx = array();
        $sd_bln_ini_debit = 0;
        $sd_bln_ini_kredit = 0;
        $sd_bln_lalu_debit = 0;
        $sd_bln_lalu_kredit = 0;
        $th_ini_debit = 0;
        $th_ini_kredit = 0;
        foreach ($reks as $key) {
            $jb = new JenisBuku;
        
            $get_trx = $jb->getTransaksiBukuBesar($key->jenis_mutasi,$key->kd_rekening,$key->nama_rekening,$req->tgl,$req->bln,$req->thn,'bulan_ini');
            $trx_sd_bln_ini = $jb->getTransaksiBukuBesar($key->jenis_mutasi,$key->kd_rekening,$key->nama_rekening,$req->tgl,$req->bln,$req->thn,'sd_bulan_ini');
            $trx_sd_bln_lalu = $jb->getTransaksiBukuBesar($key->jenis_mutasi,$key->kd_rekening,$key->nama_rekening,$req->tgl,$req->bln,$req->thn,'sd_bulan_lalu');
            $trx_th_ini = $jb->getTransaksiBukuBesar($key->jenis_mutasi,$key->kd_rekening,$key->nama_rekening,$req->tgl,$req->bln,$req->thn,'komulatif');
      
            if($get_trx !=null){
                foreach($get_trx as $ky=>$vl){
                    $trx[] = $vl;
                }
                
            }

            if($trx_sd_bln_ini !=null){
                foreach($trx_sd_bln_ini as $ky=>$vl){
                    $sd_bln_ini_debit += isset($vl['kd_rekening_debit']) ? $vl['nominal'] : 0;
                    $sd_bln_ini_kredit += isset($vl['kd_rekening_kredit']) ? $vl['nominal'] : 0;
                }
            }

            if($trx_sd_bln_lalu !=null){
                foreach($trx_sd_bln_lalu as $ky=>$vl){
                    $sd_bln_lalu_debit += isset($vl['kd_rekening_debit']) ? $vl['nominal'] : 0;
                    $sd_bln_lalu_kredit += isset($vl['kd_rekening_kredit']) ? $vl['nominal'] : 0;
                }
            }

            if($trx_th_ini !=null){
                foreach($trx_th_ini as $ky=>$vl){
                    $th_ini_debit += isset($vl['kd_rekening_debit']) ? $vl['nominal'] : 0;
                    $th_ini_kredit += isset($vl['kd_rekening_kredit']) ? $vl['nominal'] : 0;
                }
            }
        }
        $data['hsl'] = array();
        foreach ($trx as $key => $value) {
            $data['hsl'][strtotime($value['tanggal'])+strtotime($value['created_at'])+$value['id']] = $value; 
        }
      
        ksort($data['hsl']);
        
        $fintrx =  $data['hsl'];
        $result =  ['bl'=>$bl,
                     'trx'=>$fintrx,
                     'posisi'=>$posisi,
                    /* 'tgl_awal_pakai'=>$tgl_awal_pakai,*/
                     'nama_buku'=>$nama_buku,
                     'kode_buku'=>$kode_buku,
                     'sd_bln_ini_debit'=>$sd_bln_ini_debit,
                     'sd_bln_ini_kredit'=>$sd_bln_ini_kredit,
                     'sd_bln_lalu_debit'=>$sd_bln_lalu_debit,
                     'sd_bln_lalu_kredit'=>$sd_bln_lalu_kredit,
                     'th_ini_debit'=>$th_ini_debit,
                     'th_ini_kredit'=>$th_ini_kredit];

        if($req->type == 'pdf'){
            ini_set('max_execution_time', -1);
            $pdf = PDF::loadView('laporan.buku_besar.preview',$result);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('buku_besar.pdf');
        }elseif($req->type == 'excel'){
          die('Under construction');
                
        }else{
             ini_set('max_execution_time', -1);
           return view('laporan.buku_besar.'.$req->type,$result);
        }
    }
}
