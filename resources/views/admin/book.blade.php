@extends('layouts.master')
@section('header','Books')
@section('subheader','Index')

<!--data table here-->
@push('style')

@endpush

@push('script')


<script type="text/javascript">
    var actionUrl = '{{url('books')}}';
    var apiUrl = '{{url('api/books')}}';

    var controller = new Vue({
        el: '#controller',
        data: {
          books: [],
          book: {},
          search: '',
          actionUrl,
          apiUrl,
          editStatus: false,
          
        },
        mounted: function () {
            this.get_books();
        },
        methods: {
            get_books() {
                const _this = this;
                $.ajax({
                    url: apiUrl,
                    method: 'GET',
                    success: function (data) {
                        _this.books = JSON.parse(data);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            },
            addData() {
                this.book = {};
                $('#createModal').modal();
            },
            editData(book) {
                this.book = book;
                this.actionUrl = '{{ url('books') }}' + '/' + book.id;
                this.editStatus= true;
                $('#createModal').modal();
            },
            deleteData(id) {
                this.actionUrl = '{{url('books')}}'+'/'+id;
                if (confirm("are you sure?")) {
                axios.post(this.actionUrl, {_method: 'DELETE'}).then(response => {
                location.reload();
                    });
                }
            },
            numberWithDot(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
        },
        computed: {
            filteredList() {
                return this.books.filter(book => {
                    return book.title.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        }
    });
</script>

@endpush

@section('content')
<div id="controller">
    <div class="row">
        <div class="col-sm-12">
          <h3 class="card-title text-muted">Data Book</h3>
          <div class="card">
                <div class="card-body">
                    <div class="container-fluid d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-info btn-icon-text mb-4" @click="addData()">
                            <i class="typcn typcn-document-add btn-icon-append"></i>
                            Add Book
                        </a> 
                        <div class="form-group">
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Find book here!" aria-label="Book Search" v-model="search">
                              <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="button">Search</button>
                              </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4 my-2" v-for="book in filteredList">
                            <div class="card" style="width: 18rem;">
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="#" class="text-secondary text-decoration-none" v-on:click="editData(book)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>                                          
                                    </a>
                                    <a href="#" v-on:click="deleteData(book.id)" class="text-danger text-decoration-none ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>                                          
                                    </a>
                                </div>
                                <div class="card-body">
                                  <h5 class="card-subtitle">ISBN : @{{book.isbn}}</h5>
                                  <p class="card-text" style="color: indigo">Title : @{{book.title}}</p>
                                  <p class="card-text" style="color: tomato">Price : Rp. @{{numberWithDot(book.price)}} ,- | Qty : @{{book.qty}}</p>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="forms-sample" :action="actionUrl" method="POST">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Book</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <!--bag isi modal-->
                            @csrf
                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="form-group">
                              <label>ISBN</label>
                              <input type="number" class="form-control" name="isbn" :value="book.isbn" placeholder="ISBN">
                            </div>
                            @error('isbn')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title" :value="book.title" placeholder="Title">
                              </div>
                              @error('title')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>Year</label>
                                <input type="number" class="form-control" name="year" :value="book.year" placeholder="Year">
                              </div>
                              @error('year')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>Publisher</label>
                                <select name="publisher_id" class="form-control">
                                    @foreach($publishers as $key => $publisher)
                                    <option :selected="book.publisher_id == {{$publisher->id}}" value="{{$publisher->id}}">{{$publisher->name}}</option> 
                                    @endforeach
                                  </select>
                              </div>
                              @error('publisher_id')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>Author</label>
                                <select name="author_id" class="form-control">
                                    @foreach($authors as $key => $author)
                                    <option :selected="book.author_id == {{$author->id}}" value="{{$author->id}}">{{$author->name}}</option> 
                                    @endforeach
                                  </select>
                              </div>
                              @error('author_id')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>Catalog</label>
                                <select name="catalog_id" class="form-control">
                                    @foreach($catalogs as $key => $catalog)
                                    <option :selected="book.catalog_id == {{$catalog->id}}" value="{{$catalog->id}}">{{$catalog->name}}</option> 
                                    @endforeach
                                  </select>
                              </div>
                              @error('catalog_id')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>QTY</label>
                                <input type="number" class="form-control" name="qty" :value="book.qty" placeholder="Quantity">
                              </div>
                              @error('qty')
                                  <div class="alert alert-danger">{{ $message }}</div>
                              @enderror
                              <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="price" :value="book.price" placeholder="Price">
                              </div>
                              @error('price')
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