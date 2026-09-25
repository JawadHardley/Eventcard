<?php

use App\Models\Event;
use App\Models\Guest;
use App\Models\GuestCheckIn;
use App\Models\User;

it('records each attendee checked in through a double guest card', function () {
    $user = User::factory()->create(['role' => 'user']);
    $event = Event::create([
        'order_name' => 'Wedding',
        'user_id' => $user->id,
    ]);
    $guest = Guest::create([
        'full_name' => 'Test Guest',
        'title' => 'double',
        'phone' => '+255658967697',
        'delivery_method' => 'sms',
        'order_id' => $event->id,
        'counter' => '[0/2]',
        'qrcode' => 'DOUBLE-TEST-CODE',
    ]);

    $this->actingAs($user)
        ->get(route('user.markfield', ['code' => $guest->qrcode, 'mark' => 1]))
        ->assertOk()
        ->assertJson(['status' => 'checked_in', 'counter' => '[1/2]']);

    $this->get(route('user.markfield', ['code' => $guest->qrcode, 'mark' => 1]))
        ->assertOk()
        ->assertJson(['status' => 'checked_in', 'counter' => '[2/2]']);

    $this->get(route('user.markfield', ['code' => $guest->qrcode, 'mark' => 1]))
        ->assertOk()
        ->assertJson(['status' => 'already_checked']);

    expect(GuestCheckIn::where('guest_id', $guest->id)->count())->toBe(2);
    expect(GuestCheckIn::where('guest_id', $guest->id)->pluck('attendee_number')->all())->toBe([1, 2]);
});

it('shows people attended and remaining seats on the user dashboard', function () {
    $user = User::factory()->create(['role' => 'user']);
    $event = Event::create([
        'order_name' => 'Wedding',
        'user_id' => $user->id,
    ]);
    $guest = Guest::create([
        'full_name' => 'Test Guest',
        'title' => 'double',
        'phone' => '+255658967697',
        'delivery_method' => 'sms',
        'order_id' => $event->id,
        'verified' => true,
        'counter' => '[1/2]',
        'qrcode' => 'DOUBLE-TEST-CODE',
    ]);
    GuestCheckIn::create([
        'guest_id' => $guest->id,
        'event_id' => $event->id,
        'attendee_number' => 1,
    ]);

    $this->actingAs($user)
        ->get(route('user.dashboard'))
        ->assertOk()
        ->assertSee('Guest Cards')
        ->assertSee('Cards Used')
        ->assertSee('People Attended')
        ->assertSee('Remaining Seats')
        ->assertSee('50% of 2 seats', false);
});

it('shows guest-card and attendee totals separately for each recent event', function () {
    $user = User::factory()->create(['role' => 'user']);
    $wedding = Event::create([
        'order_name' => 'Wedding Event',
        'user_id' => $user->id,
        'guest_limit' => 40,
    ]);
    $launch = Event::create([
        'order_name' => 'Launch Event',
        'user_id' => $user->id,
        'guest_limit' => 25,
    ]);

    $doubleCard = Guest::create([
        'full_name' => 'Wedding Guest',
        'title' => 'double',
        'phone' => '+255658967697',
        'delivery_method' => 'sms',
        'order_id' => $wedding->id,
        'verified' => true,
        'counter' => '[2/2]',
    ]);
    $singleCard = Guest::create([
        'full_name' => 'Launch Guest',
        'title' => 'single',
        'phone' => '+255712345678',
        'delivery_method' => 'sms',
        'order_id' => $launch->id,
        'verified' => true,
        'counter' => '[0/1]',
    ]);

    GuestCheckIn::create([
        'guest_id' => $doubleCard->id,
        'event_id' => $wedding->id,
        'attendee_number' => 1,
    ]);
    GuestCheckIn::create([
        'guest_id' => $doubleCard->id,
        'event_id' => $wedding->id,
        'attendee_number' => 2,
    ]);
    GuestCheckIn::create([
        'guest_id' => $singleCard->id,
        'event_id' => $launch->id,
        'attendee_number' => 1,
    ]);

    $this->actingAs($user)
        ->get(route('user.dashboard'))
        ->assertOk()
        ->assertViewHas('recentEvents', function ($events) use ($wedding, $launch) {
            $weddingMetrics = $events->firstWhere('id', $wedding->id);
            $launchMetrics = $events->firstWhere('id', $launch->id);

            return $weddingMetrics->guest_cards_count === 1
                && $weddingMetrics->cards_used_count === 1
                && $weddingMetrics->attendees_count === 2
                && $launchMetrics->guest_cards_count === 1
                && $launchMetrics->cards_used_count === 1
                && $launchMetrics->attendees_count === 1;
        })
        ->assertSee('Guest Cards')
        ->assertSee('Cards Used')
        ->assertSee('People Attended');
});
