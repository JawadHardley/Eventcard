@extends('layouts.app')
@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-12">
            <x-error_show />
            <div class="card bg-base-100 mb-5 card-md shadow-lg">
                <div class="card-body p-3">
                    <div class="justify-start card-actions">
                        <button class="btn btn-outline btn-primary" onclick="guest_form.showModal()">
                            Add Guest
                            <i class="fa fa-circle-plus ml-2"></i>
                        </button>
                        {{-- the modal for the guest form --}}
                        <dialog id="guest_form" class="modal">
                            <div class="modal-box">
                                <h3 class="text-lg font-bold text-center">Add Guest</h3>
                                <p class="py-4">
                                <form method="POST" action="{{ route('user.guestadd') }}" class="w-full">
                                    @csrf

                                    <fieldset class="fieldset w-full">
                                        <label class="text-base">Full Name</label>
                                        <input type="text" name="full_name" class="input w-full" placeholder="full name"
                                            required />

                                        <div class="flex flex-wrap gap-4 mt-5">
                                            <div class="flex-1">
                                                <label class="text-base mt-5">Guest Title</label>
                                                <select class="select w-50" name="title" required>
                                                    <option selected value="Mr">Mr</option>
                                                    <option value="Mrs">Mrs</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                            <div class="flex-1">
                                                <label class="text-base mt-5">Delivery Method</label>
                                                <select class="select w-full" name="delivery_method" required>
                                                    <option selected value="sms">sms</option>
                                                    <option value="email">email</option>
                                                    <option value="whatsapp">whatsapp</option>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="text-base mt-5">Email</label>
                                        <input type="email" name="email" class="input w-full"
                                            placeholder="example@mail.com" required />

                                        <label class="text-base mt-5">Phonenumber</label>
                                        <input type="text" name="phone" class="input w-full"
                                            placeholder="+255XX or 06XX" required />


                                        <label class="text-base mt-5">Address</label>
                                        <textarea class="textarea w-full" name="address" placeholder="Bio"></textarea>

                                        <div class="pt-4">
                                            <button type="submit" class="btn btn-primary w-full">Save</button>
                                        </div>
                                    </fieldset>
                                </form>
                                </p>
                                <div class="modal-action">
                                    <form method="dialog">
                                        <!-- if there is a button in form, it will close the modal -->
                                        <button class="btn">Close</button>
                                    </form>
                                </div>
                            </div>
                        </dialog>
                    </div>
                </div>
            </div>

            <div class="relative bg-base-100 overflow-x-auto shadow-md rounded">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase">
                        <tr class="border border-stone-700/10">
                            <th scope="col" class="px-6 py-3">
                                Guest Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Phonenumber
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Delivery Method
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                QR/Code
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $idcounter = 1;
                        @endphp
                        @foreach ($guests as $guest)
                            <tr class="border border-stone-700/10">
                                <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap">
                                    {{ $guest->title }} {{ $guest->full_name }}
                                </th>
                                <td class="px-6 py-4">
                                    {{ $guest->phone }}
                                </td>
                                <td class="px-6 py-4">
                                    {{-- {{ $guest->delivery_method }} --}}
                                    @if ($guest->delivery_method == 'sms')
                                        <div class="badge badge-dash  badge-primary">
                                            <i class="fa fa-comment-dots"></i> sms
                                        </div>
                                    @elseif ($guest->delivery_method == 'whatsapp')
                                        <div class="badge badge-dash  badge-info">
                                            <i class="fa fa-comments"></i> Whatsapp
                                        </div>
                                    @elseif ($guest->delivery_method == 'email')
                                        <div class="badge badge-dash  badge-secondary">
                                            <i class="fa fa-envelope"></i> Email
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if ($guest->verified == 1)
                                        <div class="badge badge-soft badge-success">Checked In</div>
                                    @else
                                        <div class="badge badge-soft badge-error">Pending</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $guest->qrcode }}
                                </td>
                                <td class="px-6 py-4">
                                    <button class="font-medium mx-2 text-blue-600 dark:text-blue-500"
                                        onclick="qrmodal_{{ $idcounter }}.showModal()">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="font-medium mx-2 text-green-600 dark:text-teal-500"
                                        onclick="qrmodal_{{ $idcounter }}.showModal()">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="font-medium mx-2 text-red-600 dark:text-red-500"
                                        onclick="qrmodal_{{ $idcounter }}.showModal()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <dialog id="qrmodal_{{ $idcounter }}" class="modal">
                                <div class="modal-box">
                                    <h3 class="text-lg font-bold">{{ $guest->full_name }}</h3>
                                    <p class="py-4">{{ $guest->qrcode }}</p>
                                    <p class="py-4 align-center">
                                        @if ($guest->qrcode)
                                            {!! QrCode::size(200)->generate($guest->more ?? $guest->qrcode) !!}
                                        @else
                                            <span class="text-red-500">No QR assigned</span>
                                        @endif
                                    </p>
                                    <div class="modal-action">
                                        <form method="dialog">
                                            <!-- if there is a button in form, it will close the modal -->
                                            <button class="btn">Close</button>
                                        </form>
                                    </div>
                                </div>
                            </dialog>
                            @php
                                $idcounter++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
