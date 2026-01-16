<x-mail::message>
# Welcome to CareerX!

Congratulations **{{ $companyName }}**! 🎉

Your company registration has been approved. You can now access your dashboard and start posting job opportunities to connect with talented students from the University of Moratuwa.

<x-mail::button :url="$loginUrl" color="success">
Access Your Dashboard
</x-mail::button>

<x-mail::panel>
## Getting Started

Here are some next steps to make the most of your CareerX account:

1. **Complete your company profile** - Add your logo, description, and company details
2. **Post your first job** - Create compelling job listings to attract top talent
3. **Browse student profiles** - Discover skilled candidates in our student directory
4. **Manage applications** - Review and respond to student applications efficiently
</x-mail::panel>

## Need Help?

Our support team is here to assist you. If you have any questions or need guidance, feel free to contact us at support@careerx.com.

We're excited to have you on board!

Best regards,<br>
The {{ config('app.name') }} Team
</x-mail::message>
