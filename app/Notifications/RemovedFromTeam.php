<?php

namespace App\Notifications;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemovedFromTeam extends Notification
{
    use Queueable;

    protected $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You have been removed from the team: ' . $this->team->name);
    }

    public function toArray($notifiable)
    {
        return [
            'team_id' => $this->team->id,
            'team_name' => $this->team->name,
        ];
    }
}