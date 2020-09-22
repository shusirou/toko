<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\JenisBuku;
use App\Rekening;
use App\Jurnal;
use App\TransactionPayment;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!auth()->user()->can('jurnal.view') && !auth()->user()->can('jurnal.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $columns = ['jurnal.id','nama_jb','kd_rekening_debit','kd_rekening_kredit','tanggal_jurnal','nominal'];
            $business_id = request()->session()->get('user.business_id');
            $jurnal = Jurnal::select($columns)
                            ->leftJoin('jenis_buku','jurnal.kd_jenis_buku','=','jenis_buku.kd_jb')
                           // ->leftJoin('rekening','jurnal.kd_rekening','=','rekening.kd_rekening')
                            ->where('jurnal.business_id', $business_id)
                            ->groupBy('jurnal.id');
            return Datatables::of($jurnal)
                ->addColumn(
                    'action',
                    '@can("jurnal.update")
                    <button data-href="{{action(\'JurnalController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_jurnal_button"><i class="glyphicon glyphicon-edit"></i>  @lang("messages.edit")</button>
                        &nbsp;
                    @endcan
                    @can("jurnal.delete")
                        <button data-href="{{action(\'JurnalController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_jurnal_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
                )
                ->editColumn('jenis_mutasi',function($row){
                    return ucfirst($row->jenis_mutasi);
                })
                ->editColumn('tanggal_jurnal',function($row){
                    return $row->tanggal_jurnal->format('d F Y');
                })
                 ->editColumn('nominal',function($row){
                    return "Rp ".number_format($row->nominal);
                })
                ->removeColumn('id')
                ->rawColumns([5])
                ->make(false);
        }
        return view('jurnal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenisbuku = JenisBuku::whereNotIn('posisi',['4','5'])->get();
        $rekening  = Rekening::all();
        $hutang    = TransactionPayment::selectRaw('transaction_payments.id as id,transaction_payments.amount,transaction_payments.payment_ref_no')
        ->leftJoin('transactions','transaction_payments.transaction_id','=','transactions.id')
        ->where('method','tempo')
        ->where('type','purchase')
        ->where('status','received')
        ->where('transaction_payments.business_id',auth()->user()->business_id)->get();
       
        return view('jurnal.form',['jenisbuku'=>$jenisbuku,'rekening'=>$rekening,'hutang'=>$hutang]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try { 

            $tanggaljurnal         = \Carbon::parse($request->tanggaljurnal)->format('Y-m-d');
            $business_id           = request()->session()->get('user.business_id');
            $jurnal                = new Jurnal;
            $jurnal->business_id   = $business_id;
            $jurnal->kd_jenis_buku = $request->jenisbuku;
            $jurnal->jenis_mutasi  = $request->jenismutasi;
            if($request->jenismutasi == 'debit'){
                $jurnal->kd_rekening_debit  = $request->namarekening;
                $jurnal->kd_rekening_kredit   = $request->namarekeningpasangan;
            }else{
                $jurnal->kd_rekening_kredit  = $request->namarekening;
                $jurnal->kd_rekening_debit   = $request->namarekeningpasangan;
            }
            
            $jurnal->tanggal_jurnal= $tanggaljurnal;
            $jurnal->keterangan    = $request->keterangan;
            $jurnal->nominal       = $request->nominal;
            $jurnal->ref_id        = $request->refhutang;
            $jurnal->created_by    = auth()->user()->id;
            $jurnal->save();

            $output = ['success'   => true,
                            'data' => $jurnal,
                            'msg'  => 'Data Jurnal tersimpan'
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                       'msg'     => __("messages.something_went_wrong")];
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edt       = Jurnal::find($id);
        $jenisbuku = JenisBuku::all();
        $rekening  = Rekening::all();
        $hutang    = TransactionPayment::selectRaw('transaction_payments.id as id,transaction_payments.amount,transaction_payments.payment_ref_no')
        ->leftJoin('transactions','transaction_payments.transaction_id','=','transactions.id')
        ->where('method','tempo')
        ->where('type','purchase')
        ->where('status','received')
        ->where('transaction_payments.business_id',auth()->user()->business_id)->get();
       
        return view('jurnal.edt_form',['jenisbuku'=>$jenisbuku,'rekening'=>$rekening,'edt'=>$edt,'hutang'=>$hutang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try { 

            $tanggaljurnal         = \Carbon::parse($request->tanggaljurnal)->format('Y-m-d');
            $business_id           = request()->session()->get('user.business_id');
            $jurnal                = Jurnal::find($id);
            $jurnal->business_id   = $business_id;
            $jurnal->kd_jenis_buku = $request->jenisbuku;
            $jurnal->jenis_mutasi  = $request->jenismutasi;
            if($request->jenismutasi == 'debit'){
                $jurnal->kd_rekening_debit  = $request->namarekening;
                $jurnal->kd_rekening_kredit   = $request->namarekeningpasangan;
            }else{
                $jurnal->kd_rekening_kredit  = $request->namarekening;
                $jurnal->kd_rekening_debit   = $request->namarekeningpasangan;
            }
            $jurnal->tanggal_jurnal= $tanggaljurnal;
            $jurnal->keterangan    = $request->keterangan;
            $jurnal->nominal       = $request->nominal;
            $jurnal->ref_id        = $request->refhutang;
            $jurnal->created_by    = auth()->user()->id;
            $jurnal->save();

            $output = ['success'   => true,
                            'data' => $jurnal,
                            'msg'  => 'Data Jurnal tersimpan'
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                       'msg'     => __("messages.something_went_wrong")];
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->can('jurnal.delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $jurnal = Jurnal::where('business_id', $business_id)->findOrFail($id);
                $jurnal->delete();

                $output = ['success' => true,
                            'msg' => "Data transaksi jurnal terhapus"
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }

    public function getRekening($id_jenis_buku)
    {
        $rekening = Rekening::where('kd_jb','=',$id_jenis_buku)->get();

        return response()->json(['success'=>true,'rekening'=>$rekening]);
    }

    public function getPasangan($id_rekening)
    {
        $pasangan = Rekening::where('kd_rekening','=',$id_rekening)->first();

        return response()->json(['success'=>true,'pasangan'=>$pasangan]);
    }

    public function getHutang($id)
    {
        $tp = TransactionPayment::find($id);

        return response()->json(['success'=>true,'tp'=>$tp->amount]);
    }
}
