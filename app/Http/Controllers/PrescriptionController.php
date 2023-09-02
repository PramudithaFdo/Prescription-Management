<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prescription;
use App\Quotation;

class PrescriptionController extends Controller
{
    public function index()
    {
        // Retrieve all prescriptions from the database
        $prescriptions = Prescription::all();

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        return view('prescriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'note' => 'nullable|string',
            'delivery_address' => 'required|string',
            'delivery_time' => 'required|string',
            'prescription_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file upload
        $prescriptionFile = $request->file('prescription_file');
        $fileName = time() . '_' . $prescriptionFile->getClientOriginalName();
        $prescriptionFile->storeAs('prescriptions', $fileName);

        // Create a new Prescription record
        Prescription::create([
            'note' => $request->input('note'),
            'delivery_address' => $request->input('delivery_address'),
            'delivery_time' => $request->input('delivery_time'),
            'prescription_file' => $fileName,
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/prescriptions/create')->with('success', 'Prescription uploaded successfully.');
    }
}

