@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Prescriptions List</h2>
    @if (count($prescriptions) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Note</th>
                    <th>Delivery Address</th>
                    <th>Delivery Time</th>
                    <th>Prescription File</th>
                    <th>Prepare Quotation</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->id }}</td>
                        <td>{{ $prescription->note }}</td>
                        <td>{{ $prescription->delivery_address }}</td>
                        <td>{{ $prescription->delivery_time }}</td>
                        <td>
                            <a href="{{ asset('storage/prescriptions/' . $prescription->prescription_file) }}" target="_blank">
                                View Prescription
                            </a>
                        </td>
                        <td>
                            @if($prescription->quoted === 1)
                            <a>
                                Quotation Prepared
                            </a>
                            @else
                            <a href="/prescriptions/{{ $prescription->id }}/quotation">
                                Prepare Quotation
                            </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No prescriptions uploaded yet.</p>
    @endif
</div>

@endsection

