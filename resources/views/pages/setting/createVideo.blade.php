@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Video</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Video</a></li>
                            <li class="breadcrumb-item active">Tambah Video</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('admin.video.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Formulir Tambah Video</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Judul</label>
                                            <input name="judul" type="text"
                                                class="form-control @error('judul')is-invalid @enderror" id="judul"
                                                value="" placeholder="Teaser terbaru">
                                            @error('judul')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectRounded0">Tipe</label>
                                            <select name="tipe" required class="custom-select rounded-2"
                                                id="exampleSelectRounded0">
                                                <option value="youtube" @selected(old('tipe') === 'youtube')>Youtube</option>
                                                <option value="local" @selected(old('tipe') === 'local')>Local</option>
                                            </select>
                                        </div>
                                        <div class="form-group" id="youtube-form">
                                            <label for="exampleInputEmail1">Link Youtube</label>
                                            <input name="link" type="text"
                                                class="form-control @error('link')is-invalid @enderror" id="link"
                                                placeholder="https://youtube.com">
                                            @error('link')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group" id="local-form">
                                            <label for="exampleInputEmail1">Local File</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile">
                                                <label class="custom-file-label" for="customFile">Upload File</label>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const selectElement = $('#exampleSelectRounded0');
            const youtubeForm = $('#youtube-form');
            const localForm = $('#local-form');

            // Sembunyikan localForm pada awalnya
            localForm.hide();

            selectElement.change(function(event) {
                const selectedValue = event.target.value;
                if (selectedValue === 'youtube') {
                    youtubeForm.show();
                    localForm.hide();
                } else if (selectedValue === 'local') {
                    youtubeForm.hide();
                    localForm.show();
                }
            });
        });
    </script>
@endsection
