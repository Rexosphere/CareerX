<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

test('initials method returns correct initials for single name', function () {
    $user = User::factory()->make(['name' => 'John']);
    
    expect($user->initials())->toBe('J');
});

test('initials method returns correct initials for full name', function () {
    $user = User::factory()->make(['name' => 'John Doe']);
    
    expect($user->initials())->toBe('JD');
});

test('initials method returns only first two initials for multiple names', function () {
    $user = User::factory()->make(['name' => 'John Michael Doe']);
    
    expect($user->initials())->toBe('JM');
});

test('user has student profile relationship', function () {
    $user = createStudent();
    
    expect($user->studentProfile())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasOne::class);
});

test('user has applications relationship', function () {
    $user = createStudent();
    
    expect($user->applications())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('user has blogs relationship', function () {
    $user = createStudent();
    
    expect($user->blogs())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('user has saved jobs relationship', function () {
    $user = createStudent();
    
    expect($user->savedJobs())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('user has research projects relationship', function () {
    $user = createStudent();
    
    expect($user->researchProjects())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('user has roles relationship', function () {
    $user = createStudent();
    
    expect($user->roles())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
});

test('hasRole returns true when user has role', function () {
    $user = createStudent();
    $role = Role::create(['name' => 'student']);
    $user->roles()->attach($role);
    
    expect($user->hasRole('student'))->toBeTrue();
});

test('hasRole returns false when user does not have role', function () {
    $user = createStudent();
    
    expect($user->hasRole('admin'))->toBeFalse();
});

test('hasPermission returns true when user role has permission', function () {
    $user = createStudent();
    $role = Role::create(['name' => 'student']);
    $permission = Permission::create(['name' => 'view-jobs']);
    
    $role->permissions()->attach($permission);
    $user->roles()->attach($role);
    
    expect($user->hasPermission('view-jobs'))->toBeTrue();
});

test('hasPermission returns false when user role does not have permission', function () {
    $user = createStudent();
    $role = Role::create(['name' => 'student']);
    $user->roles()->attach($role);
    
    expect($user->hasPermission('delete-users'))->toBeFalse();
});

test('isAdmin returns true when user has admin role', function () {
    $user = createStudent();
    $role = Role::create(['name' => 'admin']);
    $user->roles()->attach($role);
    
    expect($user->isAdmin())->toBeTrue();
});

test('isAdmin returns false when user does not have admin role', function () {
    $user = createStudent();
    
    expect($user->isAdmin())->toBeFalse();
});

test('isEmployer returns true when user has employer role', function () {
    $user = createStudent();
    $role = Role::create(['name' => 'employer']);
    $user->roles()->attach($role);
    
    expect($user->isEmployer())->toBeTrue();
});

test('isStudent returns true when user has student role', function () {
    $user = createStudent();
    $role = Role::create(['name' => 'student']);
    $user->roles()->attach($role);
    
    expect($user->isStudent())->toBeTrue();
});

test('user password is hashed', function () {
    $user = User::factory()->create(['password' => 'password123']);
    
    expect($user->password)->not->toBe('password123');
    expect(password_verify('password123', $user->password))->toBeTrue();
});

test('user implements must verify email interface', function () {
    $user = new User();
    
    expect($user)->toBeInstanceOf(\Illuminate\Contracts\Auth\MustVerifyEmail::class);
});
