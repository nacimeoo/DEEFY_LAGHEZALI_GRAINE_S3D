<?php
declare(strict_types=1);
namespace iutnc\deefy\action;

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\auth\AuthnException;



class SigninAction extends Action{

    public function execute():string{
        if ($this->http_method === 'GET') {
        return <<<fin
            <div class="content-box">
                <h1>authentification : </h1>
                <form method="post" action="?action=signin">
                    <input type="email" name="email" required placeholder="Email">
                    <input type="password" name="mdp" required placeholder="Mot de passe">
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        fin;

        }else{
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $mdp= $_POST['mdp'];

            try{
                $user = AuthnProvider::signin($email, $mdp);
                $_SESSION['user'] = $user;

                return "<p>Authentification réussie ! Bienvenue " . htmlspecialchars($user['email']) . ".</p>";

            }catch(AuthnException $e){
                return "<p>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
            }
            
        }
    }    
    
}