<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! (auth()->user()?->canPublishContent() ?? false)) {
            $data['is_published'] = $this->record->is_published;
        }

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('gray')
                ->url(fn (): string => route('admin.pdf.project', $this->record))
                ->openUrlInNewTab(),
            DeleteAction::make()
                ->visible(fn (): bool => ProjectResource::canDelete($this->getRecord())),
        ];
    }
}
