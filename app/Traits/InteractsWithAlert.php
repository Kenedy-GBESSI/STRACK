<?php

declare(strict_types=1);

namespace App\Traits;

trait InteractsWithAlert
{
    /**
     * Flash the banner message into session.
     */
    public function alert(string $message, string $type = 'success', ?int $duration = null): void
    {
        request()->session()->flash('alert', [
            'type' => $type,
            'message' => $message,
            'duration' => $duration,
        ]);
    }

    public function successAlert(string $message, ?int $duration = null): void
    {
        $this->alert($message, 'success', $duration);
    }

    /**
     * Flash the danger alert message into session.
     */
    public function warningAlert(string $message, ?int $duration = null): void
    {
        $this->alert($message, 'warning', $duration);
    }

    /**
     * Flash the danger banner message into session.
     */
    public function dangerAlert(string $message, ?int $duration = null): void
    {
        $this->alert($message, 'danger', $duration);
    }
}
