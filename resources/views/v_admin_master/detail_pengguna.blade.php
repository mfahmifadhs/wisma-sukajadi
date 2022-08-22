@extends('v_admin_master.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Detail Pengguna</b></h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('admin-master/dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{ $user->name }}</li>
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
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img src="{{ asset('images/admin/logo-admin-mini.png') }}" class="img-circle elevation-2" width="50">
            </div>
            <h3 class="profile-username text-center">{{ $user->name }}</h3>
            <p class="text-muted text-center">Username: {{ $user->username }}</p>
            <hr>
          </div>
        </div>
      </div>
      <!-- /.col -->
      <div class="col-md-9">
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
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Profil</a></li>
              <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Ganti Password</a></li>
            </ul>
          </div><!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="profil">
                <form class="form-horizontal" action="{{ url('admin-master/pengguna/ubah/'. $user->id) }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control text-capitalize" name="name" value="{{ $user->name }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                      <input type="hidden" class="form-control" name="old_username" value="{{ $user->username }}">
                      <input type="text" class="form-control" name="username" placeholder="{{ $user->username }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                      <select class="form-control text-capitalize" name="role_id">
                        @foreach($role as $role)
                        <option value="{{ $role->id_role }}" 
                          <?php if($user->role_id == $role->id_role) echo "selected"; ?>>
                          {{ $role->role_name }}
                        </option>
                        @endforeach   
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                      <select class="form-control text-capitalize" name="status">
                        <option value="{{ $user->status }}">{{ $user->status }}</option>
                        @if($user->status == 'aktif')
                        <option value="tidak aktif">tidak aktif</option>
                        @else
                        <option value="aktif">aktif</option>
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-primary" onclick="return confirm('Ubah Informasi Pengguna ?')">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="tab-pane" id="password">
                <form class="form-horizontal" action="{{ url('admin-master/pengguna/ganti-password/'. $user->id) }}" method="POST">
                  @csrf
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password Lama</label>
                    <div class="col-sm-10">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <a type="button" onclick="oldPass()"><i class="fas fa-eye"></i></a>
                          </span>
                        </div>
                        <input type="password" id="old_pass" name="old_pass" class="form-control" placeholder="Masukan password lama" min="8">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Password Baru</label>
                    <div class="col-sm-10">
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <a type="button" onclick="newPass()"><i class="fas fa-eye"></i></a>
                          </span>
                        </div>
                        <input type="password" id="new_pass" name="new_pass" class="form-control" placeholder="Masukan password baru" min="8">
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button type="submit" class="btn btn-primary" onclick="return confirm('Ganti password ?')">Ganti Password</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->

@section('js')
<script>
  function oldPass() {
    var x = document.getElementById("old_pass");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }

  function newPass() {
    var x = document.getElementById("new_pass");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>
@endsection

@endsection