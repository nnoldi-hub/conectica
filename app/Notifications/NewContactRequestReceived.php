<?php

namespace App\Notifications;

use App\Filament\Resources\ContactRequests\ContactRequestResource;
use App\Models\ContactRequest;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewContactRequestReceived extends Notification
{
    use Queueable;

    public function __construct(public ContactRequest $contactRequest) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Cerere noua de contact')
            ->body($this->contactRequest->name.' a trimis o solicitare'.($this->contactRequest->service ? ' pentru "'.$this->contactRequest->service.'"' : '').'.')
            ->icon('heroicon-o-envelope')
            ->color('warning')
            ->actions([
                Action::make('view')
                    ->label('Vezi cererea')
                    ->url(ContactRequestResource::getUrl('edit', ['record' => $this->contactRequest]))
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
