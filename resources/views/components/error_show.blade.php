@if ($errors->any())
    <div role="alert" class="alert alert-error alert-outline mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@elseif (session('message'))
    @if (session('status') == 'success')
        <div role="alert" class="alert alert-success alert-outline mb-4">
            <span>{{ session('message') }}</span>
        </div>
    @else
        <div role="alert" class="alert alert-error alert-outline mb-4">
            <span>{{ session('message') }}</span>
        </div>
    @endif
@endif
