<?php

namespace App\Http\Controllers;

use App\ChequeGarantie;
use App\Brands;
use App\CashRegister;
use App\Category;
use App\Contact;
use App\CustomerGroup;
use App\ExpenseCategory;
use App\Product;
use App\PurchaseLine;
use App\Restaurant\ResTable;
use App\SellingPriceGroup;
use App\TaxRate;
use App\Transaction;
use App\TransactionPayment;
use App\TransactionSellLine;
use App\TransactionSellLinesPurchaseLines;
use App\BusinessLocation;
use App\Currency;
use App\Media;
use App\Business;
use App\User;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use App\Utils\RestaurantUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use App\VariationLocationDetails;
use Datatables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;


class ChqsClientController extends Controller
{
    protected $transactionUtil;
    public function __construct(TransactionUtil $transactionUtil)
    {
        $this->transactionUtil = $transactionUtil;
    }
    public function index(Request $request)
    {
        $business_id = request()->session()->get('user.business_id');
        $business_locations = BusinessLocation::forDropdown($business_id, false);
        $customers = Contact::customersDropdown($business_id, false);
        $cheque_garants = ChequeGarantie::all();
        if (request()->ajax()) {
            $customer_id = $request->get('customer_id', null);
            $location_id = $request->get('location_id', null);
            $cheque_status = $request->get('cheque_status', null);
            $contact_filter2 = !empty($customer_id) ? "AND cheque_garanties.contact_id=$customer_id" : '';
            $cheque_status_filter2 = !empty($cheque_status) ? "AND cheque_garanties.cheque_status = '$cheque_status'" : '';
            $business_id = request()->session()->get('user.business_id');
            $business_locations = BusinessLocation::forDropdown($business_id, false);

            $query = ChequeGarantie::join(
                'contacts as c',
                'cheque_garanties.contact_id',
                '=',
                'c.id'
            )
                ->where(function ($q) use ($contact_filter2, $cheque_status_filter2) {
                    $q->whereRaw("c.type != 'supplier' $contact_filter2 $cheque_status_filter2");
                });

            $start_date = $request->get('start_date');
            $end_date = $request->get('end_date');

            if (!empty($start_date) && !empty($end_date)) {
                $query->whereBetween(DB::raw('date(cheque_garanties.cheque_dateP)'), [$start_date, $end_date]);
            }

            $start_date_echeance = $request->get('start_date_echeance');
            $end_date_echeance = $request->get('end_date_echeance');

            if (!empty($start_date_echeance) && !empty($end_date_echeance)) {
                $query->whereBetween(DB::raw('date(cheque_garanties.cheque_echeance)'), [$start_date_echeance, $end_date_echeance]);
            }
            $dues = $query->select(
                'cheque_garanties.id as id',
                'cheque_garanties.contact_id as contact_id',
                'c.name as customer',
                'cheque_garanties.cheque_echeance as chequeEcheance',
                'cheque_garanties.cheque_number as chequeNumber',
                'cheque_garanties.amount as amount',
                'cheque_garanties.cheque_status as chequeStatus',
                'cheque_garanties.cheque_dateP as chequeDateP'
            );
            return Datatables::of($dues)
            ->addColumn('action', function ($row) {
                return ' 
                <a class="btn btn-primary btn-xs "  
                href="' . action([\App\Http\Controllers\ChqsClientController::class, 'edit'], [$row->id]) . '">
                <i class="fa fa-edit"></i></a>
                &ensp;<button type="button" class="btn btn-danger btn-xs delete_cheque_garant"
                data-href="' . action([\App\Http\Controllers\ChqsClientController::class, 'destroy'], [$row->id]) . '">
                <i class="fa fa-trash"></i></button>';
            })
            
                ->editColumn('amount', function ($row) {

                    return '<span class="paid-amount" data-orig-value="' . $row->amount . '" 
                >' . $this->transactionUtil->num_f($row->amount, true) . '</span>';
                })
                ->removeColumn('id')
                ->removeColumn('contact_id')
                ->rawColumns(['action', 'customer', 'chequeEcheance', 'chequeNumber', 'chequeStatus', 'chequeDateP', 'amount'])
                ->make(true);
        }


        return view('chequets.chqs_garantie_clients.cheque-client-garanti', compact('cheque_garants', 'customers', 'business_locations'));
    }
    public function create()
    {
       return view('chequets.chqs_garantie_clients.create-cheque-garantie');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'contact_id' => 'required|numeric',
            'cheque_echeance' => 'required|date',
            'amount' => 'required|numeric',
            'cheque_number' => 'required|max:255',
            'cheque_status' => 'required|in:Activate,Desactivate',
            'cheque_dateP' => 'required|date',
        ]);

        // Create a new ChequeGarantie instance
        $cheque = new ChequeGarantie();

        // Assign values to the model attributes
        $cheque->contact_id = $validatedData['contact_id'];
        $cheque->cheque_echeance = $validatedData['cheque_echeance'];
        $cheque->amount = $validatedData['amount'];
        $cheque->cheque_number = $validatedData['cheque_number'];
        $cheque->cheque_status = $validatedData['cheque_status'];
        $cheque->cheque_dateP = $validatedData['cheque_dateP'];
        // Save the model to the database
        $cheque->save();
        // Redirect to the show method of the ContactController
        return redirect()->route('chqs_client.index')->with('success', 'Cheque client added successfully!');
    }

    public function edit($id)
    {
        
        $cheque_client = ChequeGarantie::findOrFail($id);
        $customers = Contact::findOrFail($cheque_client->contact_id);
        return view('chequets.chqs_garantie_clients.edit-cheque-garantie',compact('cheque_client','customers'));

    }
 
    
    public function update(Request $request, $id)
    {
            // Validate the request data
            $validatedData = $request->validate([
                'contact_id'=>'required',
                'cheque_echeance' => 'required|date',
                'amount' => 'required|numeric',
                'cheque_number' => 'required|max:255',
                'cheque_status' => 'required|in:Activate,Desactivate',
                'cheque_dateP' => 'required|date',
                // Add other validation rules as needed
            ]);

            // Find the cheque_garant entry by ID
            $cheque = ChequeGarantie::findOrFail($id);

            // Update the cheque_garant entry with the validated data
            $cheque->update($validatedData);
           
        // Redirect to the show method of the ContactController
        return redirect()->route('chqs_client.index')->with('success', 'Cheque client update successfully!');

    }

    public function destroy(Request $request, $id)
    {
        // Find the cheque_garant entry by ID
        $cheque = ChequeGarantie::find($id);

        if (!$cheque) {
            // Cheque not found, return a JSON error response
            return response()->json(['success' => false, 'msg' => 'Cheque not found'], 404);
        }

        // Delete the cheque_garant entry
        $cheque->delete();

        // Return a JSON success response
        return response()->json(['success' => true, 'msg' => 'Cheque deleted successfully']);
    }

    public function getContactCheques($contact_id)
    {
        if (request()->ajax()) {
            $cheques = ChequeGarantie::where('contact_id', $contact_id)->get();
            return json_encode($cheques);
        }
    }
}
