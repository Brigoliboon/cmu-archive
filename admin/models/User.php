<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $sql = "INSERT INTO users (username, password, first_name, middle_name, last_name, 
                extension, email, role, AccessLevelID, created_at) 
                VALUES (:username, :password, :first_name, :middle_name, :last_name, 
                :extension, :email, :role, :AccessLevelID, NOW())";

        $params = [
            ':username' => $data['username'],
            ':password' => password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => PASSWORD_HASH_COST]),
            ':first_name' => $data['firstName'],
            ':middle_name' => $data['middleName'] ?? null,
            ':last_name' => $data['lastName'],
            ':extension' => $data['extension'] ?? null,
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':AccessLevelID' => $data['AccessLevelID']
        ];

        try {
            $this->db->beginTransaction();
            $stmt = $this->db->query($sql, $params);
            $userId = $this->db->lastInsertId();
            $this->db->commit();
            return $userId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->query($sql, [':email' => $email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->db->query($sql, [':id' => $id]);
        return $stmt->fetch();
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET 
                username = :username,
                first_name = :first_name,
                middle_name = :middle_name,
                last_name = :last_name,
                extension = :extension,
                email = :email,
                role = :role,
                AccessLevelID = :AccessLevelID,
                updated_at = NOW()
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':username' => $data['username'],
            ':first_name' => $data['firstName'],
            ':middle_name' => $data['middleName'] ?? null,
            ':last_name' => $data['lastName'],
            ':extension' => $data['extension'] ?? null,
            ':email' => $data['email'],
            ':role' => $data['role'],
            ':AccessLevelID' => $data['AccessLevelID']
        ];

        if (!empty($data['password'])) {
            $sql = str_replace('updated_at = NOW()', 'password = :password, updated_at = NOW()', $sql);
            $params[':password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => PASSWORD_HASH_COST]);
        }

        try {
            $this->db->beginTransaction();
            $stmt = $this->db->query($sql, $params);
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = :id";
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->query($sql, [':id' => $id]);
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getAll($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->db->query($sql, [':limit' => $limit, ':offset' => $offset]);
        return $stmt->fetchAll();
    }

    public function count() {
        $sql = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetch()['total'];
    }

    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
} 