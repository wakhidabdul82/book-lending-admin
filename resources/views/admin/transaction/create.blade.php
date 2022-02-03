@extends('layouts.master')
@section('header')
<a href="{{url('transactions')}}" class="text-white">Transactions</a>
@endsection
@section('subheader','Create')

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap.css')}}">
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-multiple').select2({
                placeholder: "Add Book",
                allowClear: true,
                theme: "classic"
            });
        });
    </script>
@endpush


@section('content')        
      <div class="row">
        <div class="col-md-6">
            <h3 class="card-title text-muted">Create Transaction</h3>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Add Transaction</h4>
              <form class="forms-sample" action="/transactions" method="POST">
                @csrf
                <div class="form-group">
                    <label>Member</label>
                    <select name="member_id" class="form-control">
                        @foreach($members as $key => $member)
                        <option value="{{$member->id}}">{{$member->name}}</option> 
                        @endforeach
                    </select>
                </div>
                @error('member_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label>Date Start</label>
                    <input type="text" class="form-control" onfocus="(this.type='date')" name="date_start" placeholder="Input Date">
                </div>
                @error('date_start')
                      <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label>Date End</label>
                    <input type="text" class="form-control" onfocus="(this.type='date')" name="date_end" placeholder="Input Date">
                </div>
                @error('date_end')
                      <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label>Book</label>
                    <select name="book_id[]" class="form-control border-warning add-multiple" multiple="multiple">
                        @foreach($books as $key => $book)
                        <option value="{{$book->id}}">{{$book->title}}</option> 
                        @endforeach
                    </select>
                </div>
                @error('book_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="/transactions" class="btn btn-light">Cancel</a>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection