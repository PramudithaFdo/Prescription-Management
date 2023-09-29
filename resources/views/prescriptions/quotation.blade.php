@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Prepare Quotation for Prescription</h2>
    <div class="row">
    <div class="col-4">
    <p><strong>Note:</strong> {{ $prescription->note }}</p>
    </div>
    <div class="col-4">
    <p><strong>Delivery Time:</strong> {{ $prescription->delivery_time }}</p>
    </div>
    <div class="col-4">
    <p><strong>Delivery Address:</strong> {{ $prescription->delivery_address }}</p>
    </div>
    </div>
    <div class="row">
    <div class="col-4">
    <div id="imageCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        @foreach ($photos as $key => $photo)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/prescriptions/' . $photo->filename) }}" id="photo_gal" class="d-block w-100" alt="Image">
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    </div>
    </div>
    

    <!-- Add prescription file download link here if needed -->
    
    <form action="/prescriptions/{{ $prescription->id }}/quotation" method="post">
        @csrf
  <table class="table" id="drugTable">
    <thead>
        <tr>
            <th>Drug Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="text" class="form-control" name="drug_name[]"></td>
            <td><input type="number" class="form-control" name="quantity[]"></td>
            <td><input type="number" class="form-control" name="price[]"></td>
            <td><a class="btn-success btn-sm" onclick="addRow()">+</a></td>
        </tr>
    </tbody>
</table>
  <br>
        <button type="submit" class="btn btn-primary">Submit Quotation</button>
    </form>
</div>
@endsection
<script>
    function addRow() {
        const table = document.getElementById('drugTable').getElementsByTagName('tbody')[0];
        const lastRow = table.rows[table.rows.length - 1];
        const newRow = lastRow.cloneNode(true);

        // Clear input values in the new row
        const inputs = newRow.getElementsByTagName('input');
        for (let i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }

        table.appendChild(newRow);
    }
</script>
