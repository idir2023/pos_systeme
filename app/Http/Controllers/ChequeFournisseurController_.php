<?php

namespace App\Http\Controllers;
use App\BusinessLocation;
use App\Contact;
use App\CustomerGroup;
use App\TransactionPayment;
use App\Utils\TransactionUtil;
use App\Utils\ProductUtil;
use Datatables;
use DB;
use Illuminate\Http\Request;

class ChequeFournisseurController extends Controller
{
    protected $transactionUtil;

    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }
    public function index(Request $request)
    {
        $business_id = $request->session()->get('user.business_id');

        // Fetch necessary data
        $business_locations = BusinessLocation::forDropdown($business_id, false);
        $suppliers = Contact::suppliersDropdown($business_id, false);

        if (request()->ajax()) {
            // Retrieve request parameters   
            $supplier_id = $request->get('supplier_id', null);
            $location_id = $request->get('location_id', null);
            $cheque_status = $request->get('cheque_status', null);
            $cheque_type = $request->get('cheque_type', null);
            $business_id = request()->session()->get('user.business_id');
            $business_locations = BusinessLocation::forDropdown($business_id, false);;
            $contact_filter2 = !empty($supplier_id) ? "AND (t.contact_id=$supplier_id OR transaction_payments.payment_for=$supplier_id)" : '';
            $cheque_status_filter2 = !empty($cheque_status) ? "AND transaction_payments.cheque_status = '$cheque_status'" :'';

       
            $query = TransactionPayment::leftJoin('transactions as t', function ($join) {
                $join->on('transaction_payments.transaction_id', '=', 't.id')
                    ->orOn('transaction_payments.transaction_id', '=', \DB::raw('null'));
            })
            ->leftJoin('contacts as c', function ($join) {
                $join->on('t.contact_id', '=', 'c.id')
                    ->orOn('transaction_payments.payment_for', '=', 'c.id');
            })
            ->where(function ($q) use ($contact_filter2, $cheque_status_filter2) {
                $q->whereRaw("c.type != 'customer'  $contact_filter2 $cheque_status_filter2 ")
                ->WhereNull('transaction_payments.parent_id');
            });

            if (!empty($cheque_type) ) {
                $query->where('transaction_payments.cheque_type', $cheque_type);
            }
        
            if (!empty($location_id)) {
                $query->where('t.location_id', $location_id);
            }

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');
            
            if (!empty($start_date) && !empty($end_date)) {
                $query->whereBetween(DB::raw('date(transaction_payments.paid_on)'), [$start_date, $end_date]);
            }

            $start_date_echeance = $request->get('start_date_echeance');
            $end_date_echeance = $request->get('end_date_echeance');

            if (!empty($start_date_echeance) && !empty($end_date_echeance)) {
                $query->whereBetween(DB::raw('date(transaction_payments.cheque_echeance)'), [$start_date_echeance, $end_date_echeance]);
            }
            $querys = $query->where('transaction_payments.method','cheque')->select([
                'transaction_payments.cheque_transfered_id as cheque_transfered_id',
                'transaction_payments.id as id',
                'transaction_payments.cheque_type as cheque_type',
                'transaction_payments.cheque_owner as cheque_owner',
                'transaction_payments.bank_name as banque_name',
                DB::raw('COALESCE(t.id, "") as id_invoice'), // Using COALESCE to handle null values
                'c.name as supplier',
                'c.supplier_business_name as supplier_business_name',
                'transaction_payments.cheque_echeance as chequeEcheance',
                'transaction_payments.cheque_number as chequeNumber',
                't.ref_no as invoice_number',
                'transaction_payments.payment_ref_no as payment_no',
                'transaction_payments.amount as amount',
                DB::raw('TIMESTAMPDIFF(DAY,current_date, transaction_payments.cheque_echeance) as NumberJour'),
                'transaction_payments.cheque_status as chequeStatus'
            ]);            

            // Return DataTables response
            return DataTables::of($querys)
            ->editColumn('cheque_type', function ($row) {
                return $row->cheque_type;
            })      
            ->editColumn('cheque_owner', function ($row) {
                return $row->cheque_owner;
            })   
            ->editColumn('banque_name', function ($row) {
                return $row->banque_name;
            })      
            ->editColumn('supplier', function ($row) {
                return $row->supplier ? $row->supplier : $row->supplier_business_name;
            })                    
            ->editColumn('chequeNumber', function ($row) {
                    $query1 = TransactionPayment::find($row->cheque_transfered_id);
                    if($query1->payment_for){
                        $name_contact=Contact::find($query1->payment_for);
                        return $row->chequeNumber . '<br>' . ' (<span class="text text-red">' . ($name_contact->name ? $name_contact->name : $name_contact->first_name .' '. $name_contact->middle_name) . '</span>)';
                    }
                    else{
                        return $row->chequeNumber ;
                    }

            })
            ->editColumn('chequeEcheance', function ($row) {
                //return date('m/d/Y', strtotime($row->chequeEcheance));
                return  $this->transactionUtil->format_date($row->chequeEcheance,false);
            })                         
            ->editColumn('amount', function ($row) {
                    if ($row->chequeStatus == 'En cours') {
                        return '<span class="display_currency paid-amount1" data-orig-value="' . $row->amount . '" data-currency_symbol="true">' . $row->amount . '</span>';
                    } elseif ($row->chequeStatus == 'Déposé') {
                        return '<span class="display_currency paid-amount2" data-orig-value="' . $row->amount . '" data-currency_symbol="true">' . $row->amount . '</span>';
                    } elseif ($row->chequeStatus == 'Encaissé') {
                        return '<span class="display_currency paid-amount3" data-orig-value="' . $row->amount . '" data-currency_symbol="true">' . $row->amount . '</span>';
                    } elseif ($row->chequeStatus == 'Impayé') {
                        return '<span class="display_currency paid-amount4" data-orig-value="' . $row->amount . '" data-currency_symbol="true">' . $row->amount . '</span>';
                    }
            })
                ->editColumn('chequeStatus', function ($row) {
                    $statusClass = '';
                    switch ($row->chequeStatus) {
                        case 'En cours':
                            $statusClass = 'text'; // Couleur bleue pour "En cours"
                            break;
                        case 'Déposé':
                            $statusClass = 'text text-warning'; // Couleur rouge pour "Déposé"
                            break;
                        case 'Encaissé':
                            $statusClass = 'text text-success'; // Couleur verte pour "Encaissé"
                            break;
                        case 'Impayé':
                            $statusClass = 'text text-danger'; // Couleur jaune pour "Impayé"
                            break;
                        default:
                            // Aucune classe par défaut
                    }
                    
                        return '<button type="button" class=" text-bold edit_payment" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'edit2'], [$row->id]) . '">'
                        . ($statusClass ? '<span class="' . $statusClass . '">' . $row->chequeStatus . '</span>' : $row->chequeStatus) .
                        '</button>&nbsp;';                 
                    
                })
                ->editColumn('invoice_number', function ($row) {
                    if($row->id_invoice)
                    {
                        return '<a href="#" data-href="'.action([\App\Http\Controllers\PurchaseController::class, 'show'], [$row->id_invoice]).'" class="btn-modal" data-container=".view_modal">'.$row->invoice_number.'</a>';
                    }
                })   
                ->editColumn('action', function ($row) {
                        $editButton = '<button type="button" class="btn btn-info btn-xs edit_payment" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'edit'], [$row->id]) . '"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
                        $deleteButton = '<button type="button" class="btn btn-danger btn-xs delete_cheque" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'destroy'], [$row->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';         
                        $viewPay = '<button type="button" class="btn btn-primary btn-xs view_payment" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'viewPayment'], [$row->id]) . '"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                                           
                        if ($row->id_invoice == null) {
                            return $deleteButton .' '. $viewPay;
                        } else {
                            return $editButton .' '. $deleteButton .' '. $viewPay;
                        }
                    })                      
                ->removeColumn('id')
                ->rawColumns(['action','id_invoice', 'supplier', 'chequeEcheance', 'chequeNumber', 'invoice_number', 'payment_no', 'amount', 'NumberJour', 'chequeStatus'])
                ->make(true);
        }
        // Return the view with necessary data
        return view('chequets.cheques_fournisseurs.cheques_fournisseurs', compact('customer_groups', 'suppliers', 'business_locations'));
    }

    public function store(Request $request)
    {
    
    }


    public function edit($id)
    {
      
    }


    public function update(Request $request, $id)
    {
    
    }

    public function destroy(Request $request, $id)
    {

    }

    public function getContactCheques(Request $request, $contact_id)
    {
        if ($request->ajax()) {
            $cheques = TransactionPayment::where('contact_id', $contact_id)->get();
            return json_encode($cheques);
        }
    }
}