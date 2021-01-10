<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Novo Usuário</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="hold-transition sidebar-mini colorgrey">
<div class="wrapper">
    
    <!-- Main content -->
    <section class="content">
      <div class="container">
        <div class="row top">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <!-- jquery validation -->
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Novo Usuário</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="{{ route('user.admin.cadastro.do') }}" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                    <label for="email">E-mail</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="email" required value="{{ old('email') }}">
                  </div>
                  <div class="form-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" required value="{{ old('nome') }}">
                  </div>
                  <div class="form-group">
                    <label for="nome">Nome</label>
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="1" {{ (old("tipo") == '1' ? "selected":"") }}>Administrador</option>
                        <option value="2" {{ (old("tipo") == '2' ? "selected":"") }}>Analista</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <label for="password_confirm">Confirme a Senha</label>
                    <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="Password" required>
                  </div>
                  @if (\Session::has('success'))
                      <script>window.location.href='#form';</script>
                      <div class="alert alert-success form-group">
                          {!! \Session::get('success') !!}
                      </div>
                  @endif
                  @if($errors->all()) 
                      @foreach ($errors->all() as $error)
                          <div class="alert alert-danger form-group" role="alert">
                              {{ $error }}
                          </div>
                      @endforeach
                  @endif
                  </div>
                
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-secondary">Cadastrar</button>
                </div>
              </form>
              <div class="card-footer">
                <a href="{{ route('login') }}" class="btn btn-block btn-secondary col-md-2">Login</a>
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
  
</div>
<!-- ./wrapper -->

</body>
</html>