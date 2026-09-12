@extends('layouts.public')

@section('title', 'Request a Certified Copy')

@section('content')
<div class="admin-toolbar">
    <div>
        <div class="eyebrow">PUBLIC SERVICE</div>
        <h1>Request a Certified Copy</h1>
        <p class="muted">Submit your request to the SB Secretary. Keep the tracking code shown after submission.</p>
    </div>
    <a class="btn btn-light" href="{{ route('home') }}">Back</a>
</div>

<section class="card">
    <form method="POST" action="{{ route('public.requests.store') }}" enctype="multipart/form-data" class="stack-form">
        @csrf

        <label for="requester_name">Full Name</label>
        <input id="requester_name" name="requester_name" value="{{ old('requester_name') }}" required maxlength="255" placeholder="e.g. Juan Dela Cruz">

        <label for="contact_number">Contact Number <span class="muted">(e.g., 09123456789)</span></label>
        <input id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required pattern="^(09|\+639)\d{9}$" maxlength="13" placeholder="09123456789">

        <label for="document_id">Document</label>
        <select id="document_id" name="document_id" required>
            <option value="">— Select a document —</option>
            @foreach ($documents as $doc)
                <option value="{{ $doc->document_id }}" @selected((isset($document) && $document->document_id === $doc->document_id) || old('document_id') === $doc->document_id)>
                    {{ $doc->session_name }} ({{ $doc->type }})
                </option>
            @endforeach
        </select>

        <div class="two-col">
            <div>
                <label for="copies">Number of Copies</label>
                <input id="copies" name="copies" type="number" min="1" value="{{ old('copies', 1) }}" required>
            </div>
            <div>
                <label for="pickup_date">Preferred Pickup Date</label>
                <input id="pickup_date" name="pickup_date" type="date" value="{{ old('pickup_date') }}" required>
            </div>
        </div>

        <label for="reason">Reason / Purpose</label>
        <input id="reason" name="reason" value="{{ old('reason') }}" required maxlength="255" placeholder="e.g. Legal reference, educational purposes">

        <label for="valid_id">Valid ID <span class="muted">(JPEG, PNG, JPG - max 5MB)</span></label>
        <input id="valid_id" name="valid_id" type="file" accept="image/jpeg,image/png,image/jpg" required>

        <button class="btn btn-primary" type="submit">Submit Request</button>
    </form>
</section>
@endsection