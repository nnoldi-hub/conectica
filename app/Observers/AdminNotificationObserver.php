<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\Project;
use App\Models\User;
use App\Notifications\NewPostCreated;
use App\Notifications\NewProjectCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class AdminNotificationObserver
{
    public function created(Model $model): void
    {
        $notification = match (true) {
            $model instanceof Project => new NewProjectCreated($model),
            $model instanceof Post => new NewPostCreated($model),
            default => null,
        };

        if (! $notification) {
            return;
        }

        Notification::send(User::query()->canManageContentUsers()->get(), $notification);
    }
}
