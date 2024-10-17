<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use UnexpectedValueException;

/**
 * Generate auth tokens
 * 
 * @param mixed $user
 * @return array
 */
function generateAuthToken($user): array
{
    $key = JWT_SECRET;

    $issuedAt   = new \DateTimeImmutable();
    $expire     = $issuedAt->modify('+60 day')->getTimestamp();  // Add 60 miniutes to expire on production
    $serverName = base_url();

    $user_id = is_object($user) ? $user->id : $user['id'];

    // echo $user_id;

    $payload = [
        'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
        'iss'  => $serverName,                       // Issuer
        'nbf'  => $issuedAt->getTimestamp(),         // Not before
        'exp'  => $expire,                           // Expire
        'user_id' =>  $user_id
    ];

    $jwt = \Firebase\JWT\JWT::encode($payload, $key, 'HS256');

    $refresh_token = hash('sha1', uniqid(md5($key .  $user_id)));

    // save fresh token behalf of user
    // $db = db_connect();

    // $db->table('users')->update([
    //     'refresh_token' => $refresh_token
    // ], ['id' =>  $user_id]);

    return [
        'access_token' => $jwt,
        'refresh_token' => $refresh_token,
        'expire_at' => $expire,
        'expire_at_string' => (new \DateTime())->setTimestamp($expire)->format('Y-m-d H:i:s')
    ];
}




/**
 * Extract auth token from request header
 * 
 * @param string $authHeader
 * @return string
 */
function getBearerToken($authHeader)
{
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        return $matches[1];
    }
}

/**
 * Set auth user
 * 
 * @return object|null
 */
function authuser()
{
    global $userData;

    return $userData;
}


/**
 * Set auth user
 * 
 * @param object $user
 */
function setAuthUser($user)
{
    global $userData;
    $userData = $user;
    // echo json_encode($userData);die;
}



function validJWT()
{

    // $header = $->getHeader("Authorization");
    $CI = &get_instance();

    $header = $CI->input->request_headers('Authorization');

    // echo json_encode($header['authorization']);

    // die;

    if (isset($header['Authorization'])) {
        $bearerTokenHeader = $header['Authorization'];
    } else if ($header['authorization']) {
        $bearerTokenHeader = $header['authorization'];
    } else if (isset($_SERVER['Authorization'])) {
        $bearerTokenHeader = $_SERVER['Authorization'];
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $bearerTokenHeader = $_SERVER['HTTP_AUTHORIZATION'];
    } else {
        $bearerTokenHeader = '';
    }

    if (is_null($bearerTokenHeader)) {
        header('Content-Type:application/json');
        http_response_code(401);
        echo json_encode([
            'message' => 'authentication required',
        ]);
        die;
    }

    $token = getBearerToken($bearerTokenHeader);

    if (is_null($token)) {
        header('Content-Type:application/json');
        http_response_code(401);
        echo json_encode([
            'status' => false,
            'message' => 'authentication required',
            'type' => 'jwt'
        ]);
        die;
    }

    $jwtToken = $token;

    try {
        $tokenData = JWT::decode($jwtToken, new Key(JWT_SECRET, 'HS256'));
    } catch (\Firebase\JWT\ExpiredException | UnexpectedValueException $e) {
        header('Content-Type:application/json');
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'message' => $e->getMessage(),
            'type' => 'jwt'
        ]);
        die;
    }

    $user_id = $tokenData->user_id;

    // echo $user_id;
    // die;

    $CI = &get_instance();

    $CI->load->database();

    $query = $CI->db->get_where('users', ['id' => $user_id]);
    $user = $query->row_array();

    // print_r($user);
    // die;

    if (!is_null($user)) {
        setAuthUser($user);
    }

    return true;
}



function dev_log($data, $log_file_name = 'log.txt')
{
    $log_dir = __DIR__ . DIRECTORY_SEPARATOR . $log_file_name;
    $fp = fopen($log_dir, 'a');
    fwrite($fp, var_export($data, true));
    fwrite($fp, PHP_EOL);
    fclose($fp);
}
