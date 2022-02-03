@extends('layouts.master')
@section('header','Transactions')
@section('subheader','Index')

<!--data table here-->
@push('style')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css"/>
@endpush

@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>

<script type="text/javascript">
  var actionUrl = '{{url('transactions')}}';
  var apiUrl = '{{url('api/transactions')}}';

  var colums = [
    {data : 'DT_RowIndex', orderable: true},
    {data : 'name',orderable: true},
    {data : 'date_start',class : 'text-right', orderable: true},
    {data : 'date_end', class : 'text-right', orderable: true},
    {data : 'long_borrow',orderable: true},
    {data : 'total_book',orderable: true},
    {data : 'total_paid',orderable: true},
    {data : 'status', orderable: true},
    {render: function (index, row, data, meta) {
      return `
      <form action="/transactions/${data.id}" method="POST">
      <a href="/transactions/${data.id}" class="btn btn-sm btn-outline-info btn-icon-text">Detail</a>
      @can('manage transactions')
      <a href="/transactions/${data.id}/edit" class="btn btn-sm btn-outline-secondary btn-icon-text">Edit</a>
      @method('DELETE')
      @csrf
      <input type="submit" class="btn btn-sm btn-outline-danger btn-icon-text" value="Delete">
      @endcan
      </form>
      `;
    }, orderable:false, class: 'text-center'},
  ];
</script>

<script>
var controller = new Vue({
  el: '#controller',
  data: {
    datas: [],
    data: {},
    actionUrl,
    apiUrl,
    editStatus: false,
  },
  mounted: function () {
    this.datatable();
  },
  methods: {
      datatable() {
          const _this = this
          _this.table = $('#example').DataTable({
            "scrollX": true,
              ajax: {
              url: _this.apiUrl,
              type: 'GET',
            },
            columns: colums
          }).on('xhr', function () {
            _this.datas = _this.table.ajax.json().data
          });  
      },
      deleteData(event, id) {
          $(event.target).parents('tr').remove();
          if (confirm("are you sure?")) {
            axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response => {
              alert('Data has been removed!');
            });
          }
      },
  }
});
</script>
<script type="text/javascript">
  $('select[name=status]').on('change', function() {
    status = $('select[name=status]').val();
    if (status == 2) {
        controller.table.ajax.url(apiUrl).load();
    } else {
        controller.table.ajax.url(apiUrl + '?status=' + status).load();
    }
  });

  $('input[name=date_start]').on('change', function() {
    date_start = $('input[name=date_start]').val()
    controller.table.ajax.url(apiUrl + '?date_start=' + date_start).load()
});
</script>

@endpush

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-sm-12">
          <h3 class="card-title text-muted">Data Transaction</h3>
          <div class="card">
            <!-- /.card-header -->
              <div class="card-body">
                <div class="row justify-content-between">
                  <div class="col-sm-6">  
                  <a href="{{url('transactions/create')}}" class="btn btn-outline-info btn-icon-text mb-3">
                    <i class="typcn typcn-document-add btn-icon-append"></i>
                    Add Transaction
                  </a>
                  </div>
                  <div class="col-sm-3">
                    <select name="status" class="form-control border-warning">
                        <option value="2">All Status</option>
                        <option value="0">On going</option>
                        <option value="1">Returned</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <div class='input-group'>
                        <input type='text' class="form-control border-info" placeholder="Input Date" onfocus="(this.type='date')" name="date_start">
                    </div>
                </div>
                </div> 
                <table id="example" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">ID</th>
                      <th class="text-center">Member</th>
                      <th class="text-center">Start Borrow</th>
                      <th class="text-center">End Borrow</th>
                      <th class="text-center">Borrowed (day)</th>
                      <th class="text-center">Total Book</th>
                      <th class="text-center">Total Paid</th>
                      <th class="text-center">Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
              <!-- /.card-body -->
          </div>
        </div>
      </div>
</div>
@endsection