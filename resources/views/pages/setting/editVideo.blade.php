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
                            <li class="breadcrumb-item active">Edit Viode</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('admin.video.update', ['id' => $video->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Edit Video</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Judul</label>
                                        <input name="judul" type="text" value="{{ $video->judul }}"
                                            class="form-control @error('judul')is-invalid @enderror" id="judul">
                                        @error('judul')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleSelectRounded0">Tipe</label>
                                        <select name="tipe" required class="custom-select rounded-2"
                                            id="exampleSelectRounded0" >
                                            <option value="{{ $video->tipe }}" selected>{{ $video->tipe }}</option>
                                            {{-- <option value="youtube" {{ $video->tipe === 'youtube' ? 'selected' : '' }}>
                                                Youtube</option>
                                            <option value="local" {{ $video->tipe === 'local' ? 'selected' : '' }}>Local
                                            </option> --}}
                                        </select>
                                    </div>
                                    @if ($video->tipe === 'youtube')
                                        <div class="form-group">
                                            <label for="inputLink">Link Youtube</label>
                                            <input name="link" type="text"
                                                value="{{ old('link', $video->link_sumber) }}"
                                                class="form-control @error('link')is-invalid @enderror" id="link"
                                                placeholder="https://youtube.com">
                                            @error('link')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <label for="inputFile">Local File (existing video:
                                                {{ $video->link_sumber }})</label>
                                            <div class="custom-file">
                                                <input type="file" name="customFile"
                                                    class="custom-file-input @error('customFile')is-invalid @enderror"
                                                    id="customFile">
                                                <label class="custom-file-label" for="customFile">Upload File</label>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- 
                                    <div class="form-group" id="local-form">
                                        <label for="inputFile">Local File</label>
                                        <div class="custom-file">
                                            <input type="file" name="customFile"
                                                class="custom-file-input @error('customFile')is-invalid @enderror"
                                                id="customFile">
                                            <label class="custom-file-label" for="customFile">Upload File</label>
                                        </div>
                                    </div> --}}

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
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
    <!-- Get Name File -->
    <script type="application/javascript">
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>
    <script>
        $(document).ready(function() {
            const selectElement = $('#exampleSelectRounded0');
            const youtubeForm = $('#youtube-form');
            const localForm = $('#local-form');

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
            $('form').submit(function(event) {
                const selectedValue = selectElement.val();

                if (selectedValue === 'youtube' && $('#link').val() === '') {
                    alert('Link Youtube tidak boleh kosong!');
                    event.preventDefault(); // Mencegah form submit
                    return false;
                }
                // else if (selectedValue === 'local' && $('#customFile').val() === '') {
                //     alert('File video tidak boleh kosong!');
                //     event.preventDefault(); // Mencegah form submit
                //     return false;
                // }

                return true; // Form submit diizinkan
            });
        });
    </script>
@endsection
