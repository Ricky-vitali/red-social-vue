<?php
namespace DaVinci\Models;

use DaVinci\DB\DBConnection;
use Exception;
use JsonSerializable;
use PDO;

class Comment extends Modelo implements JsonSerializable
{
    protected $table = "comments";
    protected $pk = "id";
    protected $class = self::class;
    protected $id = null;
    protected $content = null;
    protected $created_at = null;
    protected $post_id = null;
    protected $user_id = null;

    /** @var array Lista de los atributos que permitidos cargar en nuestra clase. */
    protected $atributosPermitidos = ['id', 'content', 'user_id', 'post_id', 'created_at'];

    public function jsonSerialize(){
        return [
            'id' => $this->getId(),
            'content' => $this->getContent(),
            'user_id' => $this->getUserId(),
            'post_id' => $this->getPostId(),
            'created_at' => $this->getCreatedAt(),
        ];
    }

    public function massAssignament(array $data){
        foreach($this->atributosPermitidos as $attr) {
            if(isset($data[$attr])) {
                $this->{$attr} = $data[$attr];
            }
        }
    }

    /**
     * Crea un comentario en la base de datos
     * @param  String $content 
     * @param  String $post_id 
     * @param  String $user_id 
     * @return bool|Exception
     */
    public function create(string $content, string $post_id, string $user_id) {
        $data = [];
     
        $data['content'] = $content;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['post_id'] = $post_id;
        $data['user_id'] = $user_id;
        
        $query = "INSERT INTO " . $this->table . " (";

        foreach($data as $prop => $value){

            $query .= " $prop,";
        }

        $query = substr($query, 0, -1);

        $query .= " ) VALUES (";

        foreach($data as $prop => $value){

            $query .= " :$prop,";
        }

        $query = substr($query, 0, -1);

        $query .= " );";

        $db = DBConnection::getConnection();
        
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($data);

        if(!$exito) {
            throw new Exception('No se pudo crear el Registro');
        }
    }

    /**
     * Elimina un comentario en la base de datos
     * @param  String $id 
     * @param  String $user_id 
     * @return bool
     */
    public function delete(string $id, string $user_id){
        
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM comments
                  WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
 
            if($row['user_id'] != $user_id){
                echo json_encode([
                    'success' => false,
                    'errors' => 'Solo podes eliminar publicaciones propias.'
                ]);
                die();
            }

            $query = "DELETE FROM comments WHERE id=?";
            $stmt = $db->prepare($query);
            
            if($stmt->execute([$id])){
                echo json_encode([
                    'success' => true,
                    'errors' => 'Comentario eliminado con exito'
                ]);
                die();
            }else{
                echo json_encode([
                    'success' => 'errorNotification',
                    'errors' => 'No se pudo eliminar el comentario'
                ]);
                die();
            }

        }
        echo json_encode([
            'success' => false,
            'errors' => 'No existe el post id: '.$id.'.'
        ]);
        die();
    }

    /**
     * Busca y trae los comentarios de un post
     * @param  String $post_id 
     * @return array
     */

    public function byPost($post_id){
        $db = DBConnection::getConnection();

        $query = "SELECT comments.*, users.id AS user_id, users.user as user_user, users.name AS user_name, users.surname AS user_surname FROM comments LEFT JOIN users ON users.id=comments.user_id WHERE post_id=?";
        $stmt = $db->prepare($query);
        $stmt->execute([$post_id]);
  
        $salida = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            array_push($salida, $row);
        }         

        return $salida;
    }


    /**
     * Get y Sets
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

      /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

     /**
     * @return mixed
     */
    public function getPostId()
    {
        return $this->post_id;
    }

    /**
     * @param mixed $post_id
     */
    public function setPostId($post_id)
    {
        $this->post_id = $post_id;
    }

       /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


}
