<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    public function setup(): void
    {
        parent::setUp();

        $this->signIn();
    }

    public function test_a_notification_is_prepared_when_a_subscribed_thread_recieves_a_new_reply()
    {
         $thread = create('App\Thread')->subscribe();

         $this->assertCount(0, auth()->user()->notifications);

         $thread->addReply([
             'user_id' => auth()->id(),
             'body' => 'Some reply ...'
         ]);

         $this->assertCount(0, auth()->user()->fresh()->notifications);

         $thread->addReply([
             'user_id' => create('App\User')->id,
             'body' => 'Some reply ...'
         ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function test_a_user_can_fetch_their_unread_notifications()
    {
         $thread = create('App\Thread')->subscribe();

         $thread->addReply([
             'user_id' => create('App\User')->id,
             'body' => 'Some reply ...'
         ]);

         $response = $this->getJson("/profiles/" . auth()->user()->name . "/notifications")->json();

         $this->assertCount(1, $response);
    }

    public function test_a_user_can_mark_a_notification_as_read()
    {
         $thread = create('App\Thread')->subscribe();

         $thread->addReply([
             'user_id' => create('App\User')->id,
             'body' => 'Some reply ...'
         ]);

         $user = auth()->user();

         $notificationId = $user->unreadNotifications->first()->id;

         $this->assertCount(1, $user->unreadNotifications);

         $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

         $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
