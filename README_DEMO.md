# Demo Data Setup

## Quick Start
Run \`composer demo\` to reset the database and seed with realistic demo data.

## What's Included
- **50 Users** with realistic names and emails
- **20 Companies** (active status for job postings)
- **100 Job Postings** (2-8 per company)
- **100 Videos** across CV Writing, Interview Prep, Industry Insights, Academia
- **40 Research Projects** with various types and statuses
- **25 Student Profiles** (50% of users get profiles)

## Customization
Set environment variables to customize counts:
- DEMO_USERS=50
- DEMO_COMPANIES=20
- DEMO_VIDEOS=100
- DEMO_PROJECTS=40
- DEMO_PROFILES_PERCENT=50

## Manual Commands
- Seed only: \`php artisan db:seed --class=DemoSeeder\`
- Fresh DB + seed: \`php artisan migrate:fresh --seed --seeder=DemoSeeder\`

