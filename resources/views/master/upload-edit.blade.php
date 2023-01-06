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
                <h3 class="card-title">Edit Uploaded File Here</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form_id" method="POST" action="{{ route('upload.update') }}">
                @csrf
                @method('POST')
                @error('item_code')
                <div class="btn btn-danger btn-sm">{{ $message }}</div>
                @enderror
                @error('stock')
                <div class="btn btn-danger btn-sm">{{ $message }}</div>
                @enderror

                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="card-body">
                <div class="row">

                <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Barcode</label>
                    <input type="text" name="item_code" value="{{old('item_code',isset($data->item_code) ? $data->item_code : '')}}" class="form-control block @error('itemname', 'stock_error') is-invalid @enderror" placeholder="Item Name">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputPassword1"> Stock</label>
                    <input type="text" name="stock" value="{{old('stock',isset($data->stock) ? $data->stock : '')}}" class="form-control block @error('system_stock', 'stock_error') is-invalid @enderror" placeholder="System Stock">
                </div>

                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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
