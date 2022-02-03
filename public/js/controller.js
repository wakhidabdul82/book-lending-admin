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
        addData() {
            this.data = {};
            this.editStatus=false;
            $('#createModal').modal();
        },
        editData(event, row) {
            this.data = this.datas[row];
            this.editStatus=true;
            $('#createModal').modal(); 
        },
        deleteData(event, id) {
            $(event.target).parents('tr').remove();
            if (confirm("are you sure?")) {
              axios.post(this.actionUrl+'/'+id, {_method: 'DELETE'}).then(response => {
                alert('Data has been removed!');
              });
            }
        },
        submitForm(event, id) {
            event.preventDefault()
            const _this = this;
            var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
            axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                $('#createModal').modal('hide')
                _this.table.ajax.reload();
          });
        },
    }
});