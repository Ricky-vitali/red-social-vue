<?php

namespace DaVinci\Controllers;


use DaVinci\Auth\AuthToken;
use DaVinci\Core\Route;
use DaVinci\Core\View;
use DaVinci\Validation\Validator;
use DaVinci\Models\Post;
use DaVinci\Models\Comment;

class PostController
{
     /**
      * 
     * Crear posteo
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
            $post->create($postData['content'], $auth->getUsuario()->getId());
            echo json_encode([
                'success' => true,
                'message' => 'Posteo creado con éxito'
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
     * Delete Post
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

        $deletePost = new Post;

        try {
            $deletePost->delete($id, $auth->getUsuario()->getId());
            echo json_encode([
                'success' => true,
                'message' => 'Post eliminado con éxito'
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
     * @return Post|bool
     */
    
    public function byId(){

        $id = Route::getUrlParameters()['id'];

        $getPostById = new Post;
        $getCommentsByPost = new Comment;

        try {

            echo json_encode([
                'success' => true,
                'post' => $getPostById->byId($id),
                'comments' => $getCommentsByPost->byPost($id)
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
     * @return Post|bool
     */

    public function byUser(){

        $id = Route::getUrlParameters()['id'];

        $getPostByUserId = new Post;

        $getPostByUserId = $getPostByUserId->byUser($id);
        try {
            echo json_encode([
                'success' => true,
                'post' => $getPostByUserId,
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

    public function getAll(){

        $getAllPosts = new Post;

        try {
            echo json_encode([
                'success' => true,
                'posts' => $getAllPosts->getAll()
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
