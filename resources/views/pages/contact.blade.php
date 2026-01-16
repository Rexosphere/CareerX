<x-layouts.public title="Contact Us">
    <div class="min-h-screen bg-base-100 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-base-content mb-4">Contact Us</h1>
                <p class="text-lg text-base-content/70">
                    Have a question or feedback? We'd love to hear from you. Send us a message and we'll respond as soon
                    as possible.
                </p>
            </div>

            <!-- Contact Form -->
            <div class="card bg-base-200 shadow-xl">
                <div class="card-body">
                    <livewire:actions.contact-form />
                </div>
            </div>

            <!-- Additional Contact Information -->
            <div class="mt-12 text-center">
                <h2 class="text-2xl font-semibold text-base-content mb-4">Other Ways to Reach Us</h2>
                <div class="flex flex-col sm:flex-row justify-center gap-6 text-base-content/70">
                    <div class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:support@careerx.lk" class="link link-hover">support@careerx.lk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>