@extends('layout.app')
@section('body')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @if (session('success'))
        <div class="alert alert-success">
            <strong>{{ session('success') }}</strong>
        </div>
        @endif
    </section>

     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="card-header">
                    <h3 class="card-title">Trash all stock taken data</h3>
                    <a id="destroy" href="{{route('trash.stock')}}" class="btn btn-danger btn-sm float-sm-right" role="button">Trash all</a>
                </div>

                <section class="content-header">
                </section>

                <div class="card-header">
                    <h3 class="card-title">Trash all imported data</h3>
                    <a id="destroy" href="{{route('trash.upload')}}" class="btn btn-danger btn-sm float-sm-right" role="button">Trash all</a>
                </div>
            </div>
          </div>
        </div>
     </section>
</div>
@endsection
