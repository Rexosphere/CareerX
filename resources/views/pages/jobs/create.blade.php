<x-layouts.main title="Post a Job">
    <div class="container mx-auto max-w-3xl px-4 py-10">
        <div class="mb-8">
            <a href="{{ route('company.profile') }}" class="btn btn-ghost btn-sm pl-0 mb-2">
                <x-icon name="o-arrow-left" class="w-4 h-4 mr-1" /> Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold">Post a New Job</h1>
            <p class="text-base-content/70 mt-1">Fill in the details below to create a new job listing.</p>
        </div>

        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body">
                <form action="#" method="POST">
                    @csrf
                    <!-- Title & Company -->
                    <div class="form-control w-full mb-4">
                        <label class="label">
                            <span class="label-text font-medium">Job Title</span>
                        </label>
                        <input type="text" name="title" placeholder="e.g. Senior Software Engineer"
                            class="input input-bordered w-full" required />
                    </div>

                    <!-- Category & Type -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Category</span>
                            </label>
                            <select class="select select-bordered w-full">
                                <option disabled selected>Select Category</option>
                                <option>Software Engineering</option>
                                <option>Data Science & AI</option>
                                <option>Product Management</option>
                                <option>Design</option>
                                <option>Marketing</option>
                                <option>Other</option>
                            </select>
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Job Type</span>
                            </label>
                            <select class="select select-bordered w-full">
                                <option>Full-time</option>
                                <option>Part-time</option>
                                <option>Contract</option>
                                <option>Internship</option>
                                <option>Freelance</option>
                            </select>
                        </div>
                    </div>

                    <!-- Location & Salary -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Location</span>
                            </label>
                            <input type="text" name="location" placeholder="e.g. Remote, Sri Lanka"
                                class="input input-bordered w-full" />
                        </div>
                        <div class="form-control w-full">
                            <label class="label">
                                <span class="label-text font-medium">Salary Range</span>
                            </label>
                            <input type="text" name="salary" placeholder="e.g. $80k - $120k"
                                class="input input-bordered w-full" />
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-control w-full mb-6">
                        <label class="label">
                            <span class="label-text font-medium">Job Description</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered h-48"
                            placeholder="Detailed description of the role, responsibilities, and requirements..."
                            required></textarea>
                    </div>

                    <!-- Application Deadline -->
                    <div class="form-control w-full md:w-1/2 mb-8">
                        <label class="label">
                            <span class="label-text font-medium">Application Deadline</span>
                        </label>
                        <input type="date" name="deadline" class="input input-bordered w-full" />
                    </div>

                    <div class="card-actions justify-end pt-4 border-t border-base-200">
                        <button type="button" class="btn btn-ghost">Cancel</button>
                        <button type="submit" class="btn btn-primary">Publish Job</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>