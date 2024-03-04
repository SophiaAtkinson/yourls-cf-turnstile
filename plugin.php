<?php
/*
Plugin Name: Cloudflare Turnstile for YOURLS Admin
Plugin URI: https://github.com/sophiaatkinson/yourls-cloudflare-turnstile
Description: Adds Cloudflare Turnstile to the YOURLS Admin login.
Version: 1.0
Author: Sophia Atkinson
Author URI: https://sophia.wtf
*/

// Define Cloudflare Turnstile Site Key | Can be found here :) https://dash.cloudflare.com/?to=/:account/turnstile
if (!defined('CF_TURNSTILE_SITE_KEY')) {
    define('CF_TURNSTILE_SITE_KEY', 'YOUR_CF_TURNSTILE_SITE_KEY');
}

// Define Cloudflare Turnstile Secret Key | Can be found here :) https://dash.cloudflare.com/?to=/:account/turnstile
if (!defined('CF_TURNSTILE_SECRET_KEY')) {
    define('CF_TURNSTILE_SECRET_KEY', 'YOUR_CF_TURNSTILE_SECRET_KEY');
}

// Cloudflare Turnstile script to the head section of the HTML file
yourls_add_action('html_head', 'cf_turnstile_html_head');
function cf_turnstile_html_head() {
    echo '<script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit"></script>';
}

// Cloudflare Turnstile widget to the YOURLS admin login form
yourls_add_action('login_form_bottom', 'cf_turnstile_login_form');
function cf_turnstile_login_form() {
    echo '<div id="cf-turnstile-container"></div>';
    echo '<input type="hidden" name="cf_token" id="cfTokenInput">';
}

// Initialize Cloudflare Turnstile widget
yourls_add_action('login_form_end', 'cf_turnstile_inject_script');
function cf_turnstile_inject_script() {
    echo '<script>
        turnstile.ready(function() {
            turnstile.render(\'#cf-turnstile-container\', {
                sitekey: \'' . CF_TURNSTILE_SITE_KEY . '\',
                callback: function(token) {
                    document.getElementById(\'cfTokenInput\').value = token;
                    // Send the token to the verification script
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "' . yourls_plugin_url('cf_turnstile_verify.php') . '", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            var response = JSON.parse(xhr.responseText);
                            if (response && response.success) {
                                // Verification succeeded, proceed with form submission
                                document.getElementById("login").submit();
                            } else {
                                // Verification failed, display error message
                                alert("Cloudflare Turnstile verification failed. Please try again.");
                            }
                        }
                    };
                    xhr.send("token=" + token);
                }
            });
        });
    </script>';
}
