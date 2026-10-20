@extends('admin.layouts.master')
@section('title', 'Notifications')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Notifications',
    'subtitle' => 'Who gets an email when something happens on the website.',
    'crumbs' => ['Configuration' => null, 'Notifications' => null],
])

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.notifications.update') }}">
            @csrf
            @method('PUT')
            <h5 class="mb-1">New business leads</h5>
            <p class="text-muted mb-3">Sent every time someone submits the business sign-up form. Replying to the email answers the person who enquired.</p>

            <label class="form-label" for="business_lead_emails">Send to</label>
            <input type="text" id="business_lead_emails" name="business_lead_emails"
                   class="form-control @error('business_lead_emails') is-invalid @enderror"
                   value="{{ old('business_lead_emails', implode(', ', $leadEmails)) }}"
                   placeholder="quotes@yallashipping.com" autocomplete="off" spellcheck="false">
            @error('business_lead_emails')
                @foreach ($errors->get('business_lead_emails') as $message)
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @endforeach
            @enderror
            <div class="form-text">Separate several addresses with commas. Leave empty to turn these emails off; leads still appear under Business leads.</div>

            <button type="submit" class="btn btn-primary mt-4">Save</button>
        </form>
    </div>
</div>
@endsection
