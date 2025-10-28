<?php
declare(strict_types=1);
namespace iutnc\deefy\auth;
use iutnc\deefy\repository\DeefyRepository;


class AuthnProvider{

    public static function signin(string $email, string $password): array {
        $repo = DeefyRepository::getInstance();
        $user = $repo->getUserByEmail($email); 
        
        if (!$user) {
            throw new AuthnException("Utilisateur inconnu");
        }

        if (!password_verify($password, $user['passwd'])) {
            throw new AuthnException("Mot de passe incorrect");
        }

        return $user;
    }
    
    public static function register(string $email, string $password): void {
        $repo = DeefyRepository::getInstance();

        if (strlen($password) < 10) {
            throw new AuthnException("Le mot de passe doit contenir au moins 10 caractères.");
        }

        $existing = $repo->getUserByEmail($email);
        if ($existing) {
            throw new AuthnException("Un compte existe déjà avec cet email.");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        $repo->insertUser($email, $hashedPassword, 1);

    }

}
    