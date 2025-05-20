<?php

namespace App\Jobs;

use App\Models\Location;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LocationTrackingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $attendanceId;
    protected $guardId;
    protected $latitude;
    protected $longitude;

    /**
     * Create a new job instance.
     */
    public function __construct($attendanceId, $guardId, $latitude, $longitude)
    {
        $this->attendanceId = $attendanceId;
        $this->guardId = $guardId;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Location::create([
                'attendance_id' => $this->attendanceId,
                'guard_id' => $this->guardId,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);
        } catch (\Exception $e) {
            Log::error('Location tracking error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception)
    {
        Log::error('Location tracking job failed: ' . $exception->getMessage());
    }
} 