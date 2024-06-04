<?php

namespace App\Controllers;
use App\Models\EatingHabitsModel;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class User extends BaseController
{
    public function connection(): string
    {
        $userModel = new UserModel();
        $login = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $userModel->where('email_address', $login)->first(); 
        $user_id = $user['id_users'];
    
        if ($user) {
            if (password_verify($password, $user['password'])) { 
                $key = 'Le0dgWVBRMMfeZu5Gu485XB2rHjaU/5p6s/lOSrcXOM'; 
                $iat = time();
                $exp = $iat + 3600; 
                $payload = array(
                    "iss" => "Issuer of the JWT",
                    "aud" => "Audience that the JWT",
                    "sub" => "Subject of the JWT",
                    "iat" => $iat, 
                    "exp" => $exp, 
                    "email" => $user['email_address'],
                );
                 
                $token = JWT::encode($payload, $key, 'HS256');
                $eatingHabitsModel = new EatingHabitsModel();
                $eatingHabitsUser = $eatingHabitsModel->where( ['id_users' => $user_id]) -> find();
                $eatingHabitsUser = count($eatingHabitsUser) == 0 ? null : $eatingHabitsUser ;
        
                $response = ['code' => 200, 'success' => true, 'message' => 'User logged in successfully','token' => $token, 'hasEatingHabits' => $eatingHabitsUser];
            } else {
                $response = ['code' => 200, 'success' => false, 'message' => 'Invalid login credentials'];
            }
        } else {
            $response = ['code' => 200, 'success' => false, 'message' => 'User not found'];
        }
    
        return json_encode($response);
    }
    
    
    public function registration()
    {
        $userModel = new UserModel();

        $password = $this->request->getVar('password');
        $firstName = $this->request->getVar('firstName');
        $lastName = $this->request->getVar('lastName');
        $email = $this->request->getVar('email');
        $phoneNumber = $this->request->getVar('phoneNumber');

        $userExists = $userModel->where('email_address', $email)->first();

        if ($userExists) {
            $response = ['code' => 200, 'success' => false, 'message' => 'Email already exists'];
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $data = [
                'email_address' => $email,
                'password' => $hashedPassword,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone_number' => $phoneNumber
            ];
            $userModel->insert($data);

            $response = ['code' => 200, 'success' => true, 'message' => 'User registered successfully'];
        }
        return json_encode($response);
    }
    
    public function forgotPassword(): string
    {
        $userModel = new UserModel();
        $email = $this->request->getVar('email');

        $user = $userModel->where('email_address', $email)->first();

        if ($user) {
            // Générez un token de réinitialisation de mot de passe unique et stockez-le dans la base de données avec l'ID de l'utilisateur
            $resetToken = bin2hex(random_bytes(32)); // Génère un token aléatoire de 64 caractères
            $userModel->update($user['id'], ['reset_token' => $resetToken]);

            // Envoyez un email au utilisateur avec un lien contenant ce token pour réinitialiser leur mot de passe
            // Vous pouvez implémenter cette partie en utilisant une bibliothèque d'envoi d'email comme PHPMailer ou en utilisant une API d'envoi d'email tiers
            // Assurez-vous de fournir un lien dans l'email vers une page où les utilisateurs peuvent réinitialiser leur mot de passe en utilisant ce token

            $response = ['code' => 200, 'success' => true, 'message' => 'Password reset instructions sent to your email'];
        } else {
            $response = ['code' => 200, 'success' => false, 'message' => 'Email not found'];
        }

        return json_encode($response);
    }


    public function profile(){

    }



}
