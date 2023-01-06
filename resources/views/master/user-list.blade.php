@extends('layout.app')
@section('body')

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
                    <h3 class="card-title">User List</h3>
                  </div>

        <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Slno</th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Admin/User</th>
                    <th>Last Login Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$users->firstItem() + $loop->index}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->is_admin ===1 ? 'Admin':'User'}}</td>
                    <td>{{$user->updated_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$users->links()}}
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
