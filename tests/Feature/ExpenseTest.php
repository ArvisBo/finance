<?php

namespace Tests\Feature;

use App\Filament\Resources\ExpenseResource\Pages\CreateExpense;
use App\Models\Account;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ExpenseTest extends TestCase
{
    use RefreshDatabase;

    public function test_expense(): void
    {
        $user = User::factory()->create();
        // $user = User::create([
        //     'name' => 'Test',
        //     'surname' => 'test_surname',
        //     'email' => 'john@example.com',
        //     'password' => bcrypt('password'),
        //     'is_admin' => true,
        // ]);

        $account = Account::factory()->create([
            'account_owner_id' => $user->id,
            'created_user_id' => $user->id,
        ]);

        // $account = Account::create([
        //     'name' => 'Personal Account',
        //     'account_number' => '123456789',
        //     'account_owner_id' => $user->id,
        //     'created_user_id' => $user->id,
        // ]);

        $expenseCategory = ExpenseCategory::factory()->create([
            'created_user_id' => $user->id,
        ]);
        // $expenseCategory = ExpenseCategory::create([
        //     'created_user_id' => $user->id,
        //     'expense_category_name' => 'Office Supplies',
        //     'is_visible' => true,
        // ]);

        $user->update([
            'default_account_id' => $account->id,
        ]);

        // $accountPermission = UserAccountPermission::create([
        //     'user_id' => $user->id,
        //     'account_id' => $account->id,
        //     'permission_id' => '1',
        // ]);

        $newExpense = Expense::factory()->make([
            'created_user_id' => $user->id,
            'account_id' => $account->id,
            'expense_category_id' => $expenseCategory->id,
        ]);
        // $newExpense = Expense::make([
        //     'created_user_id' => $user->id,
        //     'account_id' => $account->id,
        //     'expense_category_id' => $expenseCategory->id,
        //     'expense_name' => 'Office Chair',
        //     'expense_date' => now()->format('Y-m-d'),
        //     'count' => 1,
        //     'unit_price' => 100.00,
        //     'total_price' => 100.00,
        // ]);



    // $this->actingAs(User::find(1))->get('/finance')->assertSuccessful(); //ar šo darbojas
    $this->actingAs($user)->get('/finance')->assertSuccessful();


        Livewire::test(CreateExpense::class)
            ->set('data.created_user_id', $newExpense->created_user_id)
            ->set('data.account_id', $newExpense->account_id)
            ->set('data.expense_category_id', $newExpense->expense_category_id)
            ->set('data.expense_name', $newExpense->expense_name)
            ->set('data.expense_date', $newExpense->expense_date)
            ->set('data.count', $newExpense->count)
            ->set('data.unit_price', $newExpense->unit_price)
            ->set('data.total_price', $newExpense->total_price)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('expenses', [
            'created_user_id' => $user->id,
            'account_id' => $newExpense->account_id,
            'expense_category_id' => $newExpense->expense_category_id,
            'expense_name' => $newExpense->expense_name,
            'expense_date' => $newExpense->expense_date,
            'count' => $newExpense->count,
            'unit_price' => $newExpense->unit_price,
            'total_price' => $newExpense->total_price,
        ]);
    }
}
