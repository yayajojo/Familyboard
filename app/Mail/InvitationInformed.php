<?php

namespace App\Mail;

use App\Project;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationInformed extends Mailable
{
    use Queueable, SerializesModels;
    public $invitedUser;
    public $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $invitedUser,Project $project)
    {
        $this->invitedUser = $invitedUser;
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invitation');
    }
}
