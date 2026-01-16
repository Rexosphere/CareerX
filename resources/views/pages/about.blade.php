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
                            University of Moratuwa<br>
                            Katubedda, Moratuwa 10400<br>
                            Sri Lanka
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 max-w-4xl mx-auto">
            <h3 class="text-lg font-bold text-center mb-4 text-base-content/60 uppercase tracking-widest text-xs">
                Developed By</h3>

            <p class="hidden">
                Meet the Developers

                The CareerX platform was conceptualized and brought to life by a dynamic team of Computer Science and
                Engineering undergraduates from the University of Moratuwa. Driven by a shared vision to bridge the gap
                between academia and industry, Suhas Dissanayake, Kalana Liyanage, Sangeeth Kariyapperuma, Kalana
                Abeysundara and Ifaz Ikram,utilized their technical expertise to engineer this seamless job portal.

                Developed as a flagship initiative of the IEEE Student Branch of University of Moratuwa and powered by
                the generous sponsorship of SLT-MOBITEL, this project stands as a testament to their commitment to
                innovation and empowering the next generation of Sri Lankan professionals.
            </p>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">







                <div
                    class="bg-base-100 border border-base-200 rounded-lg p-3 text-center hover:shadow-md transition-shadow">
                    <p class="font-semibold text-sm truncate">Suhas Dissanayeke</p>
                    <div class="flex justify-center gap-3 mt-2">
                        <a href="https://linkedin.com/in/suhasdissa" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-secondary transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://github.com/suhasdissa" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-secondary transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="bg-base-100 border border-base-200 rounded-lg p-3 text-center hover:shadow-md transition-shadow">
                    <p class="font-semibold text-sm truncate">Kalana Liyanage</p>
                    <div class="flex justify-center gap-3 mt-2">
                        <a href="http://linkedin.com/in/kalana-liyanage-7a29a3241" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-accent transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://github.com/Kalana-Pankaja" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-accent transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div
                    class="bg-base-100 border border-base-200 rounded-lg p-3 text-center hover:shadow-md transition-shadow">
                    <p class="font-semibold text-sm truncate">Sangeeth Kariyapperuma</p>
                    <div class="flex justify-center gap-3 mt-2">
                        <a href="https://linkedin.com/in/nipunsgeeth" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-info transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://github.com/nipunsgeeth" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-info transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>





                <div
                    class="bg-base-100 border border-base-200 rounded-lg p-3 text-center hover:shadow-md transition-shadow">
                    <p class="font-semibold text-sm truncate">Kalana Abeysundara</p>
                    <div class="flex justify-center gap-3 mt-2">
                        <a href="https://linkedin.com/in/kalana-abeysundara" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-success transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://github.com/kalana03" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-success transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>


                <div
                    class="bg-base-100 border border-base-200 rounded-lg p-3 text-center hover:shadow-md transition-shadow">
                    <p class="font-semibold text-sm truncate">Ifaz Ikram</p>
                    <div class="flex justify-center gap-3 mt-2">
                        <a href="https://linkedin.com/in/ifaz-ikram" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-primary transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="https://github.com/Ifaz-Ikram" target="_blank"
                            class="opacity-60 hover:opacity-100 hover:text-primary transition-all">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>