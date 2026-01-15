<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="hero min-h-125 relative overflow-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 bg-cover opacity-70"
        style="background-image: url('{{ asset('hero.avif') }}'); background-position: center 15%;">
    </div>
    
    <!-- Dark overlay for better text visibility -->
    <div class="absolute inset-0 z-[5] bg-black/40"></div>

    <div class="hero-content text-center z-10 relative">
        <div class="max-w-3xl">
            <!-- <div class="badge badge-primary badge-lg mb-4 backdrop-blur-sm bg-primary/80">
                University of Moratuwa
            </div> -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6">
                Connect with Future <span class="text-primary font-extrabold">Innovators</span>
            </h1>
            <p class="text-lg md:text-xl text-white/90 mb-8">
                The official bridge between University of Moratuwa's top engineering talent and the industry's leading
                opportunities.
            </p>

            <!-- Search Bar -->
            <div class="mb-8">
                <livewire:home.search-bar />
            </div>

            <div class="flex gap-8 justify-center flex-wrap">
                <a href="{{ route('students.index') }}" class="btn btn-lg btn-primary px-8 rounded-lg"
                    wire:navigate>Find Talent</a>
                <a href="{{ route('jobs.index') }}"
                    class="btn btn-lg btn-outline px-8 rounded-lg text-white border-white hover:bg-white hover:text-base-content"
                    wire:navigate>Search Jobs</a>
            </div>
        </div>
    </div>
</div>