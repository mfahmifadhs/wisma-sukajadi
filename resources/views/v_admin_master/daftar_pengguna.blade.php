@extends('v_admin_master.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Daftar Pengguna</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Daftar Pengguna</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
          <p class="fw-light" style="margin: auto;">{{ $message }}</p>
        </div>
        @endif
        @if ($message = Session::get('failed'))
        <div class="alert alert-danger">
          <p class="fw-light" style="margin: auto;">{{ $message }}</p>
        </div>
        @endif
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title mt-2"><b>Daftar Pengguna</b></h3>
            <div class="card-tools">
              <a type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-add-user">
                <i class="fas fa-plus-circle"></i> Tambah Pengguna
              </a>
            </div>
          </div>
          <div class="card-body">
            <table id="table-1" class="table table-bordered table-striped responsive">
              <thead class="text-center">
                <tr>
                  <th style="width: 5%;">No</th>
                  <th style="width: 25%;">Username</th>
                  <th style="width: 25%;">Nama</th>
                  <th style="width: 25%;">Role</th>
                  <th style="width: 20%;">Status </th>
                  <th>Aksi </th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              <tbody class="text-capitalize text-center">
                @foreach($user as $user)
                <tr>
                  <td class="pt-3">{{ $no++ }}</td>
                  <td class="pt-3">{{ $user->username }}</td>
                  <td class="pt-3">{{ $user->name }}</td>
                  <td class="pt-3">{{ $user->role_name }}</td>
                  <td class="pt-3">{{ $user->status }}</td>
                  <td class="pt-3">
                    <a href="{{ url('admin-master/pengguna/detail/'.$user->id) }}" class="btn btn-primary btn-xs" >
                      <i class="fas fa-user-circle"></i> <br>Detail
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modal-add-user">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Pengguna Baru</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ url('admin-master/pengguna/tambah/baru') }}" method="POST">
            @csrf
            <div class="modal-body">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Role</label>
                <div class="col-sm-9">
                  <select class="form-control text-capitalize" name="role_id" required>
                    @foreach($role as $role)
                    <option value="{{ $role->id_role }}">{{ $role->role_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="username" placeholder="Masukan username (min. 8 karakter)" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="name" placeholder="Nama lengkap pengguna" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Password</label>
                <div class="col-sm-9">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <a type="button" onclick="myFunction()"><i class="fas fa-eye"></i></a>
                      </span>
                    </div>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" min="8">
                  </div>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-9">
                  <select class="form-control text-capitalize" name="status" required>
                    <option value="aktif">Aktif</option>
                    <option value="tidak aktif">Tidak Aktif</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
              <button type="submit" onclick="return confirm('Tambah pengguna baru ?')" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@section('js')
<script>
  $(function () {
    $("#table-1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["excel","pdf"]
    }).buttons().container().appendTo('#table-1_wrapper .col-md-6:eq(0)');
  });

  function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>
@endsection

@endsection