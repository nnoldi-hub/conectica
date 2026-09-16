<?php

namespace App\Notifications;

use App\Filament\Resources\Projects\ProjectResource;
use App\Models\Project;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewProjectCreated extends Notification
{
    use Queueable;

    public function __construct(public Project $project) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Proiect nou adaugat')
            ->body('Proiectul "'.$this->project->title.'" a fost adaugat in portofoliu.')
            ->icon('heroicon-o-briefcase')
            ->color('success')
            ->actions([
                Action::make('view')
                    ->label('Vezi proiectul')
                    ->url(ProjectResource::getUrl('edit', ['record' => $this->project]))
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
