@extends('adminlte::page')

@section('content')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">DataTable with default features</h3>
    </div>
    <!-- /.card-header -->
    
    <div class="card-body">
        <table class="table table-bordered table-striped data-table">
          <thead>
              <tr id="">
                  <th>Id</th>
                  <th>Empresa</th>
                  <th>Unidade</th>
                  <th>Cargo</th>
                  <th>Previsto</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
    </div>
    <!-- /.card-body -->
  </div>
</div>
@endsection
@section('plugins.Datatables', true)

@section('js')

<script>
  $(document).ready(function() {

    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('profiles.index') }}",
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'empresa',
                name: 'empresa'
            },
            {
                data: 'unidade',
                name: 'unidade'
            },
            {
                data: 'cargo',
                name: 'cargo'
            },
            {
                data: 'previsto',
                name: 'previsto'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
      });
  });
</script>
<script>
  // $(function () {
  //   $("#example1").DataTable({
  //     "responsive": true,
  //     "autoWidth": false,
  //   });
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   "responsive": true,
    // });
  });
</script>
@endsection