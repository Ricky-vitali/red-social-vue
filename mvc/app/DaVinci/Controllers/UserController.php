<?php

namespace DaVinci\Controllers;

use DaVinci\Core\App;
use DaVinci\Core\View;
use DaVinci\Models\User;

use DaVinci\Auth\AuthToken;

use Davinci\Validation\Validator;

class UserController
{

     /**
     * Registro de usuario
     * 
     * @return bool
     */
    public function register()
    {
        /*$params = Route::getUrlParameters();
        $id = $params['id'];*/
        
        $data = file_get_contents('php://input');
        $postData = json_decode($data, true);

        $validation = new Validator($postData,[
            'user' => ['required', 'min:6', "unique:user", "max:30"],
            'name' => ['required', 'min:2', "max:45"],
            'surname' => ['required', 'min:2', "max:45"],
            'email' => ['required', 'email', 'unique:email', "max:255"],
            'password' => ['required', 'min:8', "max:20"],
            'confirm_password' => ['required', 'min:8', "max:20"]
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errors_validation' => $validation->getErrores()
            ]);
            die();
        }

        iF($postData['password'] !== $postData['confirm_password']){
            echo json_encode([
                'success' => false,
                'errors' => 'Las contraseñas deben ser iguales'
            ]);
            die();
        }

        $user = new User;
        
        try {
            $user->registrar($postData);
            echo json_encode([
                'success' => true,
                'errors' => ''
            ]);
            die();
        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
            die();
        }
    }

     /**
     * Editar usuario
     * 
     * @return bool
     */

    public function editUser(){
        $data = file_get_contents('php://input');
        $postData = json_decode($data, true);

        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errors' => 'Necesitas estar logeado.'
            ]);
            die();
        }

        $validation = new Validator($postData,[
            'user' => ['required', 'min:6', "max:30"],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errors_validation' => $validation->getErrores()
            ]);
            die();
        }

        if($postData['user'] == $auth->getUsuario()->getUser()){
            echo json_encode([
                'success' => false,
                'errors' => 'El nombre de usuario que se quiere modificar es el mismo que el anterior.'
            ]);
            die();
        }

        $user = new User;

        try {
            $user->editUser($postData['user'], $auth->getUsuario()->getId());
            echo json_encode([
                'success' => true,
                'message' => 'Nombre de usuario editado con éxito'
            ]);
            die();
        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
            die();
        }
        
    }

   
}