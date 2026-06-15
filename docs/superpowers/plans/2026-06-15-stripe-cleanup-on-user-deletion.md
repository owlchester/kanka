# Stripe Cleanup on User Deletion Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Clean up Stripe customer data when a user deletes their account — deleting the customer object if they never subscribed, or anonymizing PII if they have billing history.

**Architecture:** Add `removeStripeCustomer()` as the final step in `CleanupService::delete()`. It runs async inside the existing `DeleteUser` job, which already retries gracefully if the user is not found. The method is idempotent: anonymize is a safe overwrite, and delete handles `resource_missing` from Stripe silently.

**Tech Stack:** Laravel Cashier v15 (`$user->deleteStripeCustomer()`, `$user->updateStripeCustomer()`), Stripe PHP SDK (`Stripe\Exception\InvalidRequestException`), Mockery for partial mocks in Pest tests.

---

### Task 1: Add retry limit to `DeleteUser` job

**Files:**
- Modify: `app/Jobs/Users/DeleteUser.php`

- [ ] **Step 1: Add `$tries` property**

Open `app/Jobs/Users/DeleteUser.php`. After the `use` trait declarations (line 19), add the property:

```php
public int $tries = 3;
```

The file should look like:

```php
class DeleteUser implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    protected int $user;
    // ...
}
```

- [ ] **Step 2: Commit**

```bash
git add app/Jobs/Users/DeleteUser.php
git commit -m "feat: retry DeleteUser job up to 3 times"
```

---

### Task 2: Write failing tests for `removeStripeCustomer()`

**Files:**
- Create: `tests/Feature/Services/Users/CleanupServiceStripeTest.php`

- [ ] **Step 1: Create the test file**

```bash
vendor/bin/sail artisan make:test --pest Services/Users/CleanupServiceStripeTest
```

- [ ] **Step 2: Write the tests**

Replace the generated content of `tests/Feature/Services/Users/CleanupServiceStripeTest.php` with:

```php
<?php

use App\Models\User;
use App\Services\Users\CleanupService;
use Stripe\Exception\InvalidRequestException;

it('skips stripe cleanup when user has no stripe id', function () {
    $user = User::factory()->create(['stripe_id' => null]);

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldNotReceive('deleteStripeCustomer');
    $mock->shouldNotReceive('updateStripeCustomer');

    app(CleanupService::class)->user($mock)->removeStripeCustomer();
});

it('deletes stripe customer when user has no subscription history', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test123']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(false);

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldReceive('deleteStripeCustomer')->once();
    $mock->shouldNotReceive('updateStripeCustomer');

    app(CleanupService::class)->user($mock)->removeStripeCustomer();
});

it('anonymizes stripe customer when user has subscription history', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test456']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(true);

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldNotReceive('deleteStripeCustomer');
    $mock->shouldReceive('updateStripeCustomer')->once()->with([
        'name' => 'Deleted User',
        'email' => 'deleted+cus_test456@kanka.io',
    ]);

    app(CleanupService::class)->user($mock)->removeStripeCustomer();
});

it('silently ignores resource_missing when deleting stripe customer', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_already_deleted']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(false);

    $exception = Mockery::mock(InvalidRequestException::class);
    $exception->shouldReceive('getStripeCode')->andReturn('resource_missing');

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldReceive('deleteStripeCustomer')->andThrow($exception);

    // Should not throw
    app(CleanupService::class)->user($mock)->removeStripeCustomer();
});

it('re-throws unexpected stripe exceptions', function () {
    $user = User::factory()->create(['stripe_id' => 'cus_test789']);

    $subscriptionsMock = Mockery::mock();
    $subscriptionsMock->shouldReceive('exists')->andReturn(false);

    $exception = Mockery::mock(InvalidRequestException::class);
    $exception->shouldReceive('getStripeCode')->andReturn('card_declined');

    $mock = Mockery::mock($user)->makePartial();
    $mock->shouldReceive('subscriptions')->andReturn($subscriptionsMock);
    $mock->shouldReceive('deleteStripeCustomer')->andThrow($exception);

    expect(fn () => app(CleanupService::class)->user($mock)->removeStripeCustomer())
        ->toThrow(InvalidRequestException::class);
});
```

- [ ] **Step 3: Run tests to confirm they fail**

```bash
vendor/bin/sail artisan test --compact --filter=CleanupServiceStripe
```

Expected: all 5 tests FAIL with `Call to undefined method ... removeStripeCustomer()`.

---

### Task 3: Implement `removeStripeCustomer()` in `CleanupService`

**Files:**
- Modify: `app/Services/Users/CleanupService.php`

- [ ] **Step 1: Add the method call to `delete()`**

In `app/Services/Users/CleanupService.php`, update the `delete()` method to call `removeStripeCustomer()` last:

```php
public function delete(): self
{
    $this
        ->removeCampaigns()
        ->removeFollows()
        ->removeFeatureRequests()
        ->removeWorldbuilding()
        ->removeAvatar()
        ->cleanCache()
        ->removeNewsletter()
        ->removeStripeCustomer();

    return $this;
}
```

- [ ] **Step 2: Add the `removeStripeCustomer()` method**

Add this method after `removeNewsletter()` in `app/Services/Users/CleanupService.php`:

```php
public function removeStripeCustomer(): self
{
    if (! $this->user->hasStripeId()) {
        return $this;
    }

    if ($this->user->subscriptions()->exists()) {
        $this->user->updateStripeCustomer([
            'name' => 'Deleted User',
            'email' => 'deleted+' . $this->user->stripe_id . '@kanka.io',
        ]);

        return $this;
    }

    try {
        $this->user->deleteStripeCustomer();
    } catch (\Stripe\Exception\InvalidRequestException $e) {
        if ($e->getStripeCode() === 'resource_missing') {
            return $this;
        }
        throw $e;
    }

    return $this;
}
```

- [ ] **Step 3: Run Pint to fix formatting**

```bash
vendor/bin/sail bin pint --dirty --format agent
```

- [ ] **Step 4: Run the tests to confirm they pass**

```bash
vendor/bin/sail artisan test --compact --filter=CleanupServiceStripe
```

Expected: all 5 tests PASS.

- [ ] **Step 5: Commit**

```bash
git add app/Services/Users/CleanupService.php tests/Feature/Services/Users/CleanupServiceStripeTest.php
git commit -m "feat: clean up stripe customer data on user deletion"
```

---

### Task 4: Run full test suite

- [ ] **Step 1: Run all tests**

```bash
vendor/bin/sail artisan test --compact
```

Expected: all existing tests still pass.
