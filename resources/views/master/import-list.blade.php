@extends('layout.app-list')
@section('body')
{{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
                    <h3 class="card-title">Imported List</h3>
                    <a id="destroy" href="{{route('destroy.upload')}}" class="btn btn-danger btn-sm float-sm-right" role="button">Trash all</a>

                </div>

                @if (session('success'))
                    <div class="alert alert-success btn-sm">
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif

        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Slno</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>

<div class="modal fade" id="del-modal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are You Want to delete?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <div>
                    <button type="button" id="button-mod" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{route('import.fetch')}}',
            dataType:'json',
            type:'GET',
        },
        columns:[
            {data:'slno'},
            {data:'item_code'},
            {data:'item_name'},
            {data:'unit'},
            {data:'price'},
            {data:'stock'},
            {data:'actions'},
        ]
    });
});
</script>

<script>
$(document).ready(function () {
    $('#del-modal').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        $( "#button-mod" ).click(function() {
            $.ajax({
                type: 'get',
                url: "{{route('upload.delete')}}",
                data: 'rowid=' + rowid, //Pass $id
                success: function (data) {
                    location.reload(true);
                }
            });
        });
    });
});
</script>
<script>
    $(document).ready(function(){
        $("#destroy").click(function(){
            if (!confirm("Do wanna delete ? .If you click ok it will trash all your data.")){
            return false;
            var url = "{{ route('destroy.stock') }}";
            location.href = url;
            }
        });
    });
</script>

@endsection


