@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="flex flex-col gap-4">
                <div class="flex items-center gap-4">
                    <div class="skeleton h-16 w-16 shrink-0 rounded-full"></div>
                    <div class="flex flex-col gap-4">
                        <div class="skeleton h-4 w-96"></div>
                        <div class="skeleton h-4 w-96"></div>
                    </div>
                </div>
                <div class="skeleton h-32 w-full"></div>
            </div>
        </div>
    </div>
@endsection
