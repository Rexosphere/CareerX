<x-mail::message>
# New Company Registration - Action Required

A new company has registered on the CareerX platform and requires your review.

<x-mail::panel>
## Company Details

**Company Name:** {{ $company->name }}  
**Email:** {{ $company->email }}  
**Registration Date:** {{ $company->created_at->format('F d, Y \a\t g:i A') }}  
**Status:** Pending Approval
</x-mail::panel>

Please review this registration and take appropriate action.

<x-mail::button :url="$reviewUrl" color="primary">
Review in Admin Dashboard
</x-mail::button>

## Quick Actions

From the admin dashboard, you can:
- **Approve** the company to grant them access
- **Reject** the registration if it doesn't meet criteria
- View complete company details and verification information

This is an automated notification. Please do not reply to this email.

---

{{ config('app.name') }} Admin System
</x-mail::message>
