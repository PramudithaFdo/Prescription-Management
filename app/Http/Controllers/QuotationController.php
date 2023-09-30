<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use App\Quotation;
use App\Prescription;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotationSubmitted;
use App\Notifications\QuotaionAcceptNotification;
use App\Notifications\QuotationRejectedNotification;
use App\Notifications\RecievedQuotationNotification;
use App\User;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    public function index()
    {
        // Retrieve all quotations from the database
        $quotations = Quotation::select('quotations.id', 'quotations.drug_name', 'quotations.drug_quantity', 'quotations.drug_amount', 'quotations.status')
            ->leftJoin('prescriptions', 'prescriptions.id', '=', 'quotations.prescription_id')
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
        $photos = Photo::where('prescription_Id', $id)->get();

        return view('prescriptions.quotation', compact('prescription', 'photos'));
    }

    public function storeQuotation(Request $request, $id)
    {
        // Retrieve the prescription by ID
        $prescription = Prescription::findOrFail($id);
        $prescription->quoted = 1;
        $prescription->save();

        // Validate the form input
        $request->validate([
            'drug_name' => 'required|array',
            'drug_name.*' => 'required|string',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer',
            'price' => 'required|array',
            'price.*' => 'required|numeric',
        ]);

        // Create a new quotation record associated with the prescription
        foreach ($request->input('drug_name') as $key => $name) {
            Quotation::create([
                'prescription_id' => $id,
                'drug_name' => $name,
                'drug_quantity' => $request->input('quantity')[$key],
                'drug_amount' => $request->input('price')[$key],
                'user_id' => auth()->user()->id,
            ]);

            $user = User::find($prescription->user_id);
            $user->notify(new RecievedQuotationNotification($name));
        }

        // Need a Mail Server
        // $user = Auth::user(); 
        // Mail::to($user->email)->send(new QuotationSubmitted($user));

        return redirect('/prescriptions')->with('success', 'Quotation submitted successfully.');
    }

    public function acceptQuotation($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'accepted']);
        $drug_name = $quotation->drug_name;
        $user = User::find($quotation->user_id);
        $user->notify(new QuotaionAcceptNotification($drug_name));
        return response()->json(['message' => 'Quotation accepted successfully']);
    }

    public function rejectQuotation($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->update(['status' => 'rejected']);
        $drug_name = $quotation->drug_name;
        $user = User::find($quotation->user_id);
        $user->notify(new QuotationRejectedNotification($drug_name));
        return response()->json(['message' => 'Quotation rejected successfully']);
    }
}
