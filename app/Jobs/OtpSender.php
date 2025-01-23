<?php

namespace App\Jobs;

use App\Services\WaSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OtpSender implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $phone, protected string $token)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        new WaSender($this->phone,$this->token);
    }
}
