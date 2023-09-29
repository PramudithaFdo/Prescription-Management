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
                        <div class="photo-grid">
                            @foreach ($photos as $photo)
                                @if ($photo->prescription_Id == $prescription->id)
                                    <button class="btn btn-primary view-photo-button" data-toggle="modal" data-target="#imageModal" data-image="{{ asset('storage/prescriptions/' . $photo->filename) }}">View Prescription</button>
                                @endif
                            @endforeach
                        </div>
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

<!-- The Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">View Prescription</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" id="modalImage" class="img-fluid" alt="Image">
            </div>
        </div>
    </div>
</div>


@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
    $('.view-photo-button').on('click', function () {
        var imageUrl = $(this).data('image');
        $('#modalImage').attr('src', imageUrl);
    });
});
</script>