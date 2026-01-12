<x-layouts.public title="About Us">
    <div class="container mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 text-primary mb-6">
                <x-icon name="o-academic-cap" class="w-10 h-10" />
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About CareerX</h1>
            <p class="text-xl text-base-content/70 max-w-2xl mx-auto">
                The official career platform bridging University of Moratuwa's top talent with industry opportunities.
            </p>
        </div>

        <!-- Mission Section -->
        <div class="card bg-base-100 border border-base-300 shadow-sm mb-8">
            <div class="card-body p-8 md:p-12">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-primary/10 text-primary p-3 rounded-lg">
                        <x-icon name="o-rocket-launch" class="w-6 h-6" />
                    </div>
                    <h2 class="text-2xl font-bold">Our Mission</h2>
                </div>
                <p class="text-lg text-base-content/70 leading-relaxed">
                    CareerX is dedicated to empowering University of Moratuwa students and graduates by connecting them
                    with leading employers across Sri Lanka and beyond. We aim to streamline the recruitment process,
                    making it easier for talented engineers and professionals to find meaningful career opportunities.
                </p>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body">
                    <div class="bg-info/10 text-info p-3 rounded-lg w-fit mb-4">
                        <x-icon name="o-briefcase" class="w-6 h-6" />
                    </div>
                    <h3 class="card-title">For Students</h3>
                    <ul class="space-y-2 text-base-content/70">
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Browse and apply to verified job opportunities
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Build a professional profile showcasing your skills
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Access career resources and guidance
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Track your applications in one place
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card bg-base-100 border border-base-300 shadow-sm">
                <div class="card-body">
                    <div class="bg-secondary/10 text-secondary p-3 rounded-lg w-fit mb-4">
                        <x-icon name="o-building-office" class="w-6 h-6" />
                    </div>
                    <h3 class="card-title">For Companies</h3>
                    <ul class="space-y-2 text-base-content/70">
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Access top engineering talent from UoM
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Post job listings and manage applications
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Search and filter candidate profiles
                        </li>
                        <li class="flex items-start gap-2">
                            <x-icon name="o-check-circle" class="w-5 h-5 text-success mt-0.5" />
                            Build your employer brand with students
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- University Section -->
        <div class="card bg-gradient-to-br from-primary/5 to-secondary/5 border border-base-300 shadow-sm mb-8">
            <div class="card-body p-8 md:p-12">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-primary/10 text-primary p-3 rounded-lg">
                        <x-icon name="o-building-library" class="w-6 h-6" />
                    </div>
                    <h2 class="text-2xl font-bold">University of Moratuwa</h2>
                </div>
                <p class="text-lg text-base-content/70 leading-relaxed mb-6">
                    The University of Moratuwa is Sri Lanka's leading technological university, renowned for producing
                    world-class engineers, architects, and IT professionals. With a legacy of excellence spanning
                    decades, our graduates are sought after by top employers globally.
                </p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="p-4">
                        <div class="text-3xl font-bold text-primary">10,000+</div>
                        <div class="text-sm text-base-content/60">Students</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-primary">500+</div>
                        <div class="text-sm text-base-content/60">Partner Companies</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-primary">95%</div>
                        <div class="text-sm text-base-content/60">Employment Rate</div>
                    </div>
                    <div class="p-4">
                        <div class="text-3xl font-bold text-primary">50+</div>
                        <div class="text-sm text-base-content/60">Years of Excellence</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="card bg-base-100 border border-base-300 shadow-sm">
            <div class="card-body p-8 md:p-12">
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-warning/10 text-warning p-3 rounded-lg">
                        <x-icon name="o-envelope" class="w-6 h-6" />
                    </div>
                    <h2 class="text-2xl font-bold">Contact Us</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="font-semibold mb-2">General Inquiries</h4>
                        <p class="text-base-content/70 mb-4">
                            <a href="mailto:support@careerx.lk" class="link link-primary">support@careerx.lk</a>
                        </p>

                        <h4 class="font-semibold mb-2">For Companies</h4>
                        <p class="text-base-content/70">
                            <a href="mailto:partnerships@careerx.lk"
                                class="link link-primary">partnerships@careerx.lk</a>
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Address</h4>
                        <p class="text-base-content/70">
                            Career Guidance Unit<br>
                            University of Moratuwa<br>
                            Katubedda, Moratuwa 10400<br>
                            Sri Lanka
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-12 text-center">
            <a href="{{ route('home') }}" class="btn btn-primary btn-outline gap-2">
                <x-icon name="o-arrow-left" class="w-4 h-4" />
                Back to Home
            </a>
        </div>
    </div>
</x-layouts.public>