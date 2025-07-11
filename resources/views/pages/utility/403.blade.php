<x-app-layout background="bg-white dark:bg-gray-900">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <div class="max-w-2xl m-auto mt-16">
            <div class="text-center px-4">
                <div class="inline-flex mb-8">
                    <img class="dark:hidden" src="{{ asset('images/404-illustration.svg') }}" width="176" height="176" alt="Unauthorized illustration" />
                    <img class="hidden dark:block" src="{{ asset('images/404-illustration-dark.svg') }}" width="176" height="176" alt="Unauthorized illustration dark" />                        
                </div>
                <div class="mb-6 text-lg font-semibold text-red-600 dark:text-red-400">You are not authorized to access this page.</div>
                <a href="{{ route('tickets.dashboard') }}" class="btn bg-indigo-500 hover:bg-indigo-600 text-white">Back To Dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout> 