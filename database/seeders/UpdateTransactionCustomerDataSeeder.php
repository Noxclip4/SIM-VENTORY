<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;

class UpdateTransactionCustomerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update transaksi yang customer_email sama dengan user email
        $transactions = Transaction::with('user')->get();
        
        foreach ($transactions as $transaction) {
            // Jika customer_email sama dengan user email, kosongkan customer_email
            if ($transaction->customer_email === $transaction->user->email) {
                $transaction->update([
                    'customer_email' => null
                ]);
            }
            
            // Jika customer_name sama dengan user name, kosongkan customer_name
            if ($transaction->customer_name === $transaction->user->name) {
                $transaction->update([
                    'customer_name' => null
                ]);
            }
        }
        
        echo "Updated " . $transactions->count() . " transactions\n";
    }
}
