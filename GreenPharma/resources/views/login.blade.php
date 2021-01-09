<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="css/style.css">
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
                <h3 class="card-title">Login</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="{{ route('login.do') }}" method="POST">
                
                <div class="card-body">
                  <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
                    <label for="email">Nome de Usuário</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                  </div>
                    @if($errors->all()) 
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-secondary">Entrar</button>                  
                </div>
              </form>
                <div class="card-footer">
                  <a href="user/admin/cadastro" class="btn btn-block btn-secondary col-md-2">Novo Usuário</a>
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

<!-- ./wrapper -->

</body>
</html>