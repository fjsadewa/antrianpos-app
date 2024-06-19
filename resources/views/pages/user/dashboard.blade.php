@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card ">
                    <div class="card-header" style="display: flex; justify-content: space-between">
                        <label class="card-title" style="flex-grow: 1;">Dashboard</label>
                        <div style="justify-content: space-between">
                            <a data-toggle="modal" data-target="#backup" style="display: inline-block;">
                                <button class="btn bg-gradient-primary">Backup Data</button>
                            </a>
                        </div>
                        <div class="modal fade" id="backup">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Peringatan!</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah anda yakin ingin memindahkan data?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                        <button onclick="location.href='{{ route('admin.moveData') }}'"
                                            class="btn btn-primary">Yakin</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-header -->
                </div>
            </div>
        </section>
    </div>
@endsection
