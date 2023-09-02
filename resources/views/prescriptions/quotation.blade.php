@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Prepare Quotation for Prescription</h2>
    <div class="row">
    <div class="col">
    <p><strong>Note:</strong> {{ $prescription->note }}</p>
    </div>
    <div class="col">
    <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
    </div>
    </div>

    <div class="row">
    <div class="col">
    <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>
    </div>
    <div class="col">
    <img  src="{{ asset('storage/prescriptions/' . $prescription->prescription_file) }}" alt="Prescription Image" style="width: 500px; height: 300px;">
    </div>
    </div>

    <!-- Add prescription file download link here if needed -->
    
    <form action="/prescriptions/{{ $prescription->id }}/quotation" method="post">
        @csrf
        <!-- Add quotation input fields here -->
<input hidden id="prescription_id" name="prescription_id" value="{{ $prescription->id }}">
    <!-- Drug Amount -->
    <div class="row">
    <div class="col-6">
    <label for="drug_name">Drug Name</label>
    <input type="text" class="form-control" id="drug_name" name="drug_name" required>
    </div>
    </div>
    <div class="row">
    <div class="col">
    <label for="drug_quantity">Drug Quantity</label>
        <input type="number" class="form-control" id="drug_quantity" name="drug_quantity" required>
    </div>
    <div class="col">
    <label for="drug_amount">Drug Amount</label>
            <input type="number" class="form-control" id="drug_amount" name="drug_amount" required>
    </div>
  </div>
  <br>
        <button type="submit" class="btn btn-primary">Submit Quotation</button>
    </form>
</div>
@endsection
