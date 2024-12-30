<?php 
// User.php
class User {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $archive;

    public function __construct($nom, $prenom, $email) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->archive = 'false';
    }

    public function register() {
        // Implementation to register user
    }

    public function login() {
        
    }

    public function logout() {
        // Implementation to logout user
    }

    public function updateProfile() {
        // Implementation to update user profile
    }

    public function softDeleteReview($id_review) {
        // Implementation to soft delete a review
    }
}
?>