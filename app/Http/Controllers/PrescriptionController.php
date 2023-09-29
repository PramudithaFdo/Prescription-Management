<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;
use App\Prescription;

class PrescriptionController extends Controller
{
    public function index()
    {
        // Retrieve all prescriptions from the database
        $prescriptions = Prescription::all();
        $photos = Photo::all();

        return view('prescriptions.index', compact('prescriptions', 'photos'));
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
        ]);

        $validatedData = $request->validate([
            'photos.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Create a new Prescription record
        $prescription = Prescription::create([
            'note' => $request->input('note'),
            'delivery_address' => $request->input('delivery_address'),
            'delivery_time' => $request->input('delivery_time'),
            'user_id' => auth()->user()->id,
        ]);

        $prescriptionId = $prescription->id;

        foreach ($validatedData['photos'] as $photo) {
            // $filename = $photo->store('photos', 'public');
            $prescriptionFile = $photo;
            $fileName = time() . '_' . $prescriptionFile->getClientOriginalName();
            $prescriptionFile->storeAs('prescriptions', $fileName);
    
            // Save the photo information to the database
            Photo::create([
                'prescription_Id' => $prescriptionId,
                'filename' => $fileName,
            ]);
        }

        return redirect('/prescriptions/create')->with('success', 'Prescription uploaded successfully.');
    }
}

