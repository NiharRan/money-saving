<?php

namespace App\Observers;

use App\Account;
use App\Settings\TransactionType;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\Auth;
use Nexmo\Laravel\Facade\Nexmo;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
      // First check is this transaction created by a join account member
      $account = Account::with([
        'users',
        'money_format'
      ])->joinAccount()->find($transaction->account_id);
      if ($account) {
        // get transaction creator
        $transactionCreator = User::find($transaction->user_id);
        // get transaction type
        $transactionType = TransactionType::find($transaction->transaction_type_id)->name;
        // get account money calculation format
        $moneyFormat = $account->money_format->name;
        // get transaction created date
        $transactionDate = date('d-m-Y h:i A', strtotime($transaction->created_at));
        // get all members of join account except who created
        $users = $account->users->where('id', '!=', $transaction->user_id);
        // get members emails and phones
        $emails = $users->pluck('email');
        $phones = $users->pluck('phone');

        // send message to all selected members
        $message = "$transactionCreator->name is $transactionType $transaction->amount $moneyFormat only at $transactionDate";
      }
      // If so, send mail and sms to other member of this account
    }

    /**
     * Handle the transaction "updated" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "deleted" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "restored" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "force deleted" event.
     *
     * @param  \App\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
