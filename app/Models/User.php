<?php 

class User {
    protected $id;
    protected $nom;
    protected $email;
    protected $password;
    protected $role;
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $query = 'SELECT * FROM users';
        $stmt = $this->db->prepare($query);
        return $stmt->fetchAll();
    }

    public function getByEmail($email) {
        $query = 'SELECT * FROM users WHERE email = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($data) {
        $query = 'INSERT INTO users (nom,prenom,email,password,role)
                    VALUES(?,?,?,?,?) RETURNING id';
        $stmt = $this->db->prepare($query);
        $stmt->execute($data['nom'],$data['prenom'],$data['email'],
        password_hash($data['password'],PASSWORD_BCRYPT),$data['role']);
        return $stmt->fetchColumn();
    }
}

