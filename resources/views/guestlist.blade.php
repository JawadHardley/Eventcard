@extends('layouts.admin')

@section('title', 'Guest List')

@section('content')
    <div class="fade-up">
        {{-- Page header --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">Guest List</h1>
                <p class="page-subtitle">Manage all guests across your events</p>
            </div>
            <button class="btn btn-primary btn-sm" onclick="openModal('modal-add-guest')">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24">
                    <path d="M12 5v14m-7-7h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
                </svg>
                Add Guest
            </button>
        </div>

        {{-- Guest Table Card --}}
        <div class="card p-0 overflow-hidden">
            <div
                class="p-4 border-b border-gray-100 dark:border-gray-800 flex flex-wrap justify-between items-center gap-3">
                <div class="relative">
                    <i class="fa fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="guestSearch" placeholder="Search by name, phone, email..."
                        class="form-input pl-9 py-2 text-sm w-64">
                </div>
                <div class="flex gap-2">
                    <select id="eventFilter" class="form-input py-2 text-sm w-48">
                        <option value="">All Events</option>
                        @php
                            $userEvents = \App\Models\Event::where('user_id', auth()->id())->get();
                        @endphp
                        @foreach ($userEvents as $event)
                            <option value="{{ $event->id }}">{{ $event->order_name }}</option>
                        @endforeach
                    </select>
                    <select id="statusFilter" class="form-input py-2 text-sm w-36">
                        <option value="">All Status</option>
                        <option value="checked">Checked In</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="aura-table min-w-full">
                    <thead>
                        <tr>
                            <th>Guest Name</th>
                            <th>Contact</th>
                            <th>Event</th>
                            <th>Card Type</th>
                            <th>Delivery</th>
                            <th>Status</th>
                            <th>QR Code</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="guestTableBody">
                        @php $counter = 1; @endphp
                        @forelse($guests as $guest)
                            <tr class="guest-row" data-event="{{ $guest->order_id }}"
                                data-status="{{ $guest->verified ? 'checked' : 'pending' }}">
                                <td>
                                    <div class="font-medium">{{ $guest->full_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $guest->title }}</div>
                                </td>
                                <td>
                                    <div><i class="fa fa-phone-alt text-gray-400 text-xs mr-1"></i> {{ $guest->phone }}
                                    </div>
                                    <div class="text-xs text-gray-500"><i
                                            class="fa fa-envelope text-gray-400 text-xs mr-1"></i> {{ $guest->email }}</div>
                                </td>
                                <td>
                                    @php $eventName = \App\Models\Event::find($guest->order_id)->order_name ?? 'Unknown'; @endphp
                                    {{ $eventName }}
                                </td>
                                <td>
                                    @if ($guest->title == 'double')
                                        <span class="badge badge-purple">Double</span>
                                    @else
                                        <span class="badge badge-blue">Single</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($guest->delivery_method == 'sms')
                                        <span class="badge badge-gray"><i class="fa fa-comment"></i> SMS</span>
                                    @elseif($guest->delivery_method == 'whatsapp')
                                        <span class="badge badge-green"><i class="fa fa-whatsapp"></i> WhatsApp</span>
                                    @else
                                        <span class="badge badge-blue"><i class="fa fa-envelope"></i> Email</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($guest->verified)
                                        <span class="badge badge-green">Checked In</span>
                                    @else
                                        <span class="badge badge-yellow">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <button onclick="showQRModal({{ $guest->id }})"
                                        class="text-blue-600 hover:underline text-sm">
                                        <i class="fa fa-qrcode"></i> View
                                    </button>
                                </td>
                                <td>
                                    <div class="flex gap-1">
                                        <button onclick="editGuest({{ $guest->id }})"
                                            class="text-gray-600 hover:text-blue-600" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button onclick="deleteGuest({{ $guest->id }})"
                                            class="text-gray-600 hover:text-red-600" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @php $counter++; @endphp
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-gray-500">No guests found. Click "Add Guest"
                                    to create one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                <div class="grid grid-cols-1 gap-4">
                    <div><label class="form-label">Full Name</label><input type="text" name="full_name"
                            class="form-input" required></div>
                    <div><label class="form-label">Title / Card Type</label>
                        <select name="title" class="form-input">
                            <option value="single">Single</option>
                            <option value="double">Double</option>
                        </select>
                    </div>
                    <div><label class="form-label">Email</label><input type="email" name="email" class="form-input"
                            required></div>
                    <div><label class="form-label">Phone</label><input type="text" name="phone" class="form-input"
                            placeholder="+255XXXXXXXXX" required></div>
                    <div><label class="form-label">Delivery Method</label>
                        <select name="delivery_method" class="form-input">
                            <option value="sms">SMS</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                    <div><label class="form-label">Event</label>
                        <select name="event_id" class="form-input" required>
                            <option value="">Select Event</option>
                            @foreach ($userEvents as $event)
                                <option value="{{ $event->id }}">{{ $event->order_name }}</option>
                            @endforeach
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

    {{-- Edit Guest Modal (dynamic content via fetch) --}}
    <div id="modal-edit-guest" class="modal-overlay" onclick="handleModalClick(event, 'modal-edit-guest')">
        <div class="modal-box card p-6 max-w-lg w-full">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Edit Guest</h3>
                <button class="close-btn" onclick="closeModal('modal-edit-guest')">✕</button>
            </div>
            <div id="edit-guest-container">
                {{-- Loaded dynamically via AJAX --}}
            </div>
        </div>
    </div>

    {{-- QR Modal --}}
    <div id="modal-qr" class="modal-overlay" onclick="handleModalClick(event, 'modal-qr')">
        <div class="modal-box card p-6 max-w-sm text-center">
            <div class="flex justify-end"><button class="close-btn" onclick="closeModal('modal-qr')">✕</button></div>
            <div id="qr-code-display" class="my-4 flex justify-center"></div>
            <div id="qr-link-display" class="text-xs text-gray-500 break-all"></div>
            <div class="mt-4">
                <button class="btn btn-primary btn-sm" onclick="copyQRCode()">Copy Link</button>
            </div>
        </div>
    </div>

    <script>
        // ---------- Search & Filters ----------
        function filterGuests() {
            let search = document.getElementById('guestSearch').value.toLowerCase();
            let eventId = document.getElementById('eventFilter').value;
            let status = document.getElementById('statusFilter').value;

            document.querySelectorAll('.guest-row').forEach(row => {
                let text = row.textContent.toLowerCase();
                let matchesSearch = text.includes(search);
                let matchesEvent = (eventId === '' || row.dataset.event == eventId);
                let matchesStatus = (status === '' || row.dataset.status === status);
                row.style.display = (matchesSearch && matchesEvent && matchesStatus) ? '' : 'none';
            });
        }

        document.getElementById('guestSearch').addEventListener('keyup', filterGuests);
        document.getElementById('eventFilter').addEventListener('change', filterGuests);
        document.getElementById('statusFilter').addEventListener('change', filterGuests);

        // ---------- QR Modal ----------
        let currentGuestId = null;

        function showQRModal(guestId) {
            fetch(`/user/guest-qr/${guestId}`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('qr-code-display').innerHTML = data.qr_svg;
                    document.getElementById('qr-link-display').innerText = data.link;
                    currentGuestId = guestId;
                    openModal('modal-qr');
                })
                .catch(() => showToast('Failed to load QR code', 'error'));
        }

        function copyQRCode() {
            let link = document.getElementById('qr-link-display').innerText;
            navigator.clipboard.writeText(link);
            showToast('Link copied to clipboard', 'success');
        }

        // ---------- Edit Guest ----------
        function editGuest(guestId) {
            fetch(`/user/guest/${guestId}/edit`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('edit-guest-container').innerHTML = html;
                    openModal('modal-edit-guest');
                })
                .catch(() => showToast('Could not load edit form', 'error'));
        }

        // ---------- Delete Guest ----------
        function deleteGuest(guestId) {
            if (confirm('Are you sure you want to delete this guest? This action cannot be undone.')) {
                fetch(`/user/guest/${guestId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Guest deleted successfully', 'success');
                            location.reload();
                        } else {
                            showToast('Delete failed: ' + (data.message || 'Unknown error'), 'error');
                        }
                    })
                    .catch(() => showToast('Network error', 'error'));
            }
        }

        // ---------- Flash messages as toasts ----------
        @if (session('message'))
            showToast("{{ session('message') }}", "{{ session('status') == 'success' ? 'success' : 'error' }}");
        @endif
        @if ($errors->any())
            showToast("{{ $errors->first() }}", "error");
        @endif
    </script>
@endsection
