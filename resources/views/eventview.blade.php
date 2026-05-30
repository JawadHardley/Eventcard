@extends('layouts.admin')

@section('title', $events->order_name . ' - Event Details')

@section('content')
    <div class="fade-up">
        {{-- Page header with actions --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">{{ $events->order_name }}</h1>
                <p class="page-subtitle">Event details & guest management</p>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-outline btn-sm" onclick="openModal('modal-edit-event')">
                    <i class="fa fa-edit"></i> Edit Event
                </button>
                <a href="{{ route('user.cameralog', ['event' => $events->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-camera"></i> Scan QR
                </a>
                <button class="btn btn-success btn-sm" onclick="openModal('modal-add-guest')">
                    <i class="fa fa-plus"></i> Add Guest
                </button>
                <button class="btn btn-secondary btn-sm" onclick="openModal('modal-import')">
                    <i class="fa fa-upload"></i> Import Excel
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- LEFT COLUMN: Event Info Cards --}}
            <div class="space-y-4">
                {{-- Event status card --}}
                <div class="card p-5">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Event Status</h3>
                        @if ($events->event_status == 'active')
                            <span class="badge badge-green">Active</span>
                        @elseif($events->event_status == 'completed')
                            <span class="badge badge-blue">Completed</span>
                        @else
                            <span class="badge badge-red">Cancelled</span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-2xl font-bold">{{ $guests->count() }}</div>
                            <div class="text-xs text-gray-500">Guests Registered</div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold">{{ $events->guest_limit ?? '∞' }}</div>
                            <div class="text-xs text-gray-500">Limit</div>
                        </div>
                    </div>
                    <div class="mt-3 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full"
                            style="width: {{ min(100, ($guests->count() / max($events->guest_limit, 1)) * 100) }}%"></div>
                    </div>
                </div>

                {{-- Event details card --}}
                <div class="card p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <i class="fa fa-calendar-day text-red-500 w-5"></i>
                        <div>
                            <div class="text-xs text-gray-500">Event Date</div>
                            <div class="font-medium">{{ \Carbon\Carbon::parse($events->event_date)->format('l, j F Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa fa-clock text-red-500 w-5"></i>
                        <div>
                            <div class="text-xs text-gray-500">Arrival Time</div>
                            <div class="font-medium">{{ \Carbon\Carbon::parse($events->arrival_time)->format('g:i A') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa fa-location-dot text-red-500 w-5"></i>
                        <div>
                            <div class="text-xs text-gray-500">Venue</div>
                            <div class="font-medium">{{ $events->event_location }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa fa-tag text-red-500 w-5"></i>
                        <div>
                            <div class="text-xs text-gray-500">Event Type</div>
                            <div class="font-medium">{{ $events->event_type }}</div>
                        </div>
                    </div>
                    <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                        <div class="text-xs text-gray-500 mb-1">Description</div>
                        <p class="text-sm">{{ $events->event_desc ?? 'No description provided.' }}</p>
                    </div>
                </div>

                {{-- Payment status card --}}
                <div class="card p-5">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold">Payment</span>
                        @if ($events->payment_status == 'paid')
                            <span class="badge badge-green">Paid</span>
                        @else
                            <span class="badge badge-yellow">Pending</span>
                        @endif
                    </div>
                    <div class="mt-2 text-xs text-gray-500">Guest limit can be increased after payment</div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Guest List Table --}}
            <div class="lg:col-span-2">
                <div class="card p-0 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                        <h3 class="font-semibold">Guest List</h3>
                        <div class="relative">
                            <input type="text" id="guestSearch" placeholder="Search guests..."
                                class="form-input py-1 pl-8 pr-3 text-sm">
                            <i
                                class="fa fa-search absolute left-2 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="aura-table min-w-full">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Guest Name</th>
                                    <th>Phone</th>
                                    <th>Card Type</th>
                                    <th>Status</th>
                                    <th>QR Code</th>
                                    <th>Card</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="guestTableBody">
                                @php $counter = 1; @endphp
                                @forelse ($guests as $guest)
                                    <tr class="guest-row">
                                        <td class="text-center">{{ $counter }}</td>
                                        <td>
                                            <div class="font-medium">{{ $guest->full_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $guest->email }}</div>
                                        </td>
                                        <td>{{ $guest->phone }}</td>
                                        <td>
                                            @if ($guest->title == 'double')
                                                <span class="badge badge-purple">Double (2x)</span>
                                            @else
                                                <span class="badge badge-blue">Single</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($guest->title == 'double')
                                                @if ($guest->counter == '[0/2]')
                                                    <span class="badge badge-yellow">Pending</span>
                                                @elseif($guest->counter == '[1/2]')
                                                    <span class="badge badge-blue">1/2 Used</span>
                                                @else
                                                    <span class="badge badge-green">Fully Used</span>
                                                @endif
                                            @else
                                                @if ($guest->verified)
                                                    <span class="badge badge-green">Checked In</span>
                                                @else
                                                    <span class="badge badge-yellow">Pending</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('user.cardview', ['event' => $events->id, 'guest' => $guest->id]) }}"
                                                target="_blank" class="text-green-600 hover:text-green-800 mx-1">
                                                <i class="fa fa-eye"></i> Preview
                                            </a>
                                        </td>
                                        <td>
                                            <button
                                                onclick="showQRModal({{ $guest->id }}, `{{ $guest->full_name }}`, `{{ $guest->more ?? $guest->qrcode }}`)"
                                                class="text-blue-600 hover:underline text-sm">
                                                <i class="fa fa-qrcode"></i> View
                                            </button>
                                        </td>
                                        <td>
                                            <button
                                                onclick="openEditGuestModal({{ $guest->id }}, '{{ addslashes($guest->full_name) }}', '{{ $guest->title }}', '{{ $guest->email }}', '{{ $guest->phone }}', '{{ $guest->delivery_method }}', '{{ addslashes($guest->address) }}')"
                                                class="text-gray-600 hover:text-blue-600 mx-1">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button onclick="deleteGuest({{ $guest->id }})"
                                                class="text-gray-600 hover:text-red-600 mx-1">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- QR Code Modal --}}
                                    {{-- QR Modal (inline QR generation) --}}
                                    <div id="modal-qr" class="modal-overlay" onclick="handleModalClick(event, 'modal-qr')">
                                        <div class="modal-box card p-6 max-w-sm text-center">
                                            <div class="flex justify-end"><button class="close-btn"
                                                    onclick="closeModal('modal-qr')">✕</button></div>
                                            <div id="qr-code-container" class="my-4 flex justify-center"></div>
                                            <div id="qr-link-container" class="text-xs text-gray-500 break-all"></div>

                                            <h3 class="text-lg text-center font-bold">{{ $guest->full_name }}</h3>
                                            <div class="col">
                                                <p class="py-1 text-center">{{ $guest->qrcode }}</p>
                                                <p class="py-1 text-center">{{ $guest->invitation_code }}</p>
                                                <p class="p-3 bg-stone-50 rounded-lg flex justify-center align-center">
                                                    @if ($guest->qrcode)
                                                        {!! QrCode::size(200)->generate($guest->more ?? $guest->qrcode) !!}
                                                    @else
                                                        <span class="text-red-500">No QR assigned</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="mt-4">
                                                <button class="btn btn-primary btn-sm" onclick="copyQRCode()">Copy
                                                    Link</button>
                                            </div>
                                        </div>
                                    </div>

                                    @php $counter++; @endphp
                                @empty
                                    <div class="text-center py-10">
                                        <div class="text-5xl mb-3">🎉</div>

                                        <h3 class="text-xl font-semibold">
                                            No guests yet
                                        </h3>

                                        <p class="text-gray-500 mt-2">
                                            Start adding guests for this event.
                                        </p>
                                    </div>

                                @endforelse
                            </tbody>
                        </table>
                        @if ($guests->isEmpty())
                            <div class="text-center py-10 text-gray-500">No guests added yet. Click "Add Guest" to start.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========== MODALS ========== --}}

    {{-- Add Guest Modal --}}
    <div id="modal-add-guest" class="modal-overlay" onclick="handleModalClick(event, 'modal-add-guest')">
        <div class="modal-box card p-6 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Add New Guest</h3>
                <button class="close-btn" onclick="closeModal('modal-add-guest')">✕</button>
            </div>
            <form method="POST" action="{{ route('user.guestadd') }}" onsubmit="closeModal('modal-add-guest')">
                @csrf
                <input type="hidden" name="event_id" value="{{ $events->id }}">
                <div class="grid grid-cols-1 gap-4">
                    <div><label class="form-label">Full Name</label><input type="text" name="full_name"
                            class="form-input" required></div>
                    <div><label class="form-label">Title (Card Type)</label>
                        <select name="title" class="form-input">
                            <option value="single">Single</option>
                            <option value="double">Double</option>
                        </select>
                    </div>
                    <div><label class="form-label">Email</label><input type="email" name="email" class="form-input">
                    </div>
                    <div><label class="form-label">Phone</label><input type="text" name="phone" class="form-input"
                            placeholder="+255XXXXXXXXX" required></div>
                    <div><label class="form-label">Delivery Method</label>
                        <select name="delivery_method" class="form-input">
                            <option value="sms">SMS</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                    <div><label class="form-label">Address</label>
                        <textarea name="address" class="form-input" rows="2"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeModal('modal-add-guest')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Guest</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Guest Modal (dynamic content via JS) --}}
    <div id="modal-edit-guest" class="modal-overlay" onclick="handleModalClick(event, 'modal-edit-guest')">
        <div class="modal-box card p-6 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Edit Guest</h3>
                <button class="close-btn" onclick="closeModal('modal-edit-guest')">✕</button>
            </div>
            <div id="edit-guest-form-container">
                {{-- Loaded dynamically via fetch --}}
            </div>
        </div>
    </div>


    {{-- Import Excel Modal --}}
    <div id="modal-import" class="modal-overlay" onclick="handleModalClick(event, 'modal-import')">
        <div class="modal-box card p-6 max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Import Guests (Excel/CSV)</h3>
                <button class="close-btn" onclick="closeModal('modal-import')">✕</button>
            </div>
            <form method="POST" action="{{ route('user.importGuests') }}" enctype="multipart/form-data"
                onsubmit="closeModal('modal-import')">
                @csrf
                <input type="hidden" name="event_id" value="{{ $events->id }}">
                <div class="form-group">
                    <label class="form-label">Upload File</label>
                    <input type="file" name="file" class="form-input" accept=".xlsx,.xls,.csv" required>
                    <p class="text-xs text-gray-500 mt-1">Allowed columns: S/N, full name, card type, method, phone, email,
                        address</p>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('modal-import')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Event Modal --}}{{-- Edit Event Modal --}}
    <div id="modal-edit-event" class="modal-overlay" onclick="handleModalClick(event, 'modal-edit-event')">
        <div class="modal-box card p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Edit Event</h3>
                <button class="close-btn" onclick="closeModal('modal-edit-event')">✕</button>
            </div>
            <form method="POST" action="{{ route('user.eventupdate', ['id' => $events->id]) }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><label class="form-label">Order Name</label><input type="text" name="order_name"
                            value="{{ $events->order_name }}" class="form-input" required></div>
                    <div><label class="form-label">Event Host</label><input type="text" name="event_host"
                            value="{{ $events->event_host }}" class="form-input"></div>
                    <div><label class="form-label">Event Type</label><input type="text" name="event_type"
                            value="{{ $events->event_type }}" class="form-input"></div>
                    <div><label class="form-label">Event Date</label><input type="date" name="event_date"
                            value="{{ $events->event_date }}" class="form-input"></div>
                    <div><label class="form-label">Arrival Time</label><input type="time" name="arrival_time"
                            value="{{ $events->arrival_time }}" class="form-input"></div>
                    <div><label class="form-label">Reminder Date</label><input type="date" name="reminder_date"
                            value="{{ $events->reminder_date }}" class="form-input"></div>
                    <div class="col-span-2"><label class="form-label">Event Location</label><input type="text"
                            name="event_location" value="{{ $events->event_location }}" class="form-input"></div>
                    <div class="col-span-2"><label class="form-label">Description</label>
                        <textarea name="event_desc" rows="3" class="form-input">{{ $events->event_desc }}</textarea>
                    </div>
                    <div><label class="form-label">Slug (SEO)</label><input type="text" name="slug"
                            value="{{ $events->slug }}" class="form-input"></div>
                    <div><label class="form-label">Guest Limit</label><input type="number" name="guest_limit"
                            value="{{ $events->guest_limit }}" class="form-input"></div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeModal('modal-edit-event')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>
    {{-- Edit Guest Modal (static form, filled via JS) --}}
    <div id="modal-edit-guest" class="modal-overlay" onclick="handleModalClick(event, 'modal-edit-guest')">
        <div class="modal-box card p-6 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Edit Guest</h3>
                <button class="close-btn" onclick="closeModal('modal-edit-guest')">✕</button>
            </div>
            <form id="edit-guest-form" method="POST" action="">
                @csrf
                <input type="hidden" name="event_id" value="{{ $events->id }}">
                <div class="grid grid-cols-1 gap-4">
                    <div><label class="form-label">Full Name</label><input type="text" name="full_name"
                            id="edit_full_name" class="form-input" required></div>
                    <div><label class="form-label">Title / Card Type</label>
                        <select name="title" id="edit_title" class="form-input">
                            <option value="single">Single</option>
                            <option value="double">Double</option>
                        </select>
                    </div>
                    <div><label class="form-label">Email</label><input type="email" name="email" id="edit_email"
                            class="form-input" required></div>
                    <div><label class="form-label">Phone</label><input type="text" name="phone" id="edit_phone"
                            class="form-input" required></div>
                    <div><label class="form-label">Delivery Method</label>
                        <select name="delivery_method" id="edit_delivery_method" class="form-input">
                            <option value="sms">SMS</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                    <div><label class="form-label">Address</label>
                        <textarea name="address" id="edit_address" class="form-input" rows="2"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeModal('modal-edit-guest')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Guest</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Guest search functionality
        document.getElementById('guestSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll('.guest-row').forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // ----- QR Modal (using inline data) -----
        let currentQR = '';

        function showQRModal(guestId, guestName, qrUrlOrCode) {
            // Generate QR code inline using a hidden div or by creating an image
            // Since we can't run QrCode::generate() in JS, we'll send a quick fetch to a simple route
            // But to avoid extra fetch, we can use a pre-generated QR? Easier: use a fetch to a simple endpoint that returns SVG.
            // I'll add a simple fetch but we'll create the route in Step 2.
            fetch(`/user/guest-qr/${guestId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('qr-code-container').innerHTML = data.qr_svg;
                    document.getElementById('qr-link-container').innerText = data.link;
                    openModal('modal-qr');
                })
                .catch(() => showToast('Could not load QR code', 'error'));
        }

        function copyQRCode() {
            let link = document.getElementById('qr-link-container').innerText;
            navigator.clipboard.writeText(link);
            showToast('Link copied!', 'success');
        }

        // ----- Edit Modal (fill form with guest data) -----
        function openEditGuestModal(id, name, title, email, phone, delivery, address) {
            document.getElementById('edit-guest-form').action = `/user/guest/${id}/update`;
            document.getElementById('edit_full_name').value = name;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_delivery_method').value = delivery;
            document.getElementById('edit_address').value = address;
            openModal('modal-edit-guest');
        }

        // ----- Delete Guest (with route we will create) -----
        function deleteGuest(guestId) {
            if (confirm('Delete this guest? This action cannot be undone.')) {
                fetch(`/user/guest/${guestId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Guest deleted', 'success');
                            location.reload();
                        } else {
                            showToast('Delete failed', 'error');
                        }
                    });
            }
        }
    </script>
@endsection
