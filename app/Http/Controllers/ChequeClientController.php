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

class ChequeClientController extends Controller
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
        $customers = Contact::customersDropdown($business_id, false);
        $customer_groups = CustomerGroup::forDropdown($business_id, false);

        if ($request->ajax()) {
            // Retrieve request parameters
            $CustomerGroup_id = $request->get('CustomerGroup_id', null); // Fix: Added semicolon
            $customer_id = $request->get('customer_id', null);
            $location_id = $request->get('location_id', null);
            $cheque_status = $request->get('cheque_status', null);
            $cheque_type = $request->get('cheque_type', null);
            $business_id = $request->session()->get('user.business_id');
            $business_locations = BusinessLocation::forDropdown($business_id, false);
            $contact_filter2 = !empty($customer_id) ? "AND (t.contact_id=$customer_id OR transaction_payments.payment_for=$customer_id)" : '';
            $cheque_status_filter2 = !empty($cheque_status) ? "AND transaction_payments.cheque_status = '$cheque_status'" : '';

            // Build the query
            $query = TransactionPayment::leftJoin('transactions as t', function ($join) {
                $join->on('transaction_payments.transaction_id', '=', 't.id')
                    ->orOn('transaction_payments.transaction_id', '=', \DB::raw('null'));
            })
            ->leftJoin('contacts as c', function ($join) {
                $join->on('t.contact_id', '=', 'c.id')
                    ->orOn('transaction_payments.payment_for', '=', 'c.id');
            })
            ->where(function ($q) use ($contact_filter2, $cheque_status_filter2) {
                $q->whereRaw("c.type != 'supplier' $contact_filter2 $cheque_status_filter2")
                ->WhereNull('transaction_payments.parent_id');
            });

            // Apply filters
            if (!empty($CustomerGroup_id)) {
                $query->where('c.customer_group_id', $CustomerGroup_id);
            }

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
                'transaction_payments.id as id',
                DB::raw('COALESCE(t.id, "") as id_invoice'),
                'c.name as customer',
                'transaction_payments.cheque_type as cheque_type',
                'transaction_payments.cheque_owner as cheque_owner',
                'transaction_payments.bank_name as banque_name',
                'transaction_payments.cheque_echeance as chequeEcheance',
                'transaction_payments.cheque_number as chequeNumber',
                't.invoice_no as facturNumber',
                'transaction_payments.payment_ref_no as payment_no',
                'transaction_payments.amount as amount',
                DB::raw('TIMESTAMPDIFF(DAY, current_date, transaction_payments.cheque_echeance) as NumberJour'),
                'transaction_payments.cheque_status as chequeStatus',
                'transaction_payments.cheque_transfered_id as id_transfed'
            ]);
            // Return DataTables response
            return Datatables::of($querys)   
            ->editColumn('facturNumber', function ($row) {
                if($row->id_invoice)
                {
                    return '<a href="#" data-href="' . action([\App\Http\Controllers\SellController::class, 'show'], [$row->id_invoice]) . '" class="btn-modal" data-container=".view_modal">' . $row->facturNumber . '</a>';
                }
            })   
            ->editColumn('cheque_type', function ($row) {
                return $row->cheque_type;
            })  
            ->editColumn('banque_name', function ($row) {
                return $row->banque_name;
            })      
            ->editColumn('cheque_owner', function ($row) {
                return $row->cheque_owner;
            })          
            ->editColumn('amount', function ($row) {
                    $statusClass = '';
                    switch ($row->chequeStatus) {
                        case 'En cours':
                            $statusClass = 'paid-amount1';
                            break;
                        case 'Déposé':
                            $statusClass = 'paid-amount2';
                            break;
                        case 'Encaissé':
                            $statusClass = 'paid-amount3';
                            break;
                        case 'Impayé':
                            $statusClass = 'paid-amount4';
                            break;
                    }
                    return '<span class="display_currency ' . $statusClass . '" data-orig-value="' . $row->amount . '" data-currency_symbol="true">' . $row->amount . '</span>';
                })        
                ->editColumn('chequeStatus', function ($row) {
                    $statusClass = '';
                   
                    // Remove the unnecessary single quote in the next line
                    $chequeS = $row->chequeStatus .' '.'<span class="text text-success">(TR)</span>';
                
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
                            // If you want to set a default class, add it here
                            break;
                    }
                
                    // Change the condition to check for string equality, and remove unnecessary concatenation
                    if ($row->id_transfed == 1) {
                        return $statusClass ? '<span class="' . $statusClass . '">' . $chequeS . '</span>' : $row->chequeStatus;
                    } else {
                        
                            return '<button type="button" class=" text-bold edit_payment" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'edit2'], [$row->id]) . '">'
                            . ($statusClass ? '<span class="' . $statusClass . '">' . $row->chequeStatus . '</span>' : $row->chequeStatus) .
                            '</button>&nbsp;';                 
                        } 
                })
                ->editColumn('chequeEcheance', function ($row) {
                    //return date('m/d/Y', strtotime($row->chequeEcheance));
                    return $this->transactionUtil->format_date($row->chequeEcheance,false);
                })                                                 
                ->addColumn('action', function ($row) {
                    $editButton = '<button type="button" class="btn btn-info btn-xs edit_payment" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'edit'], [$row->id]) . '"><i class="glyphicon glyphicon-edit"></i></button>&nbsp;';
                    $deleteButton = '<button type="button" class="btn btn-danger btn-xs delete_payment1" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'destroy'], [$row->id]) . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    $transferLink = '<a href="'.action([\App\Http\Controllers\TransactionPaymentController::class, 'getTransfert'], [$row->id]).'?type=purchase" class="btn btn-success btn-xs pay_purchase_due"><i class="fas fa-money-bill-alt" aria-hidden="true"></i></a>';
                    $viewPay = '<button type="button" class="btn btn-primary btn-xs view_payment" data-href="' . action([\App\Http\Controllers\TransactionPaymentController::class, 'viewPayment'], [$row->id]) . '"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                
                    if ($row->id_transfed == 1) {
                        return $viewPay;
                    } else {
                        if ($row->id_invoice == null) {
                            return $transferLink .' '. $viewPay;
                        } else {
                            return $editButton .' '. $transferLink .' '. $viewPay;
                        } 
                    }
                })
                                                  
                ->removeColumn('id')
                ->removeColumn('id_invoice')
                ->removeColumn('id_transfed')
                ->rawColumns(['action', 'customer', 'chequeEcheance', 'chequeNumber', 'facturNumber', 'payment_no', 'amount', 'NumberJour', 'chequeStatus'])
                ->make(true);
            }

        // Return the view with necessary data
        return view('chequets.cheques_clients.cheques_clients', compact('customer_groups','number','customers', 'business_locations'));
    }

    public function store(Request $request)
    {
        // Your store method logic here
    }

    public function edit($id)
    {
        // Your edit method logic here
    }

    public function update(Request $request, $id)
    {
        // Your update method logic here
    }

    public function destroy(Request $request, $id)
    {
        // Your destroy method logic here
    }
}