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
                            @if($quotation->status === "accepted")
                                <button disabled class="btn btn-success btn-sm">Accepted</button>
                            @elseif($quotation->status === "rejected")
                                <button disabled class="btn btn-danger btn-sm">Rejected</button>
                            @else
                                <button class="btn btn-success btn-sm" onclick="acceptUser({{ $quotation->id }})">Accept</button>
                                <button class="btn btn-danger btn-sm" onclick="rejectUser({{ $quotation->id }})">Reject</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No Quotation uploaded yet.</p>
    @endif
</div>

@endsection

<script>

    function acceptUser(quotationId) {
        $.ajax({
            type: 'POST',
            url: '/accept-quotation/' + quotationId,
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                location.reload();
            },
            error: function (xhr) {
                console.error('Error accepting user: ' + xhr.statusText);
            }
        });
    }

    function rejectUser(userId) {
        $.ajax({
            type: 'POST',
            url: '/reject-quotation/' + userId,
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                location.reload();
            },
            error: function (xhr) {
                console.error('Error rejecting user: ' + xhr.statusText);
            }
        });
    }
</script>

