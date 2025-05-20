<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TestQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public function __construct($message = 'Test Queue')
    {
        $this->message = $message;
    }

    public function handle()
    {
        Log::info('Test Queue Job Running: ' . $this->message);
        // Simulate some work
        sleep(2);
        Log::info('Test Queue Job Completed: ' . $this->message);
    }
} 