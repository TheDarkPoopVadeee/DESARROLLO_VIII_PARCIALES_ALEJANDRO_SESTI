<?php
require 'config.php';

class GoogleAuth {
    private $clientID;
    private $clientSecret;
    private $redirectUri;
    private $pdo;

    public function __construct($pdo) {
        global $clientID, $clientSecret, $redirectUri;
        $this->clientID = $clientID;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->pdo = $pdo;
    }

    public function getAuthUrl() {
        $authorizationUrl = "https://accounts.google.com/o/oauth2/v2/auth";
        $params = array(
            'response_type' => 'code',
            'client_id' => $this->clientID,
            'redirect_uri' => $this->redirectUri,
            'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
            'prompt' => 'select_account'
        );
        return $authorizationUrl . '?' . http_build_query($params);
    }

    public function authenticate($code) {
        $accessTokenUrl = 'https://oauth2.googleapis.com/token';
        $params = array(
            'code' => $code,
            'client_id' => $this->clientID,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'grant_type' => 'authorization_code'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $accessTokenUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        $accessTokenData = json_decode($response, true);

        if (isset($accessTokenData['access_token'])) {
            $_SESSION['access_token'] = $accessTokenData['access_token'];
            $this->storeUser($accessTokenData['access_token']);
            return true;
        } else {
            echo 'Error retrieving access token.';
            echo '<pre>' . print_r($accessTokenData, true) . '</pre>';
            return false;
        }
    }

    private function storeUser($token) {
        $userInfoUrl = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=" . $token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $userInfo = curl_exec($ch);
        curl_close($ch);

        $userInfoData = json_decode($userInfo, true);

        $stmt = $this->pdo->prepare("INSERT INTO usuarios (google_id, nombre, email, fecha_registro) VALUES (?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE nombre=?, email=?");
        $stmt->execute([$userInfoData['id'], $userInfoData['name'], $userInfoData['email'], $userInfoData['name'], $userInfoData['email']]);
        $_SESSION['user_id'] = $this->pdo->lastInsertId();
    }
}
?>
