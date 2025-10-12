@extends('layouts.guest')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-base-100">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <fieldset class="fieldset rounded-box w-96 p-6 border-2 shadow-lg border-stone-950/10">
                <h2 class="text-2xl font-bold mb-5 text-center">
                    <i class="fa fa-object-ungroup text-primary mr-3"></i> Sign Up
                </h2>

                <label class="label">Name</label>
                <input type="text" name="name" class="input input-bordered w-full" placeholder="username"
                    value="{{ old('name') }}" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

                <label class="label">Email</label>
                <input type="email" name="email" class="input input-bordered w-full" placeholder="Email"
                    value="{{ old('email') }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <label class="label mt-3">Password</label>
                <input type="password" name="password" class="input input-bordered w-full" placeholder="Password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <label class="label mt-3">Confirm Password</label>
                <input type="password" name="password_confirmation" class="input input-bordered w-full"
                    placeholder="password_confirmation" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                {{-- <label class="label mt-3">
                    <input type="checkbox" name="remember" class="checkbox" />
                    Remember me
                </label> --}}

                <button class="btn btn-primary w-full mt-4">Register</button>
                <a href="{{ route('login') }}" class="text-decoration-none text-blue-700">
                    <label class="label text-blue-700 mt-3">Already have account ? login</label>
                </a>
            </fieldset>
        </form>
    </div>
@endsection
