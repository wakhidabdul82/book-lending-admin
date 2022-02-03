<?php
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

    function notification() {

        $notification = Transaction::with('member')->select('transactions.*', DB::raw('DATEDIFF(CURRENT_DATE, transactions.date_end) as late'))->where('status', 0)->get();
  
        return $notification;
        
    }

?>