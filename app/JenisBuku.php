<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rekening;
use App\Jurnal;
use App\TransactionPayment;
use App\TransactionSellLine;
use App\StockAdjustmentLine;
use App\PurchaseLine;
use App\Transaction;
use App\Business;
use Carbon\Carbon;

class JenisBuku extends Model
{
    protected $table = 'jenis_buku';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getRekeningByIdJenisBuku($idjenisbuku)
    {
    	$rekening =    Rekening::where('business_id',auth()->user()->business_id)->where('kd_jb',$idjenisbuku)->get();

    	return $rekening;
    }

    public function getSaldoAwal($kd_jenis_buku,$jenis_mutasi)
    {   
        $th_lalu = date('Y') - 1;
        $saldo = Rekening::selectRaw('COALESCE(SUM(tb'.$th_lalu.'),0) as ttltahunlalu,COALESCE(SUM(awal),0) as ttlawalpakai')
                         ->where('business_id',auth()->user()->business_id)
                         ->where('kd_jb',$kd_jenis_buku)
                         ->where('jenis_mutasi',$jenis_mutasi)
                         ->first();

        return $saldo;
    }

    public function getValueAwalByRekening($kd_rekening)
    {
        $awal = Rekening::selectRaw('CAST(awal as INT) awal')
                         ->where('business_id',auth()->user()->business_id)
                         ->where('kd_rekening',$kd_rekening)
                         ->first();

        return $awal->awal == '' ? 0 : $awal->awal;
    }

    public function getValueLabaRugiByIdRekening($idrekening,$pb,$tgl=null,$bln=null,$thn=null,$period=null)
    {
        $m_now            = $bln != null ? $bln : date('m');
        $y_now            = $thn != null ? $thn : date('Y');
        $awal_tahun       = $thn!=null ?  Carbon::create($thn, 1, 31, 12, 0, 0)->startOfYear() : Carbon::now()->startOfYear();
        $akhir_bulan_lalu = $bln!=null ? Carbon::createFromFormat('m', $bln)->subMonth(1)->endOfMonth() : Carbon::now()->subMonth(1)->endOfMonth();
        $akhir_bulan_ini  = $bln!=null ? Carbon::createFromFormat('m', $bln)->endOfMonth() : Carbon::now()->endOfMonth();
       
    	$getjurnal = Jurnal::selectRaw('SUM(nominal) as ttl')
                           ->where('business_id',auth()->user()->business_id);

        if($tgl !=null ){
            $getjurnal->where('tanggal_jurnal',$thn.'-'.$bln.'-'.$tgl); 
        }else{
            if($period == 'bulan_ini'){
                $getjurnal->whereMonth('tanggal_jurnal',$m_now);
            }elseif($period == 'sd_bulan_lalu'){
                //1 januari tahun ini - akhir bulan lalu
                $getjurnal->whereBetween('tanggal_jurnal',[$awal_tahun,$akhir_bulan_lalu]);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $getjurnal->whereBetween('tanggal_jurnal',[$awal_tahun,$akhir_bulan_ini]);
            }
            
            $getjurnal->whereYear('tanggal_jurnal',$y_now);
        }

        if($pb == 'pendapatan'){
            $getjurnal->where('kd_rekening_kredit',$idrekening);
        }elseif($pb == 'biaya'){
            $getjurnal->where('kd_rekening_debit',$idrekening);
        }

        $jurnal = $getjurnal->first();

        $gettransaction = TransactionPayment::selectRaw('SUM(amount) as ttl')
                         ->join('transactions','transaction_payments.transaction_id','=','transactions.id')
                         ->where('transaction_payments.business_id',auth()->user()->business_id);

        if($tgl !=null ){
            $gettransaction->where('paid_on',$thn.'-'.$bln.'-'.$tgl); 
        }else{
            if($period == 'bulan_ini'){
                $gettransaction->whereMonth('paid_on',$m_now);
            }elseif($period == 'sd_bulan_lalu'){
                //1 januari tahun ini - akhir bulan lalu
                $gettransaction->whereBetween('paid_on',[$awal_tahun,$akhir_bulan_lalu]);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $gettransaction->whereBetween('paid_on',[$awal_tahun,$akhir_bulan_ini]);
            }
            
            $gettransaction->whereYear('paid_on',$y_now);
        }

        if($pb == 'pendapatan'){
            $gettransaction->where('id_rekening_kredit',$idrekening);
        }elseif($pb == 'biaya'){
            $gettransaction->where('id_rekening_debit',$idrekening);
        }

        $transaction = $gettransaction->first();

        $stockadjustment = StockAdjustmentLine::selectRaw('SUM(quantity * unit_price) as ttl')
                              ->join('transactions','stock_adjustment_lines.transaction_id','=','transactions.id')  
                              ->where('transactions.business_id',auth()->user()->business_id);

        if($tgl !=null ){
            $stockadjustment->where('transactions.created_at',$thn.'-'.$bln.'-'.$tgl); 
        }else{
            if($period == 'bulan_ini'){
                $stockadjustment->whereMonth('transactions.created_at',$m_now);
            }elseif($period == 'sd_bulan_lalu'){
                //1 januari tahun ini - akhir bulan lalu
                $stockadjustment->whereBetween('transactions.created_at',[$awal_tahun,$akhir_bulan_lalu]);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $stockadjustment->whereBetween('transactions.created_at',[$awal_tahun,$akhir_bulan_ini]);
            }
            
            $stockadjustment->whereYear('transactions.created_at',$y_now);
        }

        if($pb == 'pendapatan'){
            $stockadjustment->where('id_rekening_kredit',$idrekening);
        }elseif($pb == 'biaya'){
            $stockadjustment->where('id_rekening_debit',$idrekening);
        }

        $adjustment = $stockadjustment->first();

        $fjurnal = $jurnal->ttl !=null ? $jurnal->ttl : 0;                
        $ftransaction = $transaction->ttl !=null ? $transaction->ttl : 0;                
        $fadjustment = $adjustment->ttl !=null ? $adjustment->ttl : 0;

        return $fjurnal + $ftransaction + $fadjustment;
    }

