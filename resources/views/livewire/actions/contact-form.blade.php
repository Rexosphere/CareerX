<div class="w-full">
    @if($successMessage)
        <div class="alert alert-success mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ $successMessage }}</span>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- Name Field -->
        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold">Name <span class="text-error">*</span></span>
            </label>
            <input type="text" wire:model.blur="name"
                class="input input-bordered w-full @error('name') input-error @enderror"
                placeholder="Enter your name" />
            @error('name')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold">Email <span class="text-error">*</span></span>
            </label>
            <input type="email" wire:model.blur="email"
                class="input input-bordered w-full @error('email') input-error @enderror"
                placeholder="Enter your email address" />
            @error('email')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <!-- Subject Field -->
        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold">Subject</span>
            </label>
            <input type="text" wire:model.blur="subject"
                class="input input-bordered w-full @error('subject') input-error @enderror"
                placeholder="Enter subject (optional)" />
            @error('subject')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <!-- Message Field -->
        <div class="form-control">
            <label class="label">
                <span class="label-text font-semibold">Message <span class="text-error">*</span></span>
            </label>
            <textarea wire:model.blur="message"
                class="textarea textarea-bordered w-full h-32 @error('message') textarea-error @enderror"
                placeholder="Enter your message (minimum 10 characters)"></textarea>
            @error('message')
                <label class="label">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
                <span wire:loading.remove>Send Message</span>
                <span wire:loading class="loading loading-spinner loading-sm"></span>
                <span wire:loading>Sending...</span>
            </button>
        </div>
    </form>
</div>