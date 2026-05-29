@extends('layouts.admin')
@section('title', 'Create Event')
@section('content')
    <div class="fade-up max-w-3xl mx-auto">
        <div class="page-header">
            <h1 class="page-title">Create New Event</h1>
        </div>
        <div class="card p-6">
            <form action="{{ route('user.eventadd') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group"><label class="form-label">Order Name</label><input type="text" name="order_name"
                            class="form-input" required></div>
                    <div class="form-group"><label class="form-label">Event Host</label><input type="text"
                            name="event_host" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Event Type</label><input type="text"
                            name="event_type" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Event Date</label><input type="date"
                            name="event_date" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Arrival Time</label><input type="time"
                            name="arrival_time" class="form-input"></div>
                    <div class="form-group"><label class="form-label">Reminder Date</label><input type="date"
                            name="reminder_date" class="form-input"></div>
                    <div class="form-group col-span-2"><label class="form-label">Event Location</label><input type="text"
                            name="event_location" class="form-input"></div>
                    <div class="form-group col-span-2"><label class="form-label">Description</label>
                        <textarea name="event_desc" rows="3" class="form-input"></textarea>
                    </div>
                    <div class="form-group"><label class="form-label">Slug (SEO)</label><input type="text" name="slug"
                            class="form-input"></div>
                    <div class="form-group"><label class="form-label">Guest Limit</label><input type="number"
                            name="guest_limit" class="form-input"></div>
                </div>
                <div class="flex justify-end mt-6"><button type="submit" class="btn btn-primary">Save Event</button></div>
            </form>
        </div>
    </div>
@endsection
