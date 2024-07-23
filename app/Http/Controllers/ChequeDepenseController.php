<?php

namespace App\Http\Controllers;

use App\BusinessLocation;
use App\ExpenseCategory;
use App\TransactionPayment;
use App\Utils\TransactionUtil;
use Datatables;
use DB;
use Illuminate\Http\Request;

class ChequeDepenseController extends Controller
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
        $expenses = ExpenseCategory::pluck('name', 'id');



        if ($request->ajax()) {
            // Retrieve request parameters

            $expense_id = $request->get('expense_id', null);
            $location_id = $request->get('location_id', null);
            $cheque_status = $request->get('cheque_status', null);
            $business_id = request()->session()->get('user.business_id');
            $business_locations = BusinessLocation::forDropdown($business_id, false);;


            $query = TransactionPayment::join('transactions as t', 'transaction_payments.transaction_id', '=', 't.id')
                ->leftJoin('expense_categories AS e', 't.expense_category_id', '=', 'e.id')
                ->leftJoin('expense_categories AS esc', 't.expense_sub_category_id', '=', 'esc.id')
                ->whereIn('t.type', ['expense', 'expense_refund']);

            // Apply filters
            if (!empty($expense_id)) {
                $query->where('e.id', $expense_id);
            }
            if (!empty($cheque_status)) {
                $query->where('transaction_payments.cheque_status', $cheque_status);
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
                'e.name as expense',
                'transaction_payments.cheque_echeance as chequeEcheance',
                'transaction_payments.cheque_number as chequeNumber',
                't.ref_no as facturNumber',
                'transaction_payments.payment_ref_no as payment_no',
                'transaction_payments.amount as amount',
                DB::raw('TIMESTAMPDIFF(DAY,current_date, transaction_payments.cheque_echeance) as NumberJour'),
                'transaction_payments.cheque_status as chequeStatus'
            ]);
            // Return DataTables response
            return DataTables::of($querys)
                ->addColumn('action', '<button type="button" class="btn btn-info btn-xs edit_payment" 
            data-href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, \'edit\'], [$id]) }}"><i class="glyphicon glyphicon-edit"></i></button>
            &nbsp; 
            <button type="button" class="btn btn-danger btn-xs delete_payment2" 
            data-href="{{ action([\App\Http\Controllers\TransactionPaymentController::class, \'destroy\'], [$id]) }}"
            ><i class="fa fa-trash" aria-hidden="true"></i></button> ')
            ->addColumn('ref_no', function ($row) {
                return '<a href="#" data-href="'.action([\App\Http\Controllers\TransactionPaymentController::class, 'viewPayment'], [$row->id]).'" class="btn-modal view_payment">'.$row->facturNumber.'</a>';
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
                
                    return $statusClass ? '<span class="' . $statusClass . '">' . $row->chequeStatus . '</span>' : $row->chequeStatus;
                })
                ->removeColumn('id')
                ->rawColumns(['action', 'expense', 'chequeEcheance', 'chequeNumber', 'facturNumber', 'payment_no', 'amount', 'NumberJour', 'chequeStatus'])
                ->make(true);
        }

        // Return the view with necessary data
        return view('chequets.cheques_depenses.cheques_depenses', compact('expenses', 'business_locations'));
    }
    public function store(Request $request)
    {
        //
    }

    public function edit($id)
    {
        //   
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request, $id)
    {
        //
    }
}