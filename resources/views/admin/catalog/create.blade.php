@extends('layouts.master')
@section('header')
<a href="{{url('catalogs')}}" class="text-white">Catalogs</a>
@endsection
@section('subheader','Create')


@section('content')        
      <div class="row">
        <div class="col-md-6">
            <h3 class="card-title text-muted">Create Catalog</h3>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Add Catalog</h4>
              <form class="forms-sample" action="{{url('catalogs')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" class="form-control" name="name" placeholder="Catalog's name">
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="/catalogs" class="btn btn-light">Cancel</a>
              </form>
            </div>
          </div>
        </div>
      </div>

@endsection