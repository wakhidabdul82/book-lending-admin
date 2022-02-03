@extends('layouts.master')
@section('header','Catalogs')
@section('subheader','Index')

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
@endpush

@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
@endpush

@section('content')
    <div class="row">
      <div class="col-md-8">
        <h3 class="card-title text-muted">Data Catalog</h3>
        <div class="card">
          <!-- /.card-header -->
            <div class="card-body">
                <a href="{{url('catalogs/create')}}" class="btn btn-outline-info btn-icon-text mb-3">
                  <i class="typcn typcn-document-add btn-icon-append"></i>
                  Tambah Catalog
                </a> 
              <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th style="width: 10px">ID</th>
                    <th>Name</th>
                    <th class="text-center">Total Book</th>
                    <th class="text-center">Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($catalogs as $key => $items)
                  <tr>
                    <td class="text-center">{{$key + 1}}</td>
                    <td>{{$items->name}}</td>
                    <td class="text-right">{{count($items->books)}}</td>
                    <td class="text-center">{{convert_date($items->created_at)}}</td>
                    <td>
                      <form action="/catalogs/{{$items->id}}" method="POST">
                      <a href="/catalogs/{{$items->id}}/edit" class="btn btn-sm btn-outline-secondary btn-icon-text">
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