<?php

namespace DaVinci\Controllers;


use DaVinci\Auth\AuthToken;
use DaVinci\Core\View;
use DaVinci\Validation\Validator;

class AuthController
{

     /**
     * Login
     * 
     * @return User|bool
     */
    public function login()
    {
        $jsonData = file_get_contents('php://input');
        $postData = json_decode($jsonData, true);

        $validation = new Validator($postData, [
            'email' => ['required', 'email', "max:255"],
            'password' => ['required', 'min:8', "max:20"],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errors_validation' => $validation->getErrores()
            ]);
            die();
        }

        $auth = new AuthToken();
        if(!$auth->login($postData['email'], $postData['password'])) {
            echo json_encode([
                'success' => false,
                'errors' => 'Las credenciales no son validas.'
            ]);
            die();
        }

        $user = $auth->getUsuario();

        echo json_encode([
            'success' => true,
            'user' => $user
        ]);
        die();
    }

     /**
     * Logout
     *  
     * @return bool
     */
    public function logout()
    {
        (new AuthToken())->logout();
        echo json_encode([
            'success' => true,
            'message' =>'Sesión cerrada con éxito.'
        ]);
        die();
    }

     /**
     * Autentica
     * 
     * @return User|bool
     */

    public function getAuth(){

        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errors' =>'Debes iniciar sesion'
            ]);
            die();
        }else{
            echo json_encode([
                'success' => true,
                'user' => [
                    "id" => $auth->getUsuario()->getId(),
                    "user" => $auth->getUsuario()->getUser(),
                    "name" => $auth->getUsuario()->getName(),
                    "surname" => $auth->getUsuario()->getSurname(),
                    "email" => $auth->getUsuario()->getEmail(),
                    "biography" => $auth->getUsuario()->getBiography(),
                    "create_at" => $auth->getUsuario()->getCreatedAt(),
                ]
            ]);
            die();
        }

    }
}
