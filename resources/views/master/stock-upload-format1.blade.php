@extends('layout.app-list')
@section('body')
{{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">

                <div class="card-header">
                    <a href="{{route('excel.form1')}}" class="btn btn-primary float-sm-right" role="button">Export to Excel</a>
                    <h3 class="card-title">Stock Upload Format 1</h3>
                  </div>


            <table class="table table-bordered user_datatable">
                <thead>
                    <tr>
                        <th>Slno</th>
                        <th>Code</th>
                        <th>Unit</th>
                        <th>Batch</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(function () {
    var i = 1;
    var table = $('.user_datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('format.one') }}",
        columns: [
            {
                "render":function() {
                    return i++;
                }
            },
            {data: 'item_code', name: 'item_code'},
            {data: 'unit', name: 'unit'},
            {data: 'batch', name: 'batch'},
            {data: 'phy_stock', name: 'phy_stock'},
        ]
    });
  });
</script>
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection

