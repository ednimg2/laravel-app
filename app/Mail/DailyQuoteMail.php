<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyQuoteMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private User $user;
    private string $dailyQuete;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $dailyQuete
     */
    public function __construct(User $user, string $dailyQuete)
    {
        $this->user = $user;
        $this->dailyQuete = $dailyQuete;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.dailyQuote')
            ->from('example@example.com')
            ->to($this->user->email)
            ->subject('Daily New Quote!')
            ->with([
                'dailyQuete' => $this->dailyQuete
            ]);
    }
}
