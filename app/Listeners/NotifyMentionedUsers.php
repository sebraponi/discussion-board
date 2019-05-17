<?php

namespace App\Listeners;

use App\Notifications\YouWereMentioned;
use App\User;
use App\Events\ThreadRecievedNewReply;


class NotifyMentionedUsers
{

    /**
     * Handle the event.
     *
     * @param  ThreadRecievedNewReply  $event
     * @return void
     */
    public function handle(ThreadRecievedNewReply $event)
    {
        $users = User::whereIn('name', $event->reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($event) {
                $user->notify(new YouWereMentioned($event->reply));
            });
    }
}
