<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncome extends CreateRecord
{
    protected static string $resource = IncomeResource::class;

    // nodrošin, ka pēc jauna ieraksta saglabāšanas tiktu atvērta lapa ar visiem izdevumu ierakstiem
    protected function getRedirectUrl(): string
    {
        // Return the URL you want to redirect to after the record is created
        return $this->getResource()::getUrl('index'); // Redirects to the index page of the resource
    }
}