    public function getTransaksiBukuBesar($dk,$kd_rekening,$nama_rekening,$tgl=null,$bln=null,$thn=null,$period=null)
    {
        $m_now = $bln != null ? $bln : date('m');
        $y_now = $thn != null ? $thn : date('Y');
        $awal_tahun       = $thn!=null ?  Carbon::create($thn, 1, 31, 12, 0, 0)->startOfYear() : Carbon::now()->startOfYear();
        $akhir_bulan_ini  = $bln!=null ? Carbon::createFromFormat('m', $bln)->endOfMonth() : Carbon::now()->endOfMonth();
        $akhir_bulan_lalu = $bln!=null ? Carbon::createFromFormat('m', $bln)->subMonth(1)->endOfMonth() : Carbon::now()->subMonth(1)->endOfMonth();

        $getjurnal = Jurnal::selectRaw('jurnal.id,tanggal_jurnal as tanggal,keterangan,nominal,ref_id,kd_rekening_'.$dk.',jurnal.created_at,"'.$nama_rekening.'" as nama_rekening,"1" as urutan,users.initial,"-" as id_kontak,"-" as nama_kontak,"-" as invoice_no')
                        ->leftJoin('users','jurnal.created_by','=','users.id')    
                        ->where('jurnal.business_id',auth()->user()->business_id)
                        ->where('kd_rekening_'.$dk,$kd_rekening);

        if($tgl !=null){
            $getjurnal->whereDate('tanggal_jurnal',$thn.'-'.$bln.'-'.$tgl);
        }else{
            if($period == 'bulan_ini'){
                $getjurnal->whereMonth('tanggal_jurnal',$m_now);
                $getjurnal->whereYear('tanggal_jurnal',$y_now);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $getjurnal->whereBetween('tanggal_jurnal',[$awal_tahun,$akhir_bulan_ini]);
                $getjurnal->whereYear('tanggal_jurnal',$y_now);
            }elseif ($period == 'sd_bulan_lalu') {
                 //1 januari tahun ini - akhir bulan lalu
                $getjurnal->whereBetween('tanggal_jurnal',[$awal_tahun,$akhir_bulan_lalu]);
                $getjurnal->whereYear('tanggal_jurnal',$y_now);
            }
            elseif($period == 'komulatif'){
                //sepanjang tahun
                $getjurnal->whereYear('tanggal_jurnal',$y_now);
            }
        }

        $getjurnal->orderBy('tanggal_jurnal','ASC');

        $jurnal    = $getjurnal->get()->toArray();

        $gettransaksi = Transaction::selectRaw('transactions.id,transaction_date as tanggal,additional_notes as keterangan,(final_total - shipping_charges) as nominal,ref_no as ref_id,kd_rekening_'.$dk.',transactions.created_at,"'.$nama_rekening.'" as nama_rekening,"2" as urutan,users.initial,contacts.contact_id as id_kontak,contacts.name as nama_kontak,invoice_no')
                        ->leftJoin('users','transactions.created_by','=','users.id')  
                        ->leftJoin('contacts','transactions.contact_id','=','contacts.id') 
                        ->where('transactions.business_id',auth()->user()->business_id)
                        ->where('kd_rekening_'.$dk,$kd_rekening);
        if($tgl !=null){
            $gettransaksi->whereDate('transaction_date',$thn.'-'.$bln.'-'.$tgl);
        }else{
            if($period == 'bulan_ini'){
                $gettransaksi->whereMonth('transaction_date',$m_now);
                $gettransaksi->whereYear('transaction_date',$y_now);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $gettransaksi->whereBetween('transaction_date',[$awal_tahun,$akhir_bulan_ini]);
                $gettransaksi->whereYear('transaction_date',$y_now);
            }elseif ($period == 'sd_bulan_lalu') {
                 //1 januari tahun ini - akhir bulan lalu
                $gettransaksi->whereBetween('transaction_date',[$awal_tahun,$akhir_bulan_lalu]);
                $gettransaksi->whereYear('transaction_date',$y_now);
            }
            elseif($period == 'komulatif'){
                //sepanjang tahun
                $gettransaksi->whereYear('transaction_date',$y_now);
            }
        }

        $gettransaksi->orderBy('transaction_date','ASC');
                
        $transaksi = $gettransaksi->get()->toArray();

        $gethtgptgbiayakirim = Transaction::selectRaw('transactions.id,transaction_date as tanggal,additional_notes as keterangan,shipping_charges as nominal,ref_no as ref_id,kd_rekening_'.$dk.'_htg_biaya_kirim as kd_rekening_'.$dk.',transactions.created_at,"'.$nama_rekening.'" as nama_rekening,"3" as urutan,users.initial,contacts.contact_id as id_kontak,contacts.name as nama_kontak,invoice_no')
                        ->leftJoin('users','transactions.created_by','=','users.id')   
                        ->leftJoin('contacts','transactions.contact_id','=','contacts.id')
                        ->where('transactions.business_id',auth()->user()->business_id)
                        ->where('kd_rekening_'.$dk.'_htg_biaya_kirim',$kd_rekening);
        if($tgl !=null){
            $gethtgptgbiayakirim->whereDate('transaction_date',$thn.'-'.$bln.'-'.$tgl);
        }else{
            if($period == 'bulan_ini'){
                $gethtgptgbiayakirim->whereMonth('transaction_date',$m_now);
            }elseif ($period == 'sd_bulan_lalu') {
                 //1 januari tahun ini - akhir bulan lalu
                $gethtgptgbiayakirim->whereBetween('transaction_date',[$awal_tahun,$akhir_bulan_lalu]);
                $gethtgptgbiayakirim->whereYear('transaction_date',$y_now);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $gethtgptgbiayakirim->whereBetween('transaction_date',[$awal_tahun,$akhir_bulan_ini]);
            }elseif($period == 'komulatif'){
                //sepanjang tahun
                $gethtgptgbiayakirim->whereYear('transaction_date',$y_now);
            }
        }

        $gethtgptgbiayakirim->orderBy('transaction_date','ASC');
                
        $htgptgbiayakirim = $gethtgptgbiayakirim->get()->toArray();

        $gettransaksipayment = TransactionPayment::selectRaw('transactions.id as trxx,transaction_payments.id,paid_on as tanggal,note as keterangan,amount as nominal,payment_ref_no as ref_id,id_rekening_'.$dk.' as kd_rekening_'.$dk.',transaction_payments.created_at,"'.$nama_rekening.'" as nama_rekening,"4" as urutan,users.initial,contacts.contact_id as id_kontak,contacts.name as nama_kontak,invoice_no')
                        ->leftJoin('users','transaction_payments.created_by','=','users.id')   
                        ->join('transactions','transaction_payments.transaction_id','=','transactions.id')
                        ->leftJoin('contacts','transactions.contact_id','=','contacts.id') 
                        ->where('transaction_payments.business_id',auth()->user()->business_id)
                        ->where('id_rekening_'.$dk,$kd_rekening);
        if($tgl !=null){
            $gettransaksipayment->whereDate('paid_on',$thn.'-'.$bln.'-'.$tgl);
        }else{
            if($period == 'bulan_ini'){
                $gettransaksipayment->whereMonth('paid_on',$m_now);
                $gettransaksipayment->whereYear('paid_on',$y_now);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $gettransaksipayment->whereBetween('paid_on',[$awal_tahun,$akhir_bulan_ini]);
                $gettransaksipayment->whereYear('paid_on',$y_now);
            }elseif ($period == 'sd_bulan_lalu') {
                 //1 januari tahun ini - akhir bulan lalu
                $gettransaksipayment->whereBetween('paid_on',[$awal_tahun,$akhir_bulan_lalu]);
                $gettransaksipayment->whereYear('paid_on',$y_now);
            }
            elseif($period == 'komulatif'){
                //sepanjang tahun
                $gettransaksipayment->whereYear('paid_on',$y_now);
            }
        }

        $gettransaksipayment->orderBy('paid_on','ASC');
                
        $transaksipayment = $gettransaksipayment->get()->toArray();

        $getreturpenjualan = TransactionSellLine::selectRaw('transaction_sell_lines.id,transaction_sell_lines.created_at as tanggal,transactions.staff_note as keterangan,(unit_price_inc_tax * quantity_returned) as nominal,lot_no_line_id as ref_id,id_rekening_'.$dk.' as kd_rekening_'.$dk.',transactions.created_at,"'.$nama_rekening.'" as nama_rekening,"5" as urutan,users.initial,contacts.contact_id as id_kontak,contacts.name as nama_kontak,transactions.invoice_no')
                        ->join('transactions','transaction_sell_lines.transaction_id','=','transactions.id')
                        ->leftJoin('users','transactions.created_by','=','users.id')   
                        ->leftJoin('contacts','transactions.contact_id','=','contacts.id') 
                        ->where('transactions.business_id',auth()->user()->business_id)
                        ->where('id_rekening_'.$dk,$kd_rekening);
        if($tgl !=null){
            $getreturpenjualan->whereDate('transaction_sell_lines.created_at',$thn.'-'.$bln.'-'.$tgl);
        }else{
            if($period == 'bulan_ini'){
                $getreturpenjualan->whereMonth('transaction_sell_lines.created_at',$m_now);
                $getreturpenjualan->whereYear('transaction_sell_lines.created_at',$y_now);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $getreturpenjualan->whereBetween('transaction_sell_lines.created_at',[$awal_tahun,$akhir_bulan_ini]);
                $getreturpenjualan->whereYear('transaction_sell_lines.created_at',$y_now);
            }elseif ($period == 'sd_bulan_lalu') {
                 //1 januari tahun ini - akhir bulan lalu
                $getreturpenjualan->whereBetween('transaction_sell_lines.created_at',[$awal_tahun,$akhir_bulan_lalu]);
                $getreturpenjualan->whereYear('transaction_sell_lines.created_at',$y_now);
            }
            elseif($period == 'komulatif'){
                //sepanjang tahun
                $getreturpenjualan->whereYear('transaction_sell_lines.created_at',$y_now);
            }
        }

        $getreturpenjualan->orderBy('transaction_sell_lines.created_at','ASC');
                
        $returnpenjualan = $getreturpenjualan->get()->toArray();

        $getreturpembelian = PurchaseLine::selectRaw('purchase_lines.id,purchase_lines.created_at as tanggal,transactions.staff_note as keterangan,(purchase_price_inc_tax * quantity_returned) as nominal,lot_number as ref_id,id_rekening_'.$dk.' as kd_rekening_'.$dk.',transactions.created_at,"'.$nama_rekening.'" as nama_rekening,"6" as urutan,users.initial,contacts.contact_id as id_kontak,contacts.name as nama_kontak,transactions.invoice_no')
                        ->join('transactions','purchase_lines.transaction_id','=','transactions.id')
                        ->leftJoin('users','transactions.created_by','=','users.id')   
                        ->leftJoin('contacts','transactions.contact_id','=','contacts.id') 
                        ->where('transactions.business_id',auth()->user()->business_id)
                        ->where('id_rekening_'.$dk,$kd_rekening);
        if($tgl !=null){
            $getreturpembelian->whereDate('purchase_lines.created_at',$thn.'-'.$bln.'-'.$tgl);
        }else{
            if($period == 'bulan_ini'){
                $getreturpembelian->whereMonth('purchase_lines.created_at',$m_now);
                $getreturpembelian->whereYear('purchase_lines.created_at',$y_now);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $getreturpembelian->whereBetween('purchase_lines.created_at',[$awal_tahun,$akhir_bulan_ini]);
                $getreturpembelian->whereYear('purchase_lines.created_at',$y_now);
            }elseif ($period == 'sd_bulan_lalu') {
                 //1 januari tahun ini - akhir bulan lalu
                $getreturpembelian->whereBetween('purchase_lines.created_at',[$awal_tahun,$akhir_bulan_lalu]);
                $getreturpembelian->whereYear('purchase_lines.created_at',$y_now);
            }
            elseif($period == 'komulatif'){
                //sepanjang tahun
                $getreturpembelian->whereYear('purchase_lines.created_at',$y_now);
            }
        }

        $getreturpembelian->orderBy('purchase_lines.created_at','ASC');
                
        $returpembelian = $getreturpembelian->get()->toArray();

        $getstockadjustment = StockAdjustmentLine::selectRaw('stock_adjustment_lines.id,stock_adjustment_lines.created_at as tanggal,transactions.staff_note as keterangan,(unit_price * quantity) as nominal,lot_no_line_id as ref_id,id_rekening_'.$dk.' as kd_rekening_'.$dk.',transactions.created_at,"'.$nama_rekening.'" as nama_rekening,"6" as urutan,users.initial,contacts.contact_id as id_kontak,contacts.name as nama_kontak,transactions.invoice_no')
                        ->join('transactions','stock_adjustment_lines.transaction_id','=','transactions.id')
                        ->leftJoin('users','transactions.created_by','=','users.id')   
                        ->leftJoin('contacts','transactions.contact_id','=','contacts.id') 
                        ->where('transactions.business_id',auth()->user()->business_id)
                        ->where('id_rekening_'.$dk,$kd_rekening);
        if($tgl !=null){
            $getstockadjustment->whereDate('stock_adjustment_lines.created_at',$thn.'-'.$bln.'-'.$tgl);
        }else{
            if($period == 'bulan_ini'){
                $getstockadjustment->whereMonth('stock_adjustment_lines.created_at',$m_now);
                $getstockadjustment->whereYear('stock_adjustment_lines.created_at',$y_now);
            }elseif($period == 'sd_bulan_ini'){
                //1 januari tahun ini sampai akhir bulan ini
                $getstockadjustment->whereBetween('stock_adjustment_lines.created_at',[$awal_tahun,$akhir_bulan_ini]);
                $getstockadjustment->whereYear('stock_adjustment_lines.created_at',$y_now);
            }elseif ($period == 'sd_bulan_lalu') {
                 //1 januari tahun ini - akhir bulan lalu
                $getstockadjustment->whereBetween('stock_adjustment_lines.created_at',[$awal_tahun,$akhir_bulan_lalu]);
                $getstockadjustment->whereYear('stock_adjustment_lines.created_at',$y_now);
            }
            elseif($period == 'komulatif'){
                //sepanjang tahun
                $getstockadjustment->whereYear('stock_adjustment_lines.created_at',$y_now);
            }
        }

        $getstockadjustment->orderBy('stock_adjustment_lines.created_at','ASC');
                
        $stockadjustment = $getstockadjustment->get()->toArray();
        
        $total = array_merge($jurnal,$transaksi,$htgptgbiayakirim,$transaksipayment,$returnpenjualan,$returpembelian,$stockadjustment);
       
        return $total;
    }
}
