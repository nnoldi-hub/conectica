<?php

namespace App\Notifications;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewPostCreated extends Notification
{
    use Queueable;

    public function __construct(public Post $post) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Articol nou creat')
            ->body('Articolul "'.$this->post->title.'" a fost adaugat in blog.')
            ->icon('heroicon-o-newspaper')
            ->color('info')
            ->actions([
                Action::make('view')
                    ->label('Vezi articolul')
                    ->url(PostResource::getUrl('edit', ['record' => $this->post]))
                    ->markAsRead(),
            ])
            ->getDatabaseMessage();
    }
}
