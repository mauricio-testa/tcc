<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ErrorInterpreter extends Controller
{
    public static function getMessage($exception, $customMessages = [])
    {
        $errorInfo  = $exception->getPrevious()->errorInfo;
        $message    = $exception->getMessage();
        $errorList  = [
            1451 => 'Você não pode deletar este registro pois outros cadastros depedem dele',
            1452 => 'Erro de chave estrangeira ao inserir ou atualizar'

        ];
        
        if (!empty($errorInfo[1]) && $errorInfo[0] == 23000) {
            $errorCode = $errorInfo[1];

            // tenta buscar a mensagem de erro no parametro enviado pelo método
            if (array_key_exists($errorCode, $customMessages)) 
            return $customMessages[$errorCode];
            
            // se não encontrar, busca nas mensagens de erro deste método
            if (array_key_exists($errorCode, $errorList)) 
            return $errorList[$errorCode];
            
        }

        return $message;
    }
}
