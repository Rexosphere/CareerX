<footer class="bg-base-100 border-t border-base-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Footer Content -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Brand & Info -->
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded bg-primary/10 text-primary flex items-center justify-center">
                    <x-icon name="o-academic-cap" class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-sm font-bold">University of Moratuwa</p>
                    <p class="text-xs text-base-content/60">CareerX</p>
                </div>
            </div>

            <!-- Links -->
            <div class="flex gap-8 text-sm text-base-content/70 flex-wrap justify-center">
                <a class="link link-hover hover:text-primary" href="{{ route('about') }}">About Us</a>
                <a class="link link-hover hover:text-primary" href="{{ route('legal.privacy') }}">Privacy Policy</a>
                <a class="link link-hover hover:text-primary" href="{{ route('legal.terms') }}">Terms of Service</a>
                <a class="link link-hover hover:text-primary" href="mailto:support@careerx.lk">Contact Support</a>
            </div>

            <!-- Copyright -->
            <div class="text-xs text-base-content/60">
                © {{ date('Y') }} University of Moratuwa. All rights reserved.
            </div>
        </div>
    </div>
</footer>