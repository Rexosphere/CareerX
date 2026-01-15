<footer class="bg-base-100 border-t border-base-300 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Footer Content -->
        <div class="flex flex-col gap-8">
            <!-- First Row: Links -->
            <div class="flex gap-8 text-sm text-base-content/70 justify-center border-b border-base-300 pb-6">
                <a class="link link-hover hover:text-primary" href="{{ route('about') }}">About Us</a>
                <a class="link link-hover hover:text-primary" href="{{ route('legal.privacy') }}">Privacy Policy</a>
                <a class="link link-hover hover:text-primary" href="{{ route('legal.terms') }}">Terms of Service</a>
                <a class="link link-hover hover:text-primary" href="mailto:support@careerx.lk">Contact Support</a>
            </div>

            <!-- Second Row: Logos -->
            <div class="flex flex-col md:flex-row items-center justify-center gap-6 md:gap-8">
                <img id="footer-logo" src="{{ asset('careerxlogo-black.avif') }}" alt="CareerX Logo" class="h-12 w-auto object-contain mt-4">
                <img src="{{ asset('sltlogo1.avif') }}" alt="SLT Logo 1" class="h-24 w-auto object-contain md:ml-16">
                <img src="{{ asset('sltlogo2.avif') }}" alt="SLT Logo 2" class="h-24 w-auto object-contain md:ml-10">
                <img src="{{ asset('Procomm.avif') }}" alt="Procomm Logo" class="h-32 w-auto object-contain mt-4">
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
        </div>
    </div>
</footer>