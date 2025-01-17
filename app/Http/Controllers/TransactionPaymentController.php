<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Utils\TransactionUtil;
use App\Utils\ModuleUtil;

use App\TransactionPayment, App\Contact;
use App\Transaction;

use DB;
use App\Events\TransactionPaymentAdded,
    App\Events\TransactionPaymentUpdated,
    App\Events\TransactionPaymentDeleted;

class TransactionPaymentController extends Controller
{
    protected $transactionUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param TransactionUtil $transactionUtil
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil, ModuleUtil $moduleUtil)
    {
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $business_id = $request->session()->get('user.business_id');
            $transaction_id = $request->input('transaction_id');
            $transaction = Transaction::where('business_id', $business_id)->findOrFail($transaction_id);
           
            if (!auth()->user()->can('purchase.payments') || !auth()->user()->can('sell.payments')) {
                abort(403, 'Unauthorized action.');
            }

            if ($transaction->payment_status != 'paid') {
                $inputs = $request->only(['amount', 'method', 'note', 'card_number', 'card_holder_name',
                'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
                'cheque_number', 'bank_account_number']);
                $inputs['paid_on']            = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
                $inputs['transaction_id']     = $transaction->id;
                $inputs['amount']             = $this->transactionUtil->num_uf($inputs['amount']);
                $inputs['created_by']         = auth()->user()->id;
                $inputs['payment_for']        = $transaction->contact_id;
             
                if($request->input('method') == 'cash'){
                    if($transaction->type == 'purchase'){
                        //pembayaran hutang
                        $inputs['id_rekening_debit']  = '211.02';
                        $inputs['id_rekening_kredit'] = '111.23';
                    }elseif($transaction->type == 'sell'){
                        //pembayaran piutang
                        $inputs['id_rekening_debit']  = '111.08';
                        $inputs['id_rekening_kredit'] = '132.03';  
                    }
                }else{
                    if($transaction->type == 'purchase'){
                        $inputs['id_rekening_debit']  = '211.03';
                        $inputs['id_rekening_kredit'] = '121.08';
                    }elseif($transaction->type == 'sell'){
                        $inputs['id_rekening_debit']  = '121.04';
                        $inputs['id_rekening_kredit'] = '132.04';  
                    }
                }

                if ($inputs['method'] == 'custom_pay_1') {
                    $inputs['transaction_no'] = $request->input('transaction_no_1');
                } else if ($inputs['method'] == 'custom_pay_2') {
                    $inputs['transaction_no'] = $request->input('transaction_no_2');
                } else if ($inputs['method'] == 'custom_pay_3') {
                    $inputs['transaction_no'] = $request->input('transaction_no_3');
                }

                if(!empty($request->input('account_id'))){
                    $inputs['account_id'] = $request->input('account_id');
                }

                $prefix_type = 'purchase_payment';
                if (in_array($transaction->type, ['sell', 'sell_return'])) {
                    $prefix_type = 'sell_payment';
                } else if($transaction->type == 'expense'){
                    $prefix_type = 'expense_payment';
                }

                DB::beginTransaction();

                $ref_count = $this->transactionUtil->setAndGetReferenceCount($prefix_type);
                //Generate reference number
                $inputs['payment_ref_no'] = $this->transactionUtil->generateReferenceNumber($prefix_type, $ref_count);

                $inputs['business_id'] = $request->session()->get('business.id');

                //SHIPPING
                 $shipping = $request->only(['amount', 'method', 'note', 'card_number', 'card_holder_name',
                'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
                'cheque_number', 'bank_account_number']);
                $shipping['paid_on'] = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
                $shipping['transaction_id']     = $transaction->id;
                $shipping['amount']             = $this->transactionUtil->num_uf($request->input('shipping_charges'));
                $shipping['created_by']         = auth()->user()->id;
                $shipping['payment_for']        = $transaction->contact_id;
                if($transaction->type == 'purchase'){ 
                    $shipping['id_rekening_debit']  = '213.04';
                    $shipping['id_rekening_kredit'] = '111.34';
                }elseif($transaction->type == 'sell'){
                    $shipping['id_rekening_debit']  = '111.36';
                    $shipping['id_rekening_kredit'] = '133.02';
                }
                $shipping['payment_ref_no'] = $this->transactionUtil->generateReferenceNumber($prefix_type, $ref_count);
                $shipping['business_id'] = $request->session()->get('business.id');
               
                $tp = TransactionPayment::create($inputs);
                
                if($this->transactionUtil->num_uf($request->input('shipping_charges')) > 0){
                    $sp = TransactionPayment::create($shipping);
                }

                //update payment status
                $this->transactionUtil->updatePaymentStatus($transaction_id, $transaction->final_total);
                DB::commit();

                $inputs['transaction_type'] = $transaction->type;
                event(new TransactionPaymentAdded($tp, $inputs));
            }

            $output = ['success' => true,
                            'msg' => __('purchase.payment_added_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                          'msg' => __('messages.something_went_wrong')
                      ];
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
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $transaction = Transaction::where('id', $id)
                                        ->with(['contact', 'business'])
                                        ->first();

            $payments_query = TransactionPayment::leftJoin('rekening','transaction_payments.id_rekening_debit','=','rekening.kd_rekening')
                                                ->where('transaction_id', $id)
                                                ->whereNotIn('id_rekening_kredit',['131.08','411.04','411.02'])
                                                ->whereRaw('LEFT(id_rekening_debit,2) != 51')
                                                ->groupBy('transaction_payments.id');    

            $accounts_enabled = false;
            if($this->moduleUtil->isModuleDefined('account')){
                $accounts_enabled = true;
                $payments_query->with(['payment_account']);
            }

            $payments = $payments_query->get();
                                 
            $payment_types = $this->transactionUtil->payment_types();
            
            return view('transaction_payment.show_payments')
                    ->with(compact('transaction', 'payments', 'payment_types', 'accounts_enabled'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $payment_line = TransactionPayment::findOrFail($id);

            $transaction = Transaction::where('id', $payment_line->transaction_id)
                                        ->where('business_id', $business_id)
                                        ->with(['contact', 'location'])
                                        ->first();

            $payment_types = $this->transactionUtil->payment_types();

            //Accounts
            $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

            return view('transaction_payment.edit_payment_row')
                        ->with(compact('transaction', 'payment_types', 'payment_line', 'accounts'));
        }
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
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $inputs = $request->only(['amount', 'method', 'note', 'card_number', 'card_holder_name',
            'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
            'cheque_number', 'bank_account_number']);
            $inputs['paid_on'] = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
            $inputs['amount'] = $this->transactionUtil->num_uf($inputs['amount']);

            if ($inputs['method'] == 'custom_pay_1') {
                $inputs['transaction_no'] = $request->input('transaction_no_1');
            } else if ($inputs['method'] == 'custom_pay_2') {
                $inputs['transaction_no'] = $request->input('transaction_no_2');
            } else if ($inputs['method'] == 'custom_pay_3') {
                $inputs['transaction_no'] = $request->input('transaction_no_3');
            }

            if(!empty($request->input('account_id'))){
                $inputs['account_id'] = $request->input('account_id');
            }

            $payment = TransactionPayment::findOrFail($id);

            $business_id = $request->session()->get('user.business_id');

            $transaction = Transaction::where('business_id', $business_id)
                                ->find($payment->transaction_id);
                                
            DB::beginTransaction();

            $payment->update($inputs);

            //update payment status
            $this->transactionUtil->updatePaymentStatus($payment->transaction_id);

            DB::commit();

            //event
            event(new TransactionPaymentUpdated($payment, $transaction->type));

            $output = ['success' => true,
                            'msg' => __('purchase.payment_updated_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                          'msg' => __('messages.something_went_wrong')
                      ];
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
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $payment = TransactionPayment::findOrFail($id);

                $payment->delete();
                
                //update payment status
                $this->transactionUtil->updatePaymentStatus($payment->transaction_id);
                
                event(new TransactionPaymentDeleted($payment->id, $payment->account_id));

                $output = ['success' => true,
                                'msg' => __('purchase.payment_deleted_success')
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                
                $output = ['success' => false,
                                'msg' => __('messages.something_went_wrong')
                            ];
            }

            return $output;
        }
    }

    /**
     * Adds new payment to the given transaction.
     *
     * @param  int  $transaction_id
     * @return \Illuminate\Http\Response
     */
    public function addPayment($transaction_id)
    {
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $transaction = Transaction::where('id', $transaction_id)
                                        ->where('business_id', $business_id)
                                        ->with(['contact', 'location'])
                                        ->first();

            if ($transaction->payment_status != 'paid') {
                $payment_types    = $this->transactionUtil->payment_types();
                $paid_amount      = $this->transactionUtil->getTotalPaid($transaction_id);
                $paid_shipping    = $this->transactionUtil->getTotalPaidShipping($transaction_id,$transaction->type) != null ? $this->transactionUtil->getTotalPaidShipping($transaction_id,$transaction->type)->total_paid_shipping : 0;
                $amount           = (($transaction->final_total - $transaction->shipping_charges) + $paid_shipping) - $paid_amount;
               
                $shipping_charges = $transaction->shipping_charges - $paid_shipping;
                if ($amount < 0) {
                    $amount = 0;
                }

                $amount_formated = $this->transactionUtil->num_f($amount);

                $payment_line = new TransactionPayment();
                $payment_line->amount = $amount;
                $payment_line->method = 'cash';
                $payment_line->paid_on = \Carbon::now()->toDateString();

                //Accounts
                $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

                $view = view('transaction_payment.payment_row')
                ->with(compact('transaction', 'payment_types', 'payment_line', 'amount_formated', 'accounts','shipping_charges'))->render();

                $output = [ 'status' => 'due',
                                    'view' => $view];
            } else {
                $output = [ 'status' => 'paid',
                                'view' => '',
                                'msg' => __('purchase.amount_already_paid')  ];
            }

            return json_encode($output);
        }
    }

    /**
     * Shows contact's payment due modal
     *
     * @param  int  $contact_id
     * @return \Illuminate\Http\Response
     */
    public function getPayContactDue($contact_id)
    {
        if (!auth()->user()->can('purchase.create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $due_payment_type = request()->input('type');
            $query = Contact::where('contacts.id', $contact_id)
                            ->join('transactions AS t', 'contacts.id', '=', 't.contact_id');
            if($due_payment_type == 'purchase'){
                    $query->select(
                        DB::raw("SUM(IF(t.type = 'purchase', final_total, 0)) as total_purchase"),
                        DB::raw("SUM(IF(t.type = 'purchase', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                        'contacts.name',
                        'contacts.supplier_business_name',
                        'contacts.id as contact_id'
                    );
            } else if($due_payment_type == 'purchase_return'){
                    $query->select(
                        DB::raw("SUM(IF(t.type = 'purchase_return', final_total, 0)) as total_purchase_return"),
                        DB::raw("SUM(IF(t.type = 'purchase_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                        'contacts.name',
                        'contacts.supplier_business_name',
                        'contacts.id as contact_id'
                    );
            } else if($due_payment_type == 'sell'){
                $query->select(
                        DB::raw("SUM(IF(t.type = 'sell', final_total, 0)) as total_invoice"),
                        DB::raw("SUM(IF(t.type = 'sell', (SELECT SUM(IF(is_return = 1,-1*amount,amount)) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_paid"),
                        'contacts.name',
                        'contacts.supplier_business_name',
                        'contacts.id as contact_id'
                    );
            } else if($due_payment_type == 'sell_return'){
                    $query->select(
                        DB::raw("SUM(IF(t.type = 'sell_return', final_total, 0)) as total_sell_return"),
                        DB::raw("SUM(IF(t.type = 'sell_return', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as total_return_paid"),
                        'contacts.name',
                        'contacts.supplier_business_name',
                        'contacts.id as contact_id'
                    );
            }

            //Query for opening balance details
            $query->addSelect(
                    DB::raw("SUM(IF(t.type = 'opening_balance', final_total, 0)) as opening_balance"),
                    DB::raw("SUM(IF(t.type = 'opening_balance', (SELECT SUM(amount) FROM transaction_payments WHERE transaction_payments.transaction_id=t.id), 0)) as opening_balance_paid")
                );
            $contact_details = $query->first();
            
            $payment_line = new TransactionPayment();
            if($due_payment_type == 'purchase'){
                $contact_details->total_purchase = empty($contact_details->total_purchase) ? 0 : $contact_details->total_purchase;
                $payment_line->amount = $contact_details->total_purchase -
                                    $contact_details->total_paid;
            } else if ($due_payment_type == 'purchase_return'){
                $payment_line->amount = $contact_details->total_purchase_return -
                                    $contact_details->total_return_paid;
            } else if ($due_payment_type == 'sell') {
                $contact_details->total_invoice = empty($contact_details->total_invoice) ? 0 : $contact_details->total_invoice;

                $payment_line->amount = $contact_details->total_invoice -
                                    $contact_details->total_paid;
            } else if ($due_payment_type == 'sell_return') {

                $payment_line->amount = $contact_details->total_sell_return -
                                    $contact_details->total_return_paid;
            }

            //If opening balance due exists add to payment amount
            $contact_details->opening_balance = !empty($contact_details->opening_balance) ? $contact_details->opening_balance : 0;
            $contact_details->opening_balance_paid = !empty($contact_details->opening_balance_paid) ? $contact_details->opening_balance_paid : 0;
            $ob_due = $contact_details->opening_balance - $contact_details->opening_balance_paid;
            if($ob_due > 0){
                $payment_line->amount += $ob_due;
            }

            $amount_formated = $this->transactionUtil->num_f($payment_line->amount);

            $contact_details->total_paid = empty($contact_details->total_paid) ? 0 : $contact_details->total_paid;
            
            $payment_line->method = 'cash';
            $payment_line->paid_on = \Carbon::now()->toDateString();
                   
            $payment_types = $this->transactionUtil->payment_types();

            //Accounts
            $accounts = $this->moduleUtil->accountsDropdown($business_id, true);

            if ($payment_line->amount > 0) {
                return view('transaction_payment.pay_supplier_due_modal')
                        ->with(compact('contact_details', 'payment_types', 'payment_line', 'due_payment_type', 'ob_due', 'amount_formated', 'accounts'));
            }
        }
    }

    /**
     * Adds Payments for Contact due
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPayContactDue(Request  $request)
    {
        if (!auth()->user()->can('purchase.create') && !auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $contact_id = $request->input('contact_id');
            $inputs = $request->only(['amount', 'method', 'note', 'card_number', 'card_holder_name',
                'card_transaction_number', 'card_type', 'card_month', 'card_year', 'card_security',
                'cheque_number', 'bank_account_number']);
            $inputs['paid_on'] = \Carbon::createFromFormat('m/d/Y', $request->input('paid_on'))->toDateTimeString();
            $inputs['amount'] = $this->transactionUtil->num_uf($inputs['amount']);
            $inputs['created_by'] = auth()->user()->id;
            $inputs['payment_for'] = $contact_id;
            $inputs['business_id'] = $request->session()->get('business.id');

            if ($inputs['method'] == 'custom_pay_1') {
                $inputs['transaction_no'] = $request->input('transaction_no_1');
            } else if ($inputs['method'] == 'custom_pay_2') {
                $inputs['transaction_no'] = $request->input('transaction_no_2');
            } else if ($inputs['method'] == 'custom_pay_3') {
                $inputs['transaction_no'] = $request->input('transaction_no_3');
            }
            $due_payment_type = $request->input('due_payment_type');
            
            $prefix_type = 'purchase_payment';
            if (in_array($due_payment_type, ['sell', 'sell_return'])) {
                $prefix_type = 'sell_payment';
            }
            $ref_count = $this->transactionUtil->setAndGetReferenceCount($prefix_type);
            //Generate reference number
            $payment_ref_no = $this->transactionUtil->generateReferenceNumber($prefix_type, $ref_count);

            $inputs['payment_ref_no'] = $payment_ref_no;

            if(!empty($request->input('account_id'))){
                $inputs['account_id'] = $request->input('account_id');
            }

            DB::beginTransaction();

            $parent_payment = TransactionPayment::create($inputs);

            $inputs['transaction_type'] = $due_payment_type;
            
            event(new TransactionPaymentAdded($parent_payment, $inputs));

            //Distribute above payment among unpaid transactions

            $this->transactionUtil->payAtOnce($parent_payment, $due_payment_type);

            DB::commit();
            $output = ['success' => true,
                            'msg' => __('purchase.payment_added_success')
                        ];
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                          'msg' => __('messages.something_went_wrong')
                      ];
        }

        return $output;
    }

    /**
     * view details of single..,
     * payment.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function viewPayment($payment_id)
    {
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('business.id');
            $single_payment_line = TransactionPayment::findOrFail($payment_id);

            $transaction = null;
            if (!empty($single_payment_line->transaction_id)) {
                $transaction = Transaction::where('id', $single_payment_line->transaction_id)
                                            ->with(['contact', 'location'])
                                            ->first();
            } else {

                $child_payment = TransactionPayment::where('business_id', $business_id)
                                                    ->where('parent_id', $payment_id)
                                                    ->with(['transaction', 'transaction.contact', 'transaction.location'])
                                                    ->first();
                $transaction = $child_payment->transaction;

            }

            $payment_types = $this->transactionUtil->payment_types();
            
            return view('transaction_payment.single_payment_view')
                    ->with(compact('single_payment_line', 'transaction', 'payment_types'));
        }
    }

    /**
     * Retrieves all the child payments of a parent payments 
     * payment.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showChildPayments($payment_id)
    {
        if (!auth()->user()->can('purchase.payments') && !auth()->user()->can('sell.payments')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $business_id = request()->session()->get('business.id');

            $child_payments = TransactionPayment::where('business_id', $business_id)
                                                    ->where('parent_id', $payment_id)
                                                    ->with(['transaction', 'transaction.contact'])
                                                    ->get();

            $payment_types = $this->transactionUtil->payment_types();
            
            return view('transaction_payment.show_child_payments')
                    ->with(compact('child_payments', 'payment_types'));
        }
    }
}
