<?php
class DatabaseHelper{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }        
    }

    // controlla se un utente segue un altro utente
    public function checkFollow($id_utente_seguito, $id_utente){
        $query = "SELECT id_utente_seguito FROM follow WHERE id_utente_seguito=? AND id_utente=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente_seguito, $id_utente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // ottiene i commenti e i loro utenti
    public function getCommentsAndUserByPostId($idpost){
        $query = "SELECT * 
                    FROM commento AS c
                    JOIN utente AS u ON c.id_utente = u.id_utente
                    WHERE c.id_pubblicazione = ?
                    ORDER BY c.data_commento DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idpost);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene gli utenti seguiti
    public function getFollowsByUserId($id, $num=-1, $row_offset=-1){
        $query = "SELECT u.id_utente, nome_utente, img_utente 
                    FROM utente AS u, follow AS f 
                    WHERE f.id_utente = ? AND f.id_utente_seguito = u.id_utente";
        if($num > 0){
            $query .= " LIMIT ? OFFSET ?";
        }
        $stmt = $this->db->prepare($query);
        if($num > 0){
            $stmt->bind_param('iii', $id, $num, $row_offset);
        } else {
            $stmt->bind_param('i', $id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene gli che utenti che seguono
    public function getFollowersByUserId($id, $num=-1, $row_offset=-1){
        $query = "SELECT u.id_utente, nome_utente, img_utente, email  
                    FROM utente AS u, follow AS f 
                    WHERE f.id_utente_seguito = ? AND f.id_utente = u.id_utente";
        if($num > 0){
            $query .= " LIMIT ? OFFSET ?";
        }
        $stmt = $this->db->prepare($query);
        if($num > 0){
            $stmt->bind_param('iii', $id, $num, $row_offset);
        } else {
            $stmt->bind_param('i', $id);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene l'utente
    public function getUserById($id){
        $query = "SELECT * FROM utente WHERE id_utente=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene il post con il suo id
    public function getPostById($id){
        $query = "SELECT id_pubblicazione, testo_pubblicazione, img_pubblicazione, data_pubblicazione FROM pubblicazione WHERE id_pubblicazione=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene il post e l'utente
    public function getPostAndUserById($idpost){
        $query = "SELECT * 
                    FROM pubblicazione AS p 
                    JOIN utente AS u ON p.id_utente = u.id_utente 
                    WHERE p.id_pubblicazione = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $idpost);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene i post dell'utente
    public function getPostByUserId($id, $num=-1, $row_offset=-1){
        $query = "SELECT id_pubblicazione, testo_pubblicazione, img_pubblicazione, data_pubblicazione 
                    FROM pubblicazione 
                    WHERE id_utente=? 
                    ORDER BY data_pubblicazione DESC, id_pubblicazione DESC";
        if($num > 0){
            $query .= " LIMIT ? OFFSET ?";
        }
        $stmt = $this->db->prepare($query);
        if($num > 0){
            $stmt->bind_param('iii', $id, $num, $row_offset);
        } else {
            $stmt->bind_param('i', $id);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // verifica se la password è corretta
    public function checkPassword($id_utente, $password){
        $query = "SELECT nome_utente FROM utente WHERE id_utente = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is',$id_utente, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // controlla il login
    public function checkLogin($email, $password){
        $query = "SELECT id_utente, nome_utente, data_nascita FROM utente WHERE email = ? AND password = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss',$email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // controllo se il post e' dell'utente
    public function checkIfUserPost($id_utente, $id_post){
        $query = "SELECT data_pubblicazione FROM pubblicazione WHERE id_utente=? AND id_pubblicazione=?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente, $id_post);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // controlla se la mail esiste
    public function checkIfEmailExists($email){
        $query = "SELECT id_utente FROM utente WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // controlla se l'utente esiste
    public function checkIfUsernameExists($nomeutente){
        $query = "SELECT id_utente FROM utente WHERE nome_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s',$nomeutente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene i post recenti degli utenti seguiti
    public function getRecentFollowedPosts($id_utente, $num_posts, $row_offset){
        $query = "SELECT pubblicazione.*, utente.id_utente, utente.nome_utente, utente.img_utente 
                FROM pubblicazione 
                JOIN utente ON pubblicazione.id_utente = utente.id_utente
                JOIN follow ON pubblicazione.id_utente = follow.id_utente_seguito
                WHERE follow.id_utente = ?
                ORDER BY pubblicazione.data_pubblicazione DESC 
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iii',$id_utente, $num_posts, $row_offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // ottiene i post recenti degli utenti seguiti
    public function getFollowedPosts($id_utente){
        $query = "SELECT pubblicazione.*, utente.id_utente, utente.nome_utente, utente.img_utente 
                FROM pubblicazione 
                JOIN utente ON pubblicazione.id_utente = utente.id_utente
                JOIN follow ON pubblicazione.id_utente = follow.id_utente_seguito
                WHERE follow.id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$id_utente);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // inserisce un nuovo post
    public function insertPost($testo_pubblicazione, $data_pubblicazione, $img_pubblicazione, $id_utente){
        $query = "INSERT INTO pubblicazione (testo_pubblicazione, data_pubblicazione, img_pubblicazione, id_utente) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssi',$testo_pubblicazione, $data_pubblicazione, $img_pubblicazione, $id_utente);
        $stmt->execute();
        return $stmt->insert_id;
    }

    // inserisce un nuovo follow
    public function insertFollow($id_utente_seguito, $id_utente){
        $query = "INSERT INTO follow (id_utente, id_utente_seguito) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_utente, $id_utente_seguito);
        $stmt->execute();
        return true;
    }

    // aggiunge un nuovo commento
    public function addComment($testo, $data, $id_utente, $id_pubblicazione){
        $query = "INSERT INTO commento (testo_commento, data_commento, id_utente, id_pubblicazione) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssii',$testo, $data, $id_utente, $id_pubblicazione);
        return $stmt->execute();
    }

    // crea un utente
    public function createAccount($nomeutente, $datanascita, $email, $password, $img_utente){
        $query = "INSERT INTO utente (email, password, data_nascita, nome_utente, img_utente) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sssss',$email, $password, $datanascita, $nomeutente, $img_utente);
        return $stmt->execute(); 
    }

    // aggiunge una notifica
    public function addNotification($id_utente, $testo){
        $query = "INSERT INTO notifica (id_utente, testo_notifica) VALUES (?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $id_utente, $testo);
        return $stmt->execute();
    }

    // aggiorna il post dell'utente
    public function updatePostOfUser($id_pubblicazione, $testo_pubblicazione, $img_pubblicazione){
        $query = "UPDATE pubblicazione SET testo_pubblicazione = ?, img_pubblicazione = ? WHERE id_pubblicazione = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssi', $testo_pubblicazione, $img_pubblicazione, $id_pubblicazione);
        
        return $stmt->execute();
    }

    // aggiorna il nome dell'utente
    public function updateUserName($id_utente, $nome_utente){
        $query = "UPDATE utente SET nome_utente = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $nome_utente, $id_utente);
        return $stmt->execute();
    }
    
    // aggiorna l'email dell'utente
    public function updateUserEmail($id_utente, $email){
        $query = "UPDATE utente SET email = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $email, $id_utente);
        return $stmt->execute();
    }

    // aggiorna la password dell'utente
    public function updateUserPassword($id_utente, $password){
        $query = "UPDATE utente SET password = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $password, $id_utente);
        return $stmt->execute();
    }

    // aggiorna l'immagine dell'utente
    public function updateUserImg($id_utente, $img_utente){
        $query = "UPDATE utente SET img_utente = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $img_utente, $id_utente);
        return $stmt->execute();
    }

    // elimina i commenti di un post
    public function deleteCommentsOfPost($id_pubblicazione){
        $query = "DELETE FROM commento WHERE id_pubblicazione = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i',$id_pubblicazione);
        $stmt->execute();
        var_dump($stmt->error);
        return true;
    }

    // elimina un post dell'utente
    public function deletePostOfUser($id_pubblicazione, $id_utente){
        $query = "DELETE FROM pubblicazione WHERE id_pubblicazione = ? AND id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii',$id_pubblicazione, $id_utente);
        $stmt->execute();
        var_dump($stmt->error);
        return true;
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

}
?>