@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Upload Prescription</h2>
    <form action="/prescriptions" method="post" enctype="multipart/form-data">
        @csrf

        @if (session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                document.getElementById('success-alert').style.display = 'none';
            }, 3000);
        </script>
        @endif

        <div class="form-group">
            <label for="note">Note</label>
            <textarea name="note" id="note" autocomplete="off" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="delivery_address">Delivery Address</label>
            <input type="text" name="delivery_address" autocomplete="off" id="delivery_address" class="form-control">
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
            <label for="photos">Upload Prescription</label>
            <input type="file" name="photos[]" id="photos" multiple class="form-control-file">
        </div>

        <div class="form-group">
            <p>Selected Files: <span id="selected-files"></span></p>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

<script>
   document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById("photos");
        const selectedFilesElement = document.getElementById("selected-files");

        if (fileInput && selectedFilesElement) {
            fileInput.addEventListener("change", function () {
                const selectedFiles = Array.from(fileInput.files).map(file => file.name);
                selectedFilesElement.textContent = selectedFiles.join(', ');
            });
        }
    });
</script>