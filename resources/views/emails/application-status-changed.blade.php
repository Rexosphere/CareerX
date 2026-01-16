@php
    $statusConfig = [
        'pending' => ['color' => 'gray', 'label' => 'Under Review', 'emoji' => '⏳'],
        'reviewed' => ['color' => 'blue', 'label' => 'Reviewed', 'emoji' => '👀'],
        'shortlisted' => ['color' => 'purple', 'label' => 'Shortlisted', 'emoji' => '⭐'],
        'rejected' => ['color' => 'red', 'label' => 'Not Selected', 'emoji' => '❌'],
        'accepted' => ['color' => 'green', 'label' => 'Accepted', 'emoji' => '✅'],
    ];
    
    $status = $statusConfig[$newStatus] ?? $statusConfig['pending'];
    
    $nextSteps = [
        'pending' => 'The company is currently reviewing your application. We\'ll notify you of any updates.',
        'reviewed' => 'Your application has been reviewed by the company. They may contact you soon for next steps.',
        'shortlisted' => 'Great news! You\'ve been shortlisted. The company may reach out for an interview or further assessment.',
        'rejected' => 'While you weren\'t selected for this position, we encourage you to apply for other opportunities on CareerX.',
        'accepted' => 'Congratulations! You\'ve been accepted. The company will contact you with next steps.',
    ];
@endphp

<x-mail::message>
# Application Status Update

Hello **{{ $studentName }}**,

There's an update on your job application!

<x-mail::panel>
## Application Details

**Position:** {{ $jobTitle }}  
**Company:** {{ $companyName }}  
**Status:** {{ $status['emoji'] }} **{{ $status['label'] }}**
</x-mail::panel>

## What This Means

{{ $nextSteps[$newStatus] ?? 'Your application status has been updated.' }}

@if($newStatus === 'shortlisted' || $newStatus === 'accepted')
<x-mail::button url="{{ route('jobs.index') }}" color="success">
View Your Applications
</x-mail::button>
@else
<x-mail::button url="{{ route('jobs.index') }}">
Explore More Opportunities
</x-mail::button>
@endif

## Stay Active

Keep exploring opportunities on CareerX and make sure your profile is up to date to increase your chances with other employers.

Best of luck with your career journey!

Best regards,<br>
The {{ config('app.name') }} Team
</x-mail::message>
