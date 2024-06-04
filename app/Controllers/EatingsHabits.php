<?php

namespace App\Controllers;
use App\Models\EatingHabitsModel;
use App\Models\UserModel;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;

class EatingsHabits extends BaseController
{
    public function initialization()
    {
        $key = 'Le0dgWVBRMMfeZu5Gu485XB2rHjaU/5p6s/lOSrcXOM'; 
        $authHeader = $this->request->header('Authorization');
        $token = $authHeader->getValue();
        $decoded = JWT::decode($token, new Key($key, 'HS256')); 
        $email = $decoded->email;
       
        // Récupérez l'ID utilisateur en fonction de l'email
        $userModel = new UserModel();
        $user = $userModel->where('email_address', $email)->first();
        var_dump($user);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Utilisateur non trouvé']);
        }

        $userId = $user['id_users'];

        // Récupérer les données du formulaire
        $postData = json_decode($this->request->getBody());

        if (is_array($postData)) {
            $eatingHabitsModel = new EatingHabitsModel();
            foreach ($postData as $responseObj) {
                $id = $responseObj->question->id;
                $value = is_object($responseObj->response) ? $responseObj->response->selectedValues : $responseObj->response;
                $name = $responseObj->question->question;
                $data = [
                    'name' => $name,
                    'value' => $value,
                    'id_question' => $id,
                    'id_users' => $userId
                ];
                $eatingHabitsModel->insert($data);
            }
            return $this->response->setStatusCode(200)->setJSON(['message' => 'Données enregistrées avec succès']);
        } else {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Aucune donnée envoyée']);
        }
 
}

}
