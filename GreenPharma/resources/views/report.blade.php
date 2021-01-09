@include('header')
<div class="content-wrapper">
    <br><br>
    <!-- Main content -->
    <section class="content">
        <div id="blanket"></div>            
        <div id="aguarde">Aguarde...</div>
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-secondary">
                <div class="card-header">
                  <h3 class="card-title">Relatórios</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ route('relatorio.list') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="tipo">Tipo de Relatório</label>
                            <select class="col-sm-5 form-control" name="tipo" id="tipo">
                                <option value="1">Quantidade Vendida</option>
                                <option value="2">Valor Vendido</option>
                            </select>                        
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="industria">Indústria</label>
                            <select class="col-sm-5 form-control" name="industria" id="industria">
                                <option value="EMS S/A" selected>EMS S/A</option>
                                <option value="HYPERA S/A">HYPERA S/A</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="unidade">Unidade</label>
                            <select class="col-sm-5 form-control" name="unidade" id="unidade">
                                <option value="Green Pharma - PE">Green Pharma - PE</option>
                                <option value="Green Pharma - BA">Green Pharma - BA</option>
                                <option value="Green Pharma - MG" selected>Green Pharma - MG</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="date_inicial">Data Início</label>
                            <input type="date" class="col-sm-5 form-control" id="date_inicial" name="date_inicial" placeholder="" required>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="date_final">Data Fim</label>
                            <input type="date" class="col-sm-5 form-control" id="date_final" name="date_final" placeholder="" required>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-secondary" onclick="load()">Gerar Relatório</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
@include('footer')
<script>
    function load(){
        $('#aguarde, #blanket').css('display', 'block');
    }    
</script>