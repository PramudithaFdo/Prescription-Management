@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Upload Prescription</h2>
    <form action="/prescriptions" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="delivery_address">Delivery Address</label>
            <input type="text" name="delivery_address" id="delivery_address" class="form-control">
        </div>

        <div class="form-group">
            <label for="delivery_time">Delivery Time</label>
            <select name="delivery_time" id="delivery_time" class="form-control">
                <!-- Add your 2-hour time slots as options -->
                <option value="9:00 AM - 11:00 AM">9:00 AM - 11:00 AM</option>
                <option value="11:00 AM - 1:00 PM">11:00 AM - 1:00 PM</option>
                <!-- Add more options as needed -->
            </select>
        </div>

        <div class="form-group">
            <label for="prescription_file">Upload Prescription</label>
            <input type="file" name="prescription_file" id="prescription_file" class="form-control-file">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
