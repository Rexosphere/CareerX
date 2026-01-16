<x-mail::message>
# Registration Update

Hello **{{ $companyName }}**,

Thank you for your interest in partnering with CareerX. After careful review, we're unable to approve your company registration at this time.

<x-mail::panel>
## Reasons for This Decision

Our platform is designed to connect verified organizations with students from the University of Moratuwa. Registration requests may be declined for various reasons, including:

- Incomplete or unverifiable company information
- Company type not aligned with our platform's focus
- Other verification concerns
</x-mail::panel>

## What You Can Do

If you believe this decision was made in error or would like to provide additional information, please contact our support team at **support@careerx.com**. We'll be happy to review your case.

We appreciate your understanding.

Best regards,<br>
The {{ config('app.name') }} Team
</x-mail::message>
