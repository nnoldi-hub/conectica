<?php

namespace App\Notifications;

use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class SystemErrorOccurred extends Notification
{
    use Queueable;

    public function __construct(
        public string $exceptionClass,
        public string $message,
        public string $location,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Eroare in sistem')
            ->body($this->exceptionClass.': '.Str::limit($this->message, 160)." ({$this->location})")
            ->icon('heroicon-o-exclamation-triangle')
            ->color('danger')
            ->getDatabaseMessage();
    }
}
