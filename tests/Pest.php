<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * Create and authenticate a student user
 */
function createStudent(array $attributes = []): App\Models\User
{
    return App\Models\User::factory()->create($attributes);
}

/**
 * Create and authenticate a verified student user
 */
function createVerifiedStudent(array $attributes = []): App\Models\User
{
    return App\Models\User::factory()->create(array_merge([
        'email_verified_at' => now(),
    ], $attributes));
}

/**
 * Create and authenticate a company
 */
function createCompany(array $attributes = []): App\Models\Company
{
    return App\Models\Company::factory()->create(array_merge([
        'status' => 'active', // Set active status for tests to pass approval middleware
    ], $attributes));
}

/**
 * Create a job posting for a company
 */
function createJobPosting(?App\Models\Company $company = null, array $attributes = []): App\Models\JobPosting
{
    $company = $company ?? createCompany();
    
    return App\Models\JobPosting::factory()->create(array_merge([
        'company_id' => $company->id,
    ], $attributes));
}

