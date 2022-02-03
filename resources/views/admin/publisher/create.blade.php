@extends('layouts.master')
@section('header')
<a href="{{url('publishers')}}" class="text-white">Publishers</a>
@endsection
@section('subheader','Create')


@section('content')        
      <div class="row">
        <div class="col-md-6">
            <h3 class="card-title text-muted">Create Publisher</h3>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Add Publisher</h4>
              <form class="forms-sample" action="{{url('publishers')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Name">
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email">
                  </div>
                  @error('email')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="phone_number" placeholder="Phone Number">
                  </div>
                  @error('phone_number')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                  <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" class="form-control" cols="30" rows="10" placeholder="Address"></textarea>
                  </div>
                  @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="/publishers" class="btn btn-light">Cancel</a>
              </form>
            </div>
          </div>
        </div>
      </div>

@endsection