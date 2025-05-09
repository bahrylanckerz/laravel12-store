<?php

namespace App\Filament\Resources\SliderResource\Pages;

use Filament\Notifications\Notification;
use App\Filament\Resources\SliderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSlider extends CreateRecord
{
    protected static string $resource = SliderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title('Slider Created')
            ->body('The slider has been created successfully.')
            ->send();
    }
}
