@if ($errors->any())
    <div role="alert" class="alert alert-error alert-outline my-2">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@elseif (session('message'))
    <!-- <div class="col-12"> -->
    <div class="alert alert-outline alert-{{ session('status') === 'success' ? 'success' : 'error' }}" role="alert">
        <span>{{ session('message') }}</span>
    </div>
    <!-- </div> -->

@endif
