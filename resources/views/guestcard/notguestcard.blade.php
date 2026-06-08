<x-guest-layout>

    @section('title', 'Invitation Not Found')

    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 px-4">
        <div class="text-center max-w-md">
            <div class="text-8xl mb-4">🎫</div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Invalid Invitation</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-6">The link you used is not valid or has expired. Please check
                your
                invitation or contact the event host.</p>
            <a href="/" class="btn btn-primary">Go Home</a>
        </div>
    </div>
</x-guest-layout>
