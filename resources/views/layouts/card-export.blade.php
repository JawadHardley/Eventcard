<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation Card</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,500&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet">
    <style>
        html,
        body {
            width: 680px;
            height: 880px;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: transparent;
        }

        .cardview-page {
            display: block !important;
            width: 680px !important;
            height: 880px !important;
            min-height: 880px !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .card-actions,
        .share-panel,
        .download-overlay {
            display: none !important;
        }

        .invitation-shell {
            display: block !important;
            width: 680px !important;
            height: 880px !important;
            max-width: 680px !important;
            margin: 0 !important;
            padding: 0 !important;
            perspective: none !important;
            transform: none !important;
            animation: none !important;
        }

        #idcard {
            display: grid !important;
            grid-template-columns: 55fr 45fr !important;
            width: 680px !important;
            height: 880px !important;
            min-height: 880px !important;
            max-width: 680px !important;
            margin: 0 !important;
            transform: none !important;
            animation: none !important;
        }

        #idcard .card-right {
            height: 100% !important;
            min-height: 100% !important;
        }

        #idcard .card-image {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }
    </style>
</head>

<body>
    @yield('content')
</body>

</html>
