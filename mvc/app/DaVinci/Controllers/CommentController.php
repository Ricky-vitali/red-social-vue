<?php

namespace DaVinci\Controllers;


use DaVinci\Auth\AuthToken;
use DaVinci\Core\Route;
use DaVinci\Core\View;
use DaVinci\Validation\Validator;
use DaVinci\Models\Post;
use DaVinci\Models\Comment;

class CommentController
{
     /**
      * 
     * Crear comentario
     * 
     * @return bool
     */

    public function create(){
        
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
            'post_id' => ['required', 'numeric'],
            'content' => ['required', 'max:255'],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errors_validation' => $validation->getErrores()
            ]);
            die();
        }

        $post = new Post;
        
        try {
            $post->byId($postData['post_id']);
           
            $comment = new Comment;
        
            try {

                $comment->create($postData['content'], $postData['post_id'], $auth->getUsuario()->getId());
                echo json_encode([
                    'success' => true,
                    'message' => 'Comentario creado con éxito'
                ]);
                die();

            } catch(Exception $e) {

                echo json_encode([
                    'success' => false,
                    'errores' => $e->getMessage()
                ]);
                die();

            }

        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errors' => $e->getMessage()
            ]);
            die();
        }
    }

     /**
     * Delete comentario
     * 
     * @return bool
     */

    public function delete(){
        $id = Route::getUrlParameters()['id'];
        
        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errors' => 'Necesitas estar logeado.'
            ]);
            die();
        }

        $deleteComment = new Comment;

        try {
            $deleteComment->delete($id, $auth->getUsuario()->getId());
            echo json_encode([
                'success' => true,
                'message' => 'Comentario eliminado con éxito'
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
     * 
     * @return Comments|bool
     */

    public function byPost(){
        $id = Route::getUrlParameters()['id'];

        $getCommentsByPost = new Comment;

        try {
            echo json_encode([
                'success' => true,
                'data' => $getCommentsByPost->byPost($id)
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
