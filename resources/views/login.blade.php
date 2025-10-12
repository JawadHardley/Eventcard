@extends('layouts.guest')

@section('content')
    <div class="flex items-center justify-center min-h-screen">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <fieldset class="fieldset rounded-box w-96 p-6 border-2 shadow-lg border-stone-950/10">
                {{-- <legend class="fieldset-legend text-lg font-semibold mb-2">Login</legend> --}}
                <h2 class="text-2xl font-bold mb-5 text-center">
                    <i class="fa fa-object-ungroup text-primary mr-3"></i> Sign In
                </h2>

                <label class="label">Email</label>
                <input type="email" name="email" class="input input-bordered w-full" placeholder="Email"
                    value="{{ old('email') }}" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <label class="label mt-3">Password</label>
                <input type="password" name="password" class="input input-bordered w-full" placeholder="Password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <label class="label mt-3">
                    <input type="checkbox" name="remember" class="checkbox" />
                    Remember me
                </label>

                <button class="btn btn-primary w-full mt-4">Login</button>
                <a href="{{ route('register') }}" class="text-decoration-none text-blue-700">
                    <label class="label text-blue-700 mt-3">Dont't have account ? register</label>
                </a>
                <a href="{{ route('landing') }}" class="text-decoration-none text-blue-700">
                    <label class="label text-blue-700 mt-3">
                        <i class="fa fa-house"></i> Back home
                    </label>
                </a>
            </fieldset>
        </form>
    </div>
@endsection
