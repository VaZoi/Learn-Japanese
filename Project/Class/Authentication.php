<?php
require_once('database.php');

class Authentication
{

    public $dbh;
    public $users = "users";

    public function __construct(DB $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * Execute a SQL query with optional placeholders
     */
    private function execute($sql, $placeholders = null) {
        return $this->dbh->execute($sql, $placeholders); // Use the DB class's execute function
    }

    /**
     * Register a new user
     */
    public function registerUser($username, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_ARGON2ID); // Securely hash the password
        $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)";
        try {
            $this->execute($sql, [
                ':username' => $username,
                ':email' => $email,
                ':password_hash' => $passwordHash
            ]);
            return true;
        } catch (PDOException $e) {
            // Handle duplicate username/email errors
            if ($e->getCode() == 23000) {
                return "Username or email already exists.";
            }
            return $e->getMessage();
        }
    }

    /**
     * Login a user (validate credentials)
     */
    public function loginUser($usernameOrEmail, $password) {
        $sql = "SELECT * FROM users WHERE username = :identifier OR email = :identifier";
        $stmt = $this->execute($sql, [':identifier' => $usernameOrEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user; // Return user data if password is correct
        }
        return false; // Invalid credentials
    }

    /**
     * Create a session for the user
     */
    public function createSession($userId, $token, $expiresAt) {
        $sql = "INSERT INTO sessions (user_id, session_token, expires_at) VALUES (:user_id, :session_token, :expires_at)";
        $this->execute($sql, [
            ':user_id' => $userId,
            ':session_token' => $token,
            ':expires_at' => $expiresAt
        ]);
    }

    /**
     * Validate a session
     */
    public function validateSession($token) {
        $sql = "SELECT * FROM sessions WHERE session_token = :token AND expires_at > NOW()";
        $stmt = $this->execute($sql, [':token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Logout a user (delete session)
     */
    public function logoutUser($token) {
        $sql = "DELETE FROM sessions WHERE session_token = :token";
        $this->execute($sql, [':token' => $token]);
    }

    /**
     * Validate session and get user information
     * Call this function on every page to ensure the user is logged in
     */
    public function validateUserSession() {
        // Check if session token exists in cookies
        if (!isset($_COOKIE['session_token'])) {
            header('Location: login.php'); // Redirect to login if not logged in
            exit;
        }

        $sessionToken = $_COOKIE['session_token'];

        // Validate the session
        $session = $this->validateSession($sessionToken); // This calls the existing validateSession function
        if (!$session) {
            header('Location: login.php'); // Redirect to login if session is invalid or expired
            exit;
        }

        // Fetch user data based on session
        $userId = $session['user_id'];
        $sql = "SELECT * FROM users WHERE id = :user_id";
        $stmt = $this->dbh->execute($sql, [':user_id' => $userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // If user not found, logout and redirect to login
            setcookie('session_token', '', time() - 86400, '/'); // Expire the cookie
            header('Location: login.php');
            exit;
        }

        return $user; // Return user data for use in the page
    }

}
$myDB = new DB();
$auth = new Authentication($myDB);
