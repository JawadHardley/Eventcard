@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <x-error_show />
            <div class="rounded">
                <fieldset class="fieldset border-2 border-stone-950/10 rounded-xl p-6 shadow-sm bg-base-100">
                    <h2 class="text-3xl font-bold mb-5 text-center text-primary">
                        <i class="fa fa-calendar-plus mr-3"></i> Create New Event
                    </h2>
                    <div class="divider"></div>

                    <form action="{{ route('user.eventadd') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <!-- Row 1 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="label font-semibold">Order Name</label>
                                <input type="text" name="order_name" class="input input-bordered w-full"
                                    placeholder="Event Order Name" />
                            </div>

                            <div>
                                <label class="label font-semibold">Event Host</label>
                                <input type="text" name="event_host" class="input input-bordered w-full"
                                    placeholder="Hosted by..." />
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div>
                                <label class="label font-semibold">Event Type</label>
                                <input type="text" name="event_type" class="input input-bordered w-full"
                                    placeholder="Wedding, Party..." />
                            </div>

                            {{-- <div>
                                <label class="label font-semibold">Event Status</label>
                                <select name="event_status" class="select select-bordered w-full">
                                    <option value="draft">Draft</option>
                                    <option value="active">Active</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div> --}}

                            {{-- <div>
                                <label class="label font-semibold">Payment Status</label>
                                <select name="payment_status" class="select select-bordered w-full">
                                    <option value="pending">Pending</option>
                                    <option value="paid">Paid</option>
                                    <option value="refunded">Refunded</option>
                                </select>
                            </div> --}}
                        </div>

                        <!-- Row 3 -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="label font-semibold">Event Date</label>
                                <input type="date" name="event_date" class="input input-bordered w-full" />
                            </div>

                            <div>
                                <label class="label font-semibold">Arrival Time</label>
                                <input type="time" name="arrival_time" class="input input-bordered w-full" />
                            </div>

                            <div>
                                <label class="label font-semibold">Reminder Date</label>
                                <input type="date" name="reminder_date" class="input input-bordered w-full" />
                            </div>
                        </div>

                        <!-- Row 4 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="label font-semibold">Event Location</label>
                                <input type="text" name="event_location" class="input input-bordered w-full"
                                    placeholder="Venue / City" />
                            </div>

                            <div>
                                <label class="label font-semibold">Timezone (by IP)</label>
                                <input type="text" name="timezone" class="input input-bordered w-full"
                                    placeholder="Africa/Dar_es_Salaam" />
                            </div>
                        </div>

                        <!-- Row 5 -->
                        <div>
                            <label class="label font-semibold">Event Description</label>
                            <textarea name="event_desc" rows="3" class="textarea textarea-bordered w-full"
                                placeholder="Write a short description about the event..."></textarea>
                        </div>

                        <!-- Row 7 -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="label font-semibold">Slug (SEO)</label>
                                <input type="text" name="slug" class="input input-bordered w-full"
                                    placeholder="my-awesome-event" />
                            </div>

                            <div>
                                <label class="label font-semibold">Guest/Card Limit</label>
                                <input type="number" name="guest_limit" class="input input-bordered w-full"
                                    placeholder="100" />
                            </div>
                        </div>

                        <div class="divider"></div>

                        <button type="submit" class="btn btn-primary w-full text-lg font-semibold">
                            <i class="fa fa-check-circle mr-2"></i> Save Event
                        </button>
                    </form>
                </fieldset>

            </div>
        </div>
    </div>
@endsection
