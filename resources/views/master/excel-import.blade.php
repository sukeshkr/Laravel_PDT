@extends('layout.app')
@section('body')
  <!-- Content Wrapper. Contains page content -->
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
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Excel File Import<small> (Note: The Excel file order must be ITEM CODE|DESCRIPTION|Stock|UNIT|RATE)</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($msg = Session::get('success'))
                <div class="alert alert-success btn-sm">
                    <strong>{{ $msg }}</strong>
                </div>
              @endif
                @if (count($errors) > 0)
                <div class="alert alert-danger btn-xs">
                    <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
                <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="exampleInputFile">File input</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="exampleInputFile">
                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                          </div>
                        </div>
                    </div>

                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Import</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  @endsection
