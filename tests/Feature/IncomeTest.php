<?php

namespace Tests\Feature;

use App\Filament\Resources\IncomeResource\Pages\CreateIncome;
use App\Models\Account;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class IncomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_income(): void
    {
        $user = User::factory()->create();

        $account = Account::factory()->create([
            'account_owner_id' => $user->id,
            'created_user_id' => $user->id,
        ]);

        $incomeCategory = IncomeCategory::factory()->create([
            'created_user_id' => $user->id,
        ]);

        $user->update([
            'default_account_id' => $account->id,
        ]);

        $newIncome = Income::factory()->make([
            'created_user_id' => $user->id,
            'account_id' => $account->id,
            'income_category_id' => $incomeCategory->id,
        ]);

    // $this->actingAs(User::find(1))->get('/finance')->assertSuccessful(); //ar šo darbojas
    $this->actingAs($user)->get('/finance')->assertSuccessful();


        Livewire::test(CreateIncome::class)
            ->set('data.created_user_id', $newIncome->created_user_id)
            ->set('data.account_id', $newIncome->account_id)
            ->set('data.income_category_id', $newIncome->income_category_id)
            ->set('data.income_date', $newIncome->income_date)
            ->set('data.amount', $newIncome->amount)
            ->set('data.description', $newIncome->description)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('incomes', [
            'account_id' => $newIncome->account_id,
            'income_category_id'=> $newIncome->income_category_id,
            'income_date'=> $newIncome->income_date,
            'amount'=> $newIncome->amount,
            'description'=> $newIncome->description,
        ]);
    }
}
