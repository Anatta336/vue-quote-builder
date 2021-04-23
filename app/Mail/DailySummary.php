<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class DailySummary extends Mailable
{
    use Queueable, SerializesModels;

    protected Collection $quotes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $quotes)
    {
        $this->quotes = $quotes;
        echo "construct mailable with quotes\n";
    }

    /**
     * Build the message.
     *
     * @return mixed
     */
    public function build()
    {
        echo "building Mailable\n";
        return $this->from(Config::get('mail.from.address'), Config::get('mail.from.name'))
            ->subject('Recent Quotes')
            ->view('email.dailySummary', ['quotes' => $this->quotes]);
    }
}
