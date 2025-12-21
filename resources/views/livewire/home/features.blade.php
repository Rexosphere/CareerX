<?php

use Livewire\Volt\Component;

new class extends Component {
    public array $features = [];

    public function mount(): void
    {
        $this->features = [
            [
                'icon' => 'academic-cap',
                'title' => 'Verified Students',
                'description' => 'Access a pool of pre-verified undergraduates from University of Moratuwa.'
            ],
            [
                'icon' => 'rocket-launch',
                'title' => 'Fast Hiring',
                'description' => 'Streamlined application process to connect with talent faster.'
            ],
            [
                'icon' => 'share',
                'title' => 'IEEE Network',
                'description' => 'Backed by the global IEEE network, ensuring quality and standards.'
            ]
        ];
    }
}; ?>

<section class="bg-base-100 py-16 border-t border-base-300">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($features as $feature)
                <div class="card bg-base-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="card-body">
                        <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center text-primary mb-4">
                            <x-icon :name="'o-' . $feature['icon']" class="w-6 h-6" />
                        </div>
                        <h3 class="card-title text-base-content">{{ $feature['title'] }}</h3>
                        <p class="text-base-content/70">{{ $feature['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
