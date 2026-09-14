<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogObserver
{
    public function created(Model $model): void
    {
        $this->record($model, 'created', 'A creat');
    }

    public function updated(Model $model): void
    {
        $this->record($model, 'updated', 'A modificat', $model->getChanges());
    }

    public function deleted(Model $model): void
    {
        $this->record($model, 'deleted', 'A sters');
    }

    private function record(Model $model, string $action, string $verb, ?array $changes = null): void
    {
        if (! auth()->check() || $model instanceof AuditLog) {
            return;
        }

        $label = $model->getAttribute('title')
            ?? $model->getAttribute('name')
            ?? $model->getAttribute('email')
            ?? ('#'.$model->getKey());

        AuditLog::query()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'subject_type' => $model::class,
            'subject_id' => $model->getKey(),
            'description' => sprintf('%s %s %s', $verb, class_basename($model), $label),
            'changes' => $changes,
        ]);
    }
}
