@extends('layouts.master')
@section('header','Publishers')
@section('subheader','Index')

<!--data table here-->
@push('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
@endpush

@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>

<script type="text/javascript">
  var actionUrl = '{{url('publishers')}}';
  var apiUrl = '{{url('api/publishers')}}';

  var colums = [
    {data : 'DT_RowIndex', class : 'text-center', orderable: true},
    {data : 'name',orderable: true},
    {data : 'email', orderable: true},
    {data : 'phone_number', class : 'text-right', orderable: true},
    {data : 'address', orderable: true},
    {data : 'date', orderable: true},
    {render: function (index, row, data, meta) {
      return `
      <a href="#" class="btn btn-sm btn-outline-secondary btn-icon-text" onclick="controller.editData(event, ${meta.row})">Edit</a>
      <a href="#" class="btn btn-sm btn-outline-danger btn-icon-text" onclick="controller.deleteData(event, ${data.id})">Delete</a>
      `;
    }, orderable:false, class: 'text-center'},
  ];
</script>

<script type="text/javascript" src="{{asset('js/controller.js')}}"></script>

{{--<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
<!--end data table-->

<script type="text/javascript">
  var controller = new Vue({
  el: '#controller',
  data: {
    data: {},
    actionUrl: '{{url('publishers')}}',
    editStatus: false
  },
  methods: {
      addData() {
          this.data = {};
          this.actionUrl='{{url('publishers')}}';
          this.editStatus=false;
          $('#createModal').modal();
      },
      editData(data) {
          this.data = data;
          this.actionUrl='{{url('publishers')}}'+'/'+data.id;
          this.editStatus=true;
          $('#createModal').modal(); 
      },
      deleteData(id) {
          this.actionUrl = '{{url('publishers')}}'+'/'+id;
          if (confirm("are you sure?")) {
            axios.post(this.actionUrl, {_method: 'DELETE'}).then(response => {
              location.reload();
            });
          }
      } 
  }
  });
</script>--}}
@endpush

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-sm-12">
          <h3 class="card-title text-muted">Data Publisher</h3>
          <div class="card">
            <!-- /.card-header -->
              <div class="card-body">
                  <a href="#" class="btn btn-outline-info btn-icon-text mb-3" @click="addData()">
                    <i class="typcn typcn-document-add btn-icon-append"></i>
                    Add Publisher
                  </a> 
                <table id="example" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Email</th>
                      <th class="text-center">Phone Number</th>
                      <th class="text-center">Address</th>
                      <th>Created at</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
              <!-- /.card-body -->
          </div>
        </div>
      </div>
      <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="forms-sample" :action="actionUrl" method="POST" @submit="submitForm($event, data.id)">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Publisher</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <!--bag isi modal-->
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">

                            <div class="form-group">
                              <label>Name</label>
                              <input type="text" class="form-control" name="name" :value="data.name" placeholder="Name">
                            </div>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" :value="data.email" placeholder="Email">
                              </div>
                              @error('email')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" class="form-control" name="phone_number" :value="data.phone_number" placeholder="Phone Number">
                              </div>
                              @error('phone_number')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>Address</label>
                                <textarea name="address" class="form-control" cols="30" rows="10" :value="data.address" placeholder="Address"></textarea>
                              </div>
                              @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                        <!--sampai sini-->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
