<x-layouts.main title="Admin Access Control" :showNavbar="false" :showFooter="false">
    <div
        class="min-h-[calc(100vh-4rem)] flex items-center justify-center p-4 bg-gradient-to-br from-base-200 to-base-300 relative overflow-hidden">
        <!-- Abstract background pattern -->
        <div class="absolute inset-0 opacity-40">
            <div
                class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob">
            </div>
            <div
                class="absolute top-0 -right-4 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="relative w-full max-w-md">
            <livewire:auth.admin-login-form />
        </div>
    </div>
</x-layouts.main>