<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpenseTest extends TestCase
{

    // use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_an_expense() : void
    {
        $user = User::create([
            'name' => 'Test',
            'surname' => 'test_surname',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
        ]);

        $account = Account::create([
            'name' => 'Personal Account',
            'account_number' => '123456789',
            'account_owner_id' => $user->id,
            'created_user_id' => $user->id,
        ]);

        $expenseCategory = ExpenseCategory::create([
            'created_user_id' => $user->id,
            'expense_category_name' => 'Office Supplies',
            'is_visible' => true,
        ]);

        $this->actingAs($user);

        $response = $this->post('finanse/expenses/create', [
            'created_user_id' => $user->id,
            'account_id' => $account->id,
            'expense_category_id' => $expenseCategory->id,
            'expense_name' => 'Office Chair',
            'expense_date' => now()->format('Y-m-d'),
            'count' => 1,
            'unit_price' => 100.00,
            'total_price' => 100.00,
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('expenses', [
            'expense_name' => 'Office Chair',
            'total_price' => 100.00,
        ]);
    }
}
