<x-mail::message>
# Registration Received

Hello **{{ $companyName }}**,

Thank you for registering with CareerX! We've received your company registration and it's currently under review by our administration team.

<x-mail::panel>
## What's Next?

Our team will review your registration details and verify your company information. This process typically takes 1-2 business days.

You will receive an email notification once your account has been reviewed.
</x-mail::panel>

## In the Meantime

While you wait, feel free to explore:
- Our [blog]({{ route('blog.index') }}) for career insights
- The [student directory]({{ route('students.index') }}) to see the talent pool
- Our [resources]({{ route('resources.index') }}) for recruiting best practices

If you have any questions, please don't hesitate to reach out to our support team at support@careerx.com.

Thanks,<br>
The {{ config('app.name') }} Team
</x-mail::message>
