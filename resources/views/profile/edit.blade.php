@extends('layouts.app')
@section('content')
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="card bg-base-100 shadow-md p-5 mb-10">
        <div class="card-body">
            <h2 class="card-title">Profile Information</h2>
            <p>Update your account's profile information and email address.</p>
            <div class="bg-red-20 card-actions">
                <form method="post" action="{{ route('profile.update') }}" class="w-full">
                    @csrf
                    @method('patch')

                    <fieldset class="fieldset w-full">
                        <label class="text-base mt-5">Name</label>
                        <input type="text" name="name" class="input w-full" value="{{ $user->name }}"
                            placeholder="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />

                        <label class="text-base mt-5">Email</label>
                        <input type="email" name="email" class="input w-full" value="{{ $user->email }}"
                            placeholder="example@mail.com" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary w-full">Save</button>
                        </div>
                    </fieldset>
                </form>
                {{-- <button class="btn btn-primary">Buy Now</button> --}}
            </div>
        </div>
    </div>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
    @endif


    <div class="card bg-base-100 shadow-md p-5">
        <div class="card-body">
            <h2 class="card-title">Update Password</h2>
            <p>Ensure your account is using a long, random password to stay secure.</p>
            <div class="bg-red-20 card-actions">
                <form method="post" action="{{ route('profile.update') }}" class="w-full">
                    @csrf
                    @method('patch')

                    <fieldset class="fieldset w-full">
                        <label class="text-base mt-5">Current Password</label>
                        <input type="password" name="current_password" class="input w-full" />
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />

                        <label class="text-base mt-5">New Password</label>
                        <input type="password" name="password" class="input w-full" />
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />

                        <label class="text-base mt-5">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="input w-full" />
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />

                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary w-full">Save</button>
                        </div>
                    </fieldset>
                </form>
                {{-- <button class="btn btn-primary">Buy Now</button> --}}
            </div>
        </div>
    </div>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div> --}}
@endsection
