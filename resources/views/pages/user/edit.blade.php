@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.user') }}">User</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action=" {{ route('admin.user.update', ['id' => $data->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah User</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama</label>
                                            <input name="nama" value="{{ $data->name }}" type="text"
                                                class="form-control @error('nama')is-invalid @enderror"
                                                id="exampleInputEmail1" placeholder="Enter name">
                                            @error('nama')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input name="email" value="{{ $data->email }}" type="email"
                                                class="form-control @error('email')is-invalid @enderror"
                                                id="exampleInputEmail1" placeholder="Enter email">
                                            @error('email')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input name="password" type="password"
                                                class="form-control @error('password')is-invalid @enderror"
                                                id="exampleInputPassword1" placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="showPassword">
                                                <label class="form-check-label" for="showPassword">Tampilkan
                                                    Password</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectRounded0">Role</label>
                                            <select name="role"
                                                class="custom-select rounded-2  @error('role')is-invalid @enderror"
                                                id="exampleSelectRounded0">
                                                @foreach ($roles as $role)
                                                    <option
                                                        value="{{ $role->id }} {{ in_array($role->id, $data->roles->pluck('id')->toArray()) ? 'selected' : '' }}">
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Photo Profile</label>
                                            <div class="input-group">
                                                <div class="col-md-1">
                                                    @if ($data->image)
                                                        <img src="{{ asset('storage/photo-profile/' . $data->image) }}"
                                                            alt="" width="100%">
                                                    @endif
                                                </div>
                                                <div class="col-md-11" style="align-content: center">
                                                    <div class="custom-file">
                                                        <input name="photo" type="file"
                                                            class="custom-file-input @error('photo')is-invalid @enderror"
                                                            id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            File</label>
                                                        <span>
                                                            *Tambahkan file baru jika ingin mengganti foto
                                                        </span>
                                                        @error('photo')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
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
    <!-- Get Name File -->
    <script type="application/javascript">
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
        </script>

    <!-- Show password -->
    <script type="application/javascript">
    $(document).ready(function() {
        $('#showPassword').change(function() {
            if ($(this).is(':checked')) {
                $('#exampleInputPassword1').attr('type', 'text');
            } else {
                $('#exampleInputPassword1').attr('type', 'password');
            }
        });
    });
    </script>
@endsection
