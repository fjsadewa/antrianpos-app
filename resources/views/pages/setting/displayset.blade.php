@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Setting Tampilan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.displaysetting') }}">Setting</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Video -->
                <div class="row-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header" style="display: flex; justify-content: space-between">
                            <label class="card-title" style="flex-grow: 1;">Video</label>
                            <a href="{{ route('admin.video.create') }}" style="display: inline-block;">
                                <button class="btn bg-gradient-primary">Tambah Video</button>
                            </a>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- Banner-->
                <div class="row-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header" style="display: flex; justify-content: space-between">
                            <label class="card-title" style="flex-grow: 1;">Banner</label>
                            <a href="{{ route('admin.banner.create') }}" style="display: inline-block;">
                                <button class="btn bg-gradient-primary">Tambah Banner</button>
                            </a>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- Footer -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <label class="card-title">Footer</label>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a href="">
                                        <button class="btn bg-gradient-primary">Edit Footer</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
@endsection
