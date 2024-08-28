<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

        protected function mutateFormDataBeforeCreate(array $data): array
        {
            $data['created_user_id'] = auth()->id();

            return $data;
        }
    // nodrošin, ka pēc jauna ieraksta saglabāšanas tiktu atvērta lapa ar visiem izdevumu ierakstiem
    protected function getRedirectUrl(): string
        {
            // Return the URL you want to redirect to after the record is created
            return $this->getResource()::getUrl('index'); // Redirects to the index page of the resource
        }
}
