<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to attendees of upcoming events';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereDate('start_time', now()->addDay())
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info("Found $eventCount $eventLabel");

        $events->each(
            fn($event) => $event->attendees->each(
                fn($attendee) => $attendee->user->notify(new EventReminder($event))
            )
        );

        $this->info("Reminder Notifications sent successfully!");
    }
}
