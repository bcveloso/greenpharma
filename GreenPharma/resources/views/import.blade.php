@include('header')
<div class="content-wrapper">
    <br><br>
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
                        <h3 class="card-title">Importação de dados</h3>
                        </div> 
                        <form method="post" enctype="multipart/form-data" action="{{ route('importar.store') }}">
                            <div class="card-body">                                
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group row">
                                    <label for="industria" class="col-sm-3 col-form-label">Indústria</label>
                                    <select class="col-sm-5 form-control" name="industria" id="industria">
                                        <option value="EMS S/A" selected>EMS S/A</option>
                                        <option value="HYPERA S/A" disabled>HYPERA S/A</option>
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <label for="unidade" class="col-sm-3 col-form-label">Unidade</label>
                                    <select class="col-sm-5 form-control" name="unidade" id="unidade">
                                        <option value="Green Pharma - MG" selected>Green Pharma - MG</option>
                                        <option value="Green Pharma - BA" disabled>Green Pharma - BA</option>                        
                                        <option value="Green Pharma - PE" disabled>Green Pharma - PE</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group row">                    
                                    <label for="file" class="col-sm-3 col-form-label" >Importar planilha (*.XLSX)</label> 
                                    <div class="col-sm-5">
                                        <input class="form-control" type="file" name="file" id="file" />
                                    </div>
                                </div>        
                                <div class="form-group row">
                                    <input class="btn btn-secondary" type="submit" value="Importar" onclick="load()" />
                                </div>
                                @if (\Session::has('success'))
                                    <script>window.location.href='#form';</script>
                                    <div class="alert alert-success">
                                        {!! \Session::get('success') !!}
                                    </div>
                                @endif
                                @if($errors->all()) 
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger" role="alert">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endif
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