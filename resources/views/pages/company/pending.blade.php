<x-layouts.public title="Registration Pending - CareerX">
    <div
        class="min-h-screen py-16 px-4 bg-gradient-to-br from-base-100 via-base-200 to-base-300 relative overflow-hidden flex items-center justify-center">
        {{-- Decorative background elements --}}
        <div class="absolute top-0 right-0 -mr-24 -mt-24 w-96 h-96 bg-warning/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-24 -mb-24 w-96 h-96 bg-warning/5 rounded-full blur-3xl"></div>

        <div class="w-full max-w-2xl relative z-10">
            <div class="card bg-base-100 shadow-2xl border border-base-200">
                <div class="card-body p-12 text-center">
                    {{-- Icon --}}
                    <div
                        class="w-24 h-24 bg-warning/10 rounded-full flex items-center justify-center text-warning mx-auto mb-8 animate-pulse">
                        <x-icon name="o-clock" class="w-12 h-12" />
                    </div>

                    {{-- Title --}}
                    <h1 class="text-4xl font-black tracking-tight text-base-content mb-4">
                        Registration Pending Approval
                    </h1>

                    {{-- Company Name --}}
                    @auth('company')
                        <p class="text-xl text-base-content/80 mb-8">
                            <span class="font-bold">{{ auth('company')->user()->name }}</span>
                        </p>
                    @endauth

                    {{-- Description --}}
                    <div class="max-w-lg mx-auto space-y-4 mb-10">
                        <p class="text-base-content/70 leading-relaxed">
                            Thank you for registering with CareerX! Your company registration is currently under review
                            by our administration team.
                        </p>
                        <p class="text-sm text-base-content/60 leading-relaxed">
                            You will receive an email notification once your account has been reviewed and approved. This
                            process typically takes 1-2 business days.
                        </p>
                    </div>

                    {{-- Info Panel --}}
                    <div class="bg-base-200/50 p-6 rounded-xl border border-base-300 mb-8">
                        <div class="flex items-start gap-4">
                            <x-icon name="o-information-circle" class="w-6 h-6 text-primary shrink-0 mt-0.5" />
                            <div class="text-left">
                                <p class="font-bold text-base-content mb-2">What's Next?</p>
                                <ul class="text-sm text-base-content/70 space-y-2">
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span>Our team will verify your company information</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span>You'll receive an email once approved</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <span class="text-primary">•</span>
                                        <span>Then you can access your dashboard and post jobs</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-outline gap-2">
                            <x-icon name="o-home" class="w-5 h-5" />
                            Back to Homepage
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-ghost gap-2">
                                <x-icon name="o-arrow-left-on-rectangle" class="w-5 h-5" />
                                Logout
                            </button>
                        </form>
                    </div>

                    {{-- Support Info --}}
                    <div class="mt-10 pt-8 border-t border-base-200">
                        <p class="text-sm text-base-content/60">
                            Have questions? Contact us at
                            <a href="mailto:support@careerx.com" class="link link-primary font-bold">support@careerx.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
