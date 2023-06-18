<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }

    // controlla se esiste l'utente
    public function checkUser($email, $password, $username=-1){
        if($username === -1){
            $query = "SELECT id_utente, nome_utente, email, img_utente FROM utente WHERE email = ? AND password = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $email, $password);   
        } else {
            $query = "SELECT nome_utente, email FROM utente WHERE email = ? OR nome_utente = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ss', $email, $username);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene i post degli utenti seguiti
    public function getPostOfFollowedUsers($id_utente){
        $query = "SELECT post.*, utente.nome_utente, utente.img_utente 
                FROM post 
                JOIN utente ON post.id_utente = utente.id_utente
                JOIN follow ON post.id_utente = follow.id_utente_seguito
                WHERE follow.id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$id_utente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // controlla se un utente segue un altro utente
    public function checkFollow($id_utente_seguito, $id_utente){
        $query = "SELECT * FROM follow WHERE id_utente_seguito = ? AND id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente_seguito, $id_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene i dati dell'utente
    public function getUser($id){
        $query = "SELECT id_utente, email, data_nascita, nome_utente, img_utente
                    FROM utente WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene utenti seguiti con s, utenti che seguono con ers
    public function getUserFollow($id, $choise){
        $query = "SELECT u.id_utente, email, data_nascita, nome_utente, img_utente
                    FROM utente AS u, follow AS f";
        if($choise === "s"){
            $query .= " WHERE f.id_utente = ? AND f.id_utente_seguito = u.id_utente";
        } elseif($choise === "ers") {
            $query .= " WHERE f.id_utente_seguito = ? AND f.id_utente = u.id_utente";
        }
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene i post dell'utente
    public function getUserPost($id){
        $query = "SELECT *
                    FROM post 
                    WHERE id_utente = ? 
                    ORDER BY data_post DESC, id_post DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // inserisce un nuovo follow
    public function insertFollow($id_utente_seguito, $id_utente){
        $query = "INSERT INTO follow (id_utente, id_utente_seguito) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente, $id_utente_seguito);
        $stmt->execute();
        return true;
    }

    // inserisce una nuova notifica
    public function addNotification($id_utente, $testo){
        $query = "INSERT INTO notifica (id_utente, testo_notifica) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $id_utente, $testo);
        return $stmt->execute();
    }

    // rimuove il follow dell'utente
    public function deleteFollow($id_utente_seguito, $id_utente){
        $query = "DELETE FROM follow WHERE id_utente_seguito=? AND id_utente=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente_seguito, $id_utente);
        $stmt->execute();
        var_dump($stmt->error);
        return true;
    }

    // inserisce un nuovo utente
    public function insertUser($email, $password, $datanascita, $nomeutente, $img_utente){
        $query = "INSERT INTO utente (email, password, data_nascita, nome_utente, img_utente) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssss', $email, $password, $datanascita, $nomeutente, $img_utente);
        return $stmt->execute(); 
    }

    // ottiene il post e l'utente
    public function getPostAndUser($id_post){
        $query = "SELECT * 
                    FROM post AS p 
                    JOIN utente AS u ON p.id_utente = u.id_utente 
                    WHERE p.id_post = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_post);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene i commenti e i loro utenti
    public function getCommentsAndUser($id_post){
        $query = "SELECT * 
                    FROM commento AS c
                    JOIN utente AS u ON c.id_utente = u.id_utente
                    WHERE c.id_post = ?
                    ORDER BY c.data_commento DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_post);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // inserisce un nuovo commento
    public function insertComment($testo, $data, $id_utente, $id_post){
        $query = "INSERT INTO commento (testo_commento, data_commento, id_utente, id_post) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssii', $testo, $data, $id_utente, $id_post);
        return $stmt->execute();
    }

    // aggiorna l'utente
    public function updateUser($id_utente, $nome_utente, $email, $img){
        $query = "UPDATE utente 
                    SET nome_utente = ?, email = ?, img_utente = ?
                    WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssi', $nome_utente, $email, $img, $id_utente);
        return $stmt->execute();
    }

    // aggiorna la password
    public function updatePassword($id_utente, $password){
        $query = "UPDATE utente SET password = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $password, $id_utente);
        return $stmt->execute();
    }

    // controlla se il post e' dell'utente
    public function checkIfUserPost($id_utente, $id_post){
        $query = "SELECT data_post FROM post WHERE id_utente=? AND id_post = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente, $id_post);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // inserisce un nuovo post
    public function insertPost($testo_post, $data_post, $img_post, $id_utente){
        $query = "INSERT INTO post (testo_post, data_post, img_post, id_utente) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssi', $testo_post, $data_post, $img_post, $id_utente);
        $stmt->execute();
        return $stmt->insert_id;
    }

    // aggiorna il post
    public function updatePost($id_post, $testo_post, $img_post){
        $query = "UPDATE post SET testo_post = ?, img_post = ? WHERE id_post = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssi', $testo_post, $img_post, $id_post);
        
        return $stmt->execute();
    }

    // elimina i commenti di un post
    public function deleteCommentsOfPost($id_post){
        $query = "DELETE FROM commento WHERE id_post = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_post);
        $stmt->execute();
        var_dump($stmt->error);
        return true;
    }

    // elimina un post dell'utente
    public function deletePostOfUser($id_post, $id_utente){
        $query = "DELETE FROM post WHERE id_post = ? AND id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_post, $id_utente);
        $stmt->execute();
        var_dump($stmt->error);
        return true;
    }

}
?>