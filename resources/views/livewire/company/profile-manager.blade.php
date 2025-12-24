<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Validate;
use App\Models\Company;

new class extends Component {
    use WithFileUploads;

    public Company $company;

    // Profile information
    public string $name = '';
    public string $description = '';
    public $logo;
    public $logo_path;

    // Password change
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public function mount()
    {
        /** @var Company $company */
        $company = auth('company')->user();
        $this->company = $company;
        $this->name = $this->company->name;
        $this->description = $this->company->description ?? '';
        $this->logo_path = $this->company->logo_path;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'logo' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if ($this->logo) {
            $this->logo_path = $this->logo->store('logos', 'public');
        }

        $this->company->update([
            'name' => $this->name,
            'description' => $this->description,
            'logo_path' => $this->logo_path,
        ]);

        // Success notification
        $this->dispatch('toast', type: 'success', message: 'Profile updated successfully!', title: 'Success');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password:company'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $this->company->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->dispatch('toast', type: 'success', message: 'Password changed successfully!', title: 'Success');
    }
}; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left Column: Logo & Basic Info -->
    <div class="lg:col-span-1 space-y-8">
        <div class="card bg-base-100 shadow-xl border border-base-200 overflow-hidden">
            <div class="card-body items-center text-center p-8">
                <div class="relative group">
                    <div class="avatar">
                        <div
                            class="w-32 h-32 rounded-2xl ring ring-primary ring-offset-base-100 ring-offset-2 overflow-hidden bg-base-200 flex items-center justify-center">
                            @if($logo)
                                <img src="{{ $logo->temporaryUrl() }}" />
                            @elseif($logo_path)
                                <img src="{{ asset('storage/' . $logo_path) }}" />
                            @else
                                <div class="text-4xl font-bold text-base-content/20">{{ $company->initials() }}</div>
                            @endif
                        </div>
                    </div>

                    <label
                        class="absolute -bottom-2 -right-2 btn btn-circle btn-primary btn-sm shadow-lg cursor-pointer">
                        <x-icon name="o-camera" class="w-4 h-4" />
                        <input type="file" wire:model="logo" class="hidden" accept="image/*" />
                    </label>
                </div>

                <div class="mt-6">
                    <h2 class="text-2xl font-bold">{{ $company->name }}</h2>
                    <p class="text-base-content/60 text-sm italic">{{ $company->email }}</p>
                </div>

                <div class="divider"></div>

                <div class="w-full space-y-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-base-content/60">Status</span>
                        <div class="badge badge-success badge-sm">Verified Partner</div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-base-content/60">Member Since</span>
                        <span class="font-medium">{{ $company->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="card bg-base-100 shadow-xl border border-base-200">
            <div class="card-body p-8">
                <h3 class="card-title text-xl mb-6 flex items-center gap-2">
                    <x-icon name="o-key" class="w-6 h-6 text-primary" />
                    Security
                </h3>

                <form wire:submit="updatePassword" class="space-y-4">
                    <x-input label="Current Password" type="password" wire:model="current_password" icon="o-lock-closed"
                        placeholder="••••••••" />
                    <x-input label="New Password" type="password" wire:model="new_password" icon="o-shield-check"
                        placeholder="••••••••" />
                    <x-input label="Confirm New Password" type="password" wire:model="new_password_confirmation"
                        icon="o-shield-check" placeholder="••••••••" />

                    <div class="pt-4">
                        <x-button label="Change Password" type="submit" class="btn-primary w-full"
                            spinner="updatePassword" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Editable Profile -->
    <div class="lg:col-span-2 space-y-8">
        <div class="card bg-base-100 shadow-xl border border-base-200 h-full">
            <div class="card-body p-8 sm:p-10">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="card-title text-2xl flex items-center gap-3">
                        <x-icon name="o-building-office" class="w-7 h-7 text-primary" />
                        Company Details
                    </h3>
                </div>

                <form wire:submit="updateProfile" class="space-y-8">
                    <div class="grid grid-cols-1 gap-6">
                        <x-input label="Company Name" wire:model="name" icon="o-identification"
                            placeholder="Enterprise name" class="input-lg font-bold" />

                        <x-textarea label="Company Description" wire:model="description"
                            placeholder="Tell us about your company, its mission, and what it's like to work there..."
                            rows="10" class="text-base leading-relaxed focus:border-primary transition-all"
                            hint="Maximum 2000 characters" />
                    </div>

                    <div class="divider"></div>

                    <div class="flex justify-end gap-3">
                        <x-button label="Save Changes" type="submit" class="btn-primary px-10"
                            spinner="updateProfile" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>