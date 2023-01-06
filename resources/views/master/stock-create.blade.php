@extends('layout.app')
@section('body')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Scan Your Barcode Here</h3>
              </div>
              <div id="subject"></div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="form_id" method="POST" action="{{ route('stock.create') }}">
                @csrf
                @if (session('success'))
                <div class="alert alert-success btn-xs">
                    <strong>{{ session('success') }}</strong>
                </div>
                @endif
                <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-10">
                    <label for="exampleInputEmail1" id="quickForm" class="{{ route('stock.select') }}">--Scan Your Barcode Here--</label>
                    <input type="text" name="itemcode" class="form-control @error('itemcode', 'stock_error') is-invalid @enderror" autocomplete="off" id="iBarcode" placeholder="Enter Barcode">
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                        <label>  Manual Search  </label>
                        <button type="button" id="target" name="{{ route('manual.search') }}" class="btn btn-primary">-- Search --</button>
                    </div>
                </div>
                <div class="form-group col-md-12" id="key_display"></div>
                  <div class="form-group col-md-12">
                    <label for="exampleInputPassword1">Item Name</label>
                    <input type="text" name="itemname" value="{{old('itemname')}}" class="form-control block @error('itemname', 'stock_error') is-invalid @enderror" id="itemname" placeholder="Item Name">
                </div>
                  <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Unit</label>
                    <input type="text" name="unit" value="{{old('unit')}}" class="form-control block @error('unit', 'stock_error') is-invalid @enderror" id="unit" placeholder="Unit">
                </div>
                  <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="text" name="price" value="{{old('price')}}" class="form-control block @error('price', 'stock_error') is-invalid @enderror" id="price" placeholder="Price">
                </div>
                  <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">System Stock</label>
                    <input type="text" name="system_stock" value="{{old('system_stock')}}" class="form-control block @error('system_stock', 'stock_error') is-invalid @enderror" id="system_stock" placeholder="System Stock">
                </div>
                  <div class="form-group col-md-4">
                    <label for="exampleInputPassword1">Physical Stock</label>
                    <input type="number" autocomplete="off" name="phy_stock" value="{{old('phy_stock')}}" class="form-control @error('phy_stock', 'stock_error') is-invalid @enderror" id="phy_stock" placeholder="Physical Stock">
                </div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button id="submit" type="submit" class="btn btn-primary" name="{{ route('manual.exist') }}">Submit</button>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/scannerdetection/1.2.0/jquery.scannerdetection.min.js"></script>
  <script src="{{ asset('assets/myjs/ajax-post.js') }}"></script>
  <style>
    .block {
      pointer-events: none;
    }
  </style>
  @endsection
