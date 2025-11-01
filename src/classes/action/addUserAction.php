<?php
declare(strict_types=1);
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\auth\AuthnException;

class addUserAction extends Action {

     public function execute(): string {
        if ($this->http_method === 'GET') {
            return <<<fin
            <div class="content-box">
                <h1>Inscription</h1>
                <form method="post" action="?action=addUser">
                    <input type="email" name="email" required placeholder="Email">
                    <input type="password" name="mdp" required placeholder="Mot de passe">
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
            fin;
        } else {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $mdp = $_POST['mdp'];

            try {
                AuthnProvider::register($email, $mdp);
                return "<p>Inscription réussie ! Vous pouvez maintenant vous connecter.</p>";
            } catch (AuthnException $e) {
                return "<p>Erreur : " . $e->getMessage() . "</p>";
            }
        }
     }



}