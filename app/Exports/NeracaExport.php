<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\BusinessLocation;
use App\RekeningRiil;

class NeracaExport implements FromView
{
    public function view(): View
    {
    	$business_id = auth()->user()->business_id;

    	$ra = RekeningRiil::where('posisi',1)->get();
        $rp = RekeningRiil::where('posisi','!=',1)->get();
    	$bl = BusinessLocation::where('business_id','=',$business_id)->first();

        return view('laporan.neraca.excel',['bl'=>$bl,'rekening_aktiva'=>$ra,'rekening_pasiva'=>$rp]);
    }
}