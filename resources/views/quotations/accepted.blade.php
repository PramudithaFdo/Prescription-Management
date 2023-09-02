@extends('layouts.admin')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')
<div class="container">
    <h2>Quotations List</h2>
    @if (count($quotations) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Drug Name</th>
                    <th>Drug Quantity</th>
                    <th>Drug Amount</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quotations as $quotation)
                    <tr>
                        <td>{{ $quotation->id }}</td>
                        <td>{{ $quotation->drug_name }}</td>
                        <td>{{ $quotation->drug_quantity }}</td>
                        <td>{{ $quotation->drug_amount }}</td>
                        <td>
                            <button disabled class="btn btn-success btn-sm">Accepted</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No Quotation accepted yet.</p>
    @endif
</div>

@endsection