<?php
// Verify the token
if (isset($_POST['token'])) {
    $token = $_POST['token'];

    // Make a POST request to Cloudflare's API to verify the token
    $verification_endpoint = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $verification_data = array(
        'token' => $token,
        'secret' => CF_TURNSTILE_SECRET_KEY,
    );

    // Send the POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $verification_endpoint);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($verification_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Return the verification response
    echo $response;
} else {
    echo json_encode(array('success' => false, 'error' => 'Token not found'));
}