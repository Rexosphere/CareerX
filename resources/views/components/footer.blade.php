<footer class="bg-base-100 border-t border-base-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Footer Content -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <!-- Brand & Info -->
            <div class="flex items-center gap-3">
                <img id="footer-logo" src="{{ asset('careerxlogo-black.avif') }}" alt="CareerX Logo" class="h-12 w-auto object-contain">
                <div>
                    <p class="text-sm font-bold">University of Moratuwa</p>
                </div>
            </div>

            <script>
                function updateFooterLogo() {
                    const logo = document.getElementById('footer-logo');
                    if (logo) {
                        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                        if (prefersDark) {
                            logo.src = '{{ asset('careerxlogo.avif') }}';
                        } else {
                            logo.src = '{{ asset('careerxlogo-black.avif') }}';
                        }
                    }
                }
                
                // Update on load
                updateFooterLogo();
                
                // Watch for theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateFooterLogo);
            </script>

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