<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Book;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //if (auth()->user()->can('manage transactions')) {
            return view('admin.transaction.index');
        //} else {
        //return abort('403');
        //}
    }

    public function addspatie()
    {
        //$role = Role::create(['name' => 'librarian']);
        //$permission = Permission::create(['name' => 'manage transactions']);

        //$role->givePermissionTo($permission);
        //$permission->assignRole($role);

        $user = auth()->user();
        //$user->assignRole('librarian');
        //return $user;
        
        // $user = User::where('id', 1)->first();
        // $user->assignRole('librarian');
        // return $user;

        $user = User::with('roles')->get();
        return $user;

        // $user = User::where('id', 1)->first();
        // $user->removeRole('librarian');
    }

    public function api(Request $request)
    {
        $transactions = Transaction::select('transactions.*','members.name', DB::raw('DATEDIFF(date_end, date_start) as long_borrow'))
            ->join('members','members.id', '=' , 'transactions.member_id');

        if ($request->status == '1' || $request->status == '0'){
            $transactions = $transactions->where('status', $request->status);
        }

        if ($request->date_start){
            $transactions = $transactions->where('date_start', $request->date_start);
        }
        
        $transactions = $transactions->get();
        foreach ($transactions as $key => $items) {
            $items->total_book = DetailTransaction::where('transaction_id', $items->id)->count();   
            $items->total_paid = DetailTransaction::select(DB::raw('SUM(detail_transactions.qty*books.price) as total_paid'))
                                        ->join('books','books.id','=','detail_transactions.book_id')
                                        ->where('transaction_id', $items->id)
                                        ->first()
                                        ->total_paid;
        }

        $datatables = datatables()->of($transactions)
                    ->addColumn('status', function($transactions){
                        if($transactions->status == 1){
                            return 'Returned';
                        } else {
                            return 'On going';
                        }
                    })
                    ->addColumn('total_paid', function($items){
                        return convert_currency($items->total_paid);
                    })
                    ->addColumn('date_start', function($transactions){
                        return convert_date($transactions->date_start);
                    })
                    ->addColumn('date_end', function($transactions){
                        return convert_date($transactions->date_end);
                    })
                    ->addIndexColumn();
        
        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::select('id', 'title')->where('qty', '>', '0')->get();
        $members = Member::select('id', 'name')->get();

        return view('admin.transaction.create',compact('books','members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = request()->validate([
            'member_id' => 'required',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
            'book_id' => 'required',
        ], [
            'member_id.required' => 'Member must filled!',
            'book_id.required' => 'Fill any book!',
        ]);

        $transactions = Transaction::create([
            'member_id' => $request['member_id'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],
        ]);

        foreach ($request['book_id'] as $book_id) {
            DetailTransaction::create([
                'transaction_id' => $transactions->id,
                'book_id' => $book_id,
                'qty'  => 1
            ]);

            Book::where('id', $book_id)
                ->decrement('qty', 1);
        }
        return redirect('/transactions');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return view('admin.transaction.show', ['transaction' => $transaction]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $members = Member::select('id', 'name')->get();
        $books = Book::select('id', 'title')->where('qty', '>', '0')->get();
        $detail_transactions = DetailTransaction::select('id','book_id','transaction_id', 'qty')->get();
        return view('admin.transaction.edit', [
            'transaction' => $transaction], compact('members', 'books', 'detail_transactions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $old_detail_transaction = DetailTransaction::select('id', 'book_id')
                                ->where('transaction_id', $transaction->id)
                                ->get();

        $request = request()->validate([
        'member_id' => 'required',
        'date_start' => 'required|date',
        'date_end' => 'required|date|after:date_start',
        'book_id' => 'required',
        'status' => 'required']
        );

        $transaction->update([
        'member_id' => $request['member_id'],
        'date_start' => $request['date_start'],
        'date_end' => $request['date_end'],
        'status' => $request['status']
        ]);

        if ($request['status'] == 1) {
            foreach ($request['book_id'] as $book_id) {
                $detail_transaction = DetailTransaction::updateOrCreate([
                'book_id' => $book_id,
                'transaction_id' => $transaction->id,
                'qty' => 1
                ]);

                if (!$detail_transaction->wasRecentlyCreated) {
                Book::where('id', $detail_transaction->book_id)
                ->increment('qty', 1);
                }

                if (!$detail_transaction->wasRecentlyCreated && !$detail_transaction->wasChanged()) {
                foreach ($old_detail_transaction as $item) {
                if ($detail_transaction->id != $item->id) {
                DetailTransaction::where('id', $item->id)->delete();

                Book::where('id', $item->book_id)
                    ->decrement('qty', 1);
                        }
                    }
                }
            }
             
        } else {
            foreach ($request['book_id'] as $book_id) {
            $detail_transaction = DetailTransaction::updateOrCreate([
            'book_id' => $book_id,
            'transaction_id' => $transaction->id,
            'qty' => 1
            ]);

            if (!$detail_transaction->wasRecentlyCreated) {
            Book::where('id', $detail_transaction->book_id)
            ->decrement('qty', 1);
            }

                if (!$detail_transaction->wasRecentlyCreated && !$detail_transaction->wasChanged()) {
                foreach ($old_detail_transaction as $item) {
                if ($detail_transaction->id != $item->id) {
                DetailTransaction::where('id', $item->id)->delete();

                Book::where('id', $item->book_id)
                    ->increment('qty', 1);
                      }
                   }
                }
            }
        }
        return redirect('/transactions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $detail_transactions = DetailTransaction::where('transaction_id', $transaction->id)->get();

        if ($transaction->status == 1) {
            foreach ($detail_transactions as $item) {
                DetailTransaction::where('id', $item->id)->delete();
            }
            $transaction->delete();
        } else {
            
            foreach ($detail_transactions as $item) {
                DetailTransaction::where('id', $item->id)->delete();
                Book::where('id', $item->book_id)
                    ->increment('qty', 1);
            }
            $transaction->delete();
        }

        return redirect('/transactions');
    }
}
