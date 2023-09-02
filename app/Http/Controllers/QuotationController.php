<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quotation;
use App\Prescription;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationSubmitted;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    public function index()
    {
        // Retrieve all quotations from the database
        $quotations = Quotation::leftJoin('prescriptions', 'prescriptions.id', '=', 'quotations.prescription_id')
                                 ->where('prescriptions.user_id', auth()->user()->id)
                                 ->get();

        return view('quotations.index', compact('quotations'));
    }

    public function accepted()
    {
        // Retrieve all quotations from the database
        $accepted = 'accepted';
        $quotations = Quotation::leftJoin('prescriptions', 'prescriptions.id', '=', 'quotations.prescription_id')
                                 ->where('quotations.status', $accepted)
                                 ->get();

        return view('quotations.accepted', compact('quotations'));
    }

    public function prepareQuotation($id)
    {
        // Retrieve the prescription by ID
        $prescription = Prescription::findOrFail($id);

        return view('prescriptions.quotation', compact('prescription'));
    }

    public function storeQuotation(Request $request, $id)
    {
        // Retrieve the prescription by ID
        $prescription = Prescription::findOrFail($id);
        $prescription->quoted = 1;
        $prescription->save();

        $user = $prescription->user_id;

        // Validate the form input
        $request->validate([
            'drug_name' => 'required|string',
            'drug_quantity' => 'required|integer',
            'drug_amount' => 'required|integer',
        ]);

        // Create a new quotation record associated with the prescription
        $quotation = Quotation::create([
            'prescription_id' => $request->input('prescription_id'),
            'drug_name' => $request->input('drug_name'),
            'drug_quantity' => $request->input('drug_quantity'),
            'drug_amount' => $request->input('drug_amount'),
            'user_id' => auth()->user()->id,
        ]);

        // Need a Mail Server
        // $user = Auth::user(); 
        // Mail::to($user->email)->send(new QuotationSubmitted($user));

        return redirect('/prescriptions')->with('success', 'Quotation submitted successfully.');
    }

    public function acceptQuotation($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'accepted']);
        return response()->json(['message' => 'Quotation accepted successfully']);
    }

    public function rejectQuotation($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'rejected']);
        return response()->json(['message' => 'Quotation rejected successfully']);
    }
}
