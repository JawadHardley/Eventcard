<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ferix io</title>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.3.2/dist/css/tabler.min.css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>

<body>

    <div class="page">
        <!-- Sidebar -->
        <aside class="navbar navbar-vertical navbar-expand-sm" data-bs-theme="dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark">
                    <a href="/" class="text-decoration-none">
                        <i class="fa fa-layer-group"></i> <b>EventCard</b>
                    </a>
                </h1>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav pt-lg-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route(Auth::user()->role . '' . '.dashboard') }}">
                                <i class="fa fa-house pe-3"></i>
                                <span class="nav-link-title"> Home </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.transactions') }}">
                                <i class="fa fa-money-bill-transfer pe-3"></i>
                                <span class="nav-link-title"> Transactions </span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                data-bs-auto-close="false" role="button" aria-expanded="false">
                                <i class="fa fa-user pe-3"></i>
                                <span class="nav-link-title"> User Management </span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">
                                    Admins
                                </a>
                                <a class="dropdown-item" href="#">
                                    Others
                                </a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </aside>


        <div class="row" id="navbarNav">
            <header class="navbar navbar-expand-sm navbar-light d-print-none p-2">
                <div class="container-fluid">
                    <div class="col">
                        <!-- // -->
                    </div>
                    <div class="pe-0 pe-md-3">
                        <a href="#" class="badge bg-azure-lt ms-2 px-3 py-2 fs-3 text-decoration-none"
                            id="themeToggle">
                            <i class="fa fa-moon" id="themeIcon"></i>
                        </a>
                    </div>
                    <div class="navbar-nav flex-row order-md-last dropdown">
                        <div class="nav-item">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                                aria-label="Open user menu" aria-expanded="false">
                                <span class="avatar avatar-sm text-primary">
                                    <i class="fa fa-user"></i>
                                </span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>{{ Str::title(strtolower(Auth::user()->name)) }}</div>
                                    <div class="mt-1 small text-secondary">{{ Str::title(Auth::user()->role) }}</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end flex-row order-md-last">
                                <a href="#" class="dropdown-item">Profile</a>
                                <a href="#" class="dropdown-item">Dashboard</a>
                                <!-- <a href="#" class="dropdown-item">Feedback</a> -->
                                <div class="dropdown-divider"></div>
                                <!-- <a href="./settings.html" class="dropdown-item">Settings</a> -->
                                <form method="POST" action="#">
                                    @csrf

                                    <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                        data-bs-target="#logoutmodal">
                                        Logout
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="logoutmodal" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">Alert!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to logout ?!
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Yes, Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
