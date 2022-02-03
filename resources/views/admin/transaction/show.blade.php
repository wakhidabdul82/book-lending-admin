@extends('layouts.master')
@section('header')
<a href="{{url('transactions')}}" class="text-white">Transactions</a>
@endsection
@section('subheader','Detail')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="card-title text-muted">Detail Transaction</h3>
      <div class="card">
        <div class="card-body">
            <table class="table">
                <tr>
                    <th class="col-md-3">Member</th>
                    <td class="bg-light">{{$transaction->member->name}}</td>
                </tr>
                <tr>
                    <th class="col-md-3">Date Start</th>
                    <td>{{$transaction->date_start}}</td>
                </tr>
                <tr>
                    <th class="col-md-3">Date End</th>
                    <td>{{$transaction->date_end}}</td>
                </tr>
                <tr>
                    <th class="col-md-3">Book</th>
                    <td>
                        @foreach ($transaction->detail_transaction as $item)
                        <p>{{$item->book->title}}</p>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th class="col-md-3">Status</th>
                    <td class="text-warning">{{$transaction->status == 1 ? 'Returned' : 'On going'}}</td>
                </tr>
            </table>  
        </div>
      </div>
    </div>
  </div>
@endsection