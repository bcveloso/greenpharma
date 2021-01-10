<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ProductController extends Controller
{
    public function list(Request $request){
        
        /*  
            $type: 
                1 - quantidade 
                2 - valor        
        */
        $type  = $request->tipo;
        $industria  = $request->industria;
        $unidade  = $request->unidade;
        $date_inicial = $request->date_inicial;
        $date_final = $request->date_final;
        if(empty($date_inicial)){
            return redirect()->back()->withInput()->withErrors(['Data inicial deve ser preenchida!']);
        }
        if(empty($date_final)){
            return redirect()->back()->withInput()->withErrors(['Data final deve ser preenchida!']);
        }
        if(strtotime($date_inicial) > strtotime($date_final)){
            return redirect()->back()->withInput()->withErrors(['Data inicial deve ser menor que data final!']);
        }

        if($type == 1){
            $ret = $this->getAmountProducts($industria,$unidade,$date_inicial,$date_final); // Faz consulta do procedure com a quantidade de itens
        }else{
            $ret = $this->getValueProducts($industria,$unidade,$date_inicial,$date_final);  // Faz consulta do procedure com os valores dos itens          
        }

        if(empty($ret)){
            $valid = 0;
            return view('relatorio.list',[
                'valid' => $valid
            ]);
        }else{
            $valid = 1;
        }

        $array_data = $this->arrayDate($date_inicial,$date_final,$ret[0]); // Cria 2 arrays um com os itens do banco de dados a serem exibidos e outro com as competencias modificadas
  
        $title = array(); // Titulo que irá aparecer na datatable
        $value = array(); // Valores da datatable
        $count = 0;
        $count2 = -4;
        foreach($ret as $itens){
            $sub_value = array();
            foreach($itens as $key => $item){
                if(in_array($key,$array_data[0])){
                    if(empty($item)){
                        $item = '-';
                    }
                    if($count == 0){
                        if($count2 < 0){
                            array_push($title, $key);
                        }else{
                            array_push($title, $array_data[1][$count2]);
                        }                         
                    }
                    array_push($sub_value,$item);
                    $count2++;
                }                
            }
            array_push($value,$sub_value);
            $count2 = -4;
            $count++;
        }

        if(empty($value)){
            $valid = 0;
        }else{
            $valid = 1;
        }

        return view('relatorio.list',[
            'valid' => $valid,
            'title' => $title,
            'value' => $value
        ]);
       
       
    }
    private function getValueProducts($industria,$unidade,$date_inicial,$date_final){
        /*  Sequencia da procedure de valores
            Data inicial
            Data final 
            Unidade
            Industria
        */
        
        return DB::select('SET NOCOUNT ON; EXEC pesquisaProdutos ?,?,?,?',array($date_inicial,$date_final,$unidade,$industria));
        
    }
    private function getAmountProducts($industria,$unidade,$date_inicial,$date_final){
        /*  Sequencia da procedure de quantidade
            Data inicial
            Data final 
            Unidade
            Industria
        */
        return DB::select('SET NOCOUNT ON; EXEC pesquisaProdutosQuatidades ?,?,?,?',array($date_inicial,$date_final,$unidade,$industria));
    }
    private function arrayDate($i,$f,$key){
        
        $data = $this->month($i,$f); // retornar array com os meses da data inicial até a final
        $array_data = array();
        $array_data2 = array();

        array_push($array_data,'PRODUTO','EAN','DESCRIÇÃO','FORNECEDOR');
        foreach($key as $keys => $item){

            if(in_array($keys,$data)){
                array_push($array_data,$keys);
                $e = explode('-',$keys);
                $dt = intval($e[1]).'/'.intval($e[0]);
                array_push($array_data2,$dt);
            }                
        }

        return [$array_data,$array_data2];

    }
    private function month($i,$f){ 
        $data = array();
        $inicial = explode('-',$i);
        $ano_inicial = intval($inicial[0]);
        $mes_inicial = intval($inicial[1]);
        $final = explode('-',$f);
        $ano_final = intval($final[0]);
        $mes_final = intval($final[1]);
        $qtd = $ano_final-$ano_inicial+1;
        for($z = 0;$z < $qtd;$z++){
            if($z+1 == $qtd){
                $cont = $mes_final;
            }else{
                $cont = 12;
            }            
            if($z == 0){
                for($w = $mes_inicial;$w <= $cont;$w++){
                    if($w < 10){
                        $m = ($ano_inicial)."-0$w-01";
                        array_push($data,$m);
                    }else{
                        $m = ($ano_inicial)."-$w-01";
                        array_push($data,$m);
                    }                    
                }
            }else{
                for($w = 1;$w <= $cont;$w++){
                    if($w < 10){
                        $m = ($ano_inicial+$z)."-0$w-01";
                        array_push($data,$m);
                    }else{
                        $m = ($ano_inicial+$z)."-$w-01";
                        array_push($data,$m);
                    }
                }
            }
        }
        return $data;
    }
}
