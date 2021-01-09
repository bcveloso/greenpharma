<?php

namespace App\Http\Controllers;

use App\Model\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class userLogin extends Controller
{
    public function newUser(Request $request){
        
        /* flg_type define o tipo de usuario 
            type 1 - Administrador
            type 2 - Analista
        */

        $email = $request->email;
        $nome = $request->nome;
        $tipo = $request->tipo;

        if($request->password != $request->password_confirm ){
            return redirect()->back()->withInput()->withErrors(['As Senhas não coincidem!']);
        }

        $email_verificar = $this->verificarEmail($email);
        if($email_verificar){
            return redirect()->back()->withInput()->withErrors(['Email já cadastrado!']);
        }

        $password = bcrypt($request->password);
        
        $id = DB::table('users')->insertGetId(['name' => $nome,'email' => $email, 'password' => $password,'flg_type' => $tipo,'flg_active' => '0',]);
        return redirect()->back()->withInput()->with('success', 'Cadastro efetuado com sucesso!');
        
    }
    private function verificarEmail($email){
        return DB::select("select * from users where email = '$email'");
    }
}
