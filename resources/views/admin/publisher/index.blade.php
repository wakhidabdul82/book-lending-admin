@extends('layouts.master')
@section('header','Publisher')
@section('subheader','Index')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
@endpush

@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable();
    } );
</script>
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
      <h3 class="card-title text-muted">Data Publisher</h3>
      <div class="card">
        <!-- /.card-header -->
          <div class="card-body">
              <a href="{{url('publishers/create')}}" class="btn btn-outline-info btn-icon-text mb-3">
                <i class="typcn typcn-document-add btn-icon-append"></i>
                Add Publisher
              </a> 
            <table id="example1" class="table table-striped table-bordered table-responsive">
              <thead>
                <tr>
                  <th style="width: 10px">ID</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Phone Number</th>
                  <th class="text-center">Address</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($publishers as $key => $items)
                <tr>
                  <td class="text-center">{{$key + 1}}</td>
                  <td>{{$items->name}}</td>
                  <td>{{$items->email}}</td>
                  <td class="text-center">{{$items->phone_number}}</td>
                  <td>{{$items->address}}</td>
                  <td>
                    <form action="/publishers/{{$items->id}}" method="POST">
                    <a href="/publishers/{{$items->id}}/edit" class="btn btn-sm btn-outline-secondary btn-icon-text">
                      Edit
                      <i class="typcn typcn-document btn-icon-append"></i>                          
                    </a>
                    @method('DELETE')
                    @csrf
                    <input type="submit" class="btn btn-sm btn-outline-danger btn-icon-text" value="Delete">
                    </form>
                  </td>
                </tr> 
                @empty
                <tr>
                  <td>Data Kosong</td>
                </tr> 
                @endforelse 
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
      </div>
    </div>
  </div> 
@endsection