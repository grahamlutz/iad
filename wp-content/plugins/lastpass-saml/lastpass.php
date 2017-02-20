<?php
// vim: ts=4 sw=4 expandtab:
/*
Author: LastPass
Author URI: https://lastpass.com
Plugin Name: LastPass SAML connector
Plugin URI: https://lastpass.com/
Automatic login to WordPress if you're logged into your LastPass Enterprise account.
Version: 1.0.0
Thanks: xmlseclibs.php (included)
*/

require_once( ABSPATH . '/wp-includes/pluggable.php');
require_once(dirname(__FILE__).'/php/lastpass_lib.php');

$saml_cert = get_option('lastpass_saml_certificate');
$login_url = get_option('lastpass_login_url');
$is_configured = !empty($saml_cert) and !empty($login_url);

// we only want to really push if the saml_cert is installed.
if($is_configured) {
    add_action('lost_password', 'lastpass_lost_password');
    add_action('retrieve_password', 'lastpass_lost_password');
    add_action('password_reset', 'lastpass_lost_password');
    add_action('wp_logout', 'lastpass_logout');
}

function lastpass_lost_password() {
    header("Location: https://lastpass.com/forgot.php");
    exit;
}

function lastpass_logout() {
    wp_clear_auth_cookie();
    $url = get_option('lastpass_logout_url');
    if(!empty($url)) {
        header("Location: $url");
    } else {
        print "You have been logged out of WordPress but not your SAML provider.";
    }
    exit;
}

if (!empty($_POST["SAMLResponse"])) {
    add_action('init','lastpass_saml');
} else {
    // we only want to really push bouncing to LastPass if fully setup.
    if(!empty($_GET['nolastpass'])) {
        setcookie('nolastpass',1);
    }

    if($is_configured && empty($_GET['nolastpass']) && empty($_COOKIE['nolastpass'])) {
        if (empty($_SERVER['HTTP_REFERER']) OR !preg_match("/nolastpass/", $_SERVER['HTTP_REFERER'])) {
            #error_log("LastPass SAML - NO SAMLRESPONSE seen -- pushing authn");
            add_action('wp_authenticate', 'lastpass_authenticate', 50, 2); // priortiy high to hopefully not override something else, and 2 arguments to lpauth
            function lastpass_authenticate(&$username, &$password) {
                lp_AuthnRequest();
                exit;
            }
        }
    }
}

function lastpass_saml() {
    #error_log("LastPass SAML - Checking SAMLResponse!");
    $email = lp_saml_auth($_POST["SAMLResponse"]);
    $username = preg_replace("/@.*/", "", $email);

    if(empty($username)) {
        error_log("LastPass SAML: SAMLReponse check failed -- is your certificate correct?");
        exit;
    }

    $user_id = email_exists($email);

    // second try with just the first part of the username if it's an email.
    if(!$user_id AND $email != $username) {
        $user_id = username_exists($username);
    }
    if (!$user_id) {
        $user_id = lastpass_create_wp_account($email,$username);
    }

    if (!$user_id)
        exit;

    // userdata will contain all information about the user
    $userdata = get_userdata($user_id);
    $user = set_current_user($user_id,$username);
    wp_set_auth_cookie($user_id);
    do_action('wp_login',$userdata->ID);
    error_log("Login worked as $email -- sending to profile page.");
    header("Location:".get_page_link(MY_PROFILE_PAGE));
    exit;
}

function lastpass_create_wp_account($email,$username) {
    $create_users = get_option('lastpass_create_users');
    if(empty($create_users) or !$create_users) {
        //error_log("LastPass SAML - $username -- failure user doesn't exist?  Create?");
        print "<b>".esc_html($email) . "</b> is not a valid email, <b>".esc_html($username) . "</b> is not a valid username and provisioning is disabled!<br/><br/>Ask your administrator to enable automatic provisioning in WordPress by going to <a href='".get_site_url()."/wp-admin/' target='_blank'>".get_site_url()."/wp-admin/</a> Select Settings -&gt; LastPass SAML Settings -&gt; Enable Automatic Provisioning <br/><br/>".
            "Alternatively the administrator can to create you an account manually in the <a href='".get_site_url()."' target='_blank'>".get_site_url()."/wp-admin/</a> User tool, using your email: ".esc_html($email). ".  When creating you can make up a bogus password as it will not be used.";
        exit;
    }
    error_log("LastPass SAML: Creating account: email: $email Username: $username");
    if(!preg_match("/@/", $email)) {
        print "FATAL LastPass SAML provisioning failure -- email passed as:<br/><b>". of($email). "</b><br/> is not a fully qualified email address -- it lacks @!";
        exit;
    }
    $role = get_option('lastpass_role');
    wp_insert_user(array( 'user_login'=> $username."", 'user_pass' => uniqid(true), 'user_email'=>$email, 'role'=>$role ));
    return email_exists($email);
}

/////// Add a link on the plugin's page to the settings page.

add_filter('plugin_action_links', 'lastpass_action_links', 10, 2); // add settings in plugin page
function lastpass_action_links($urls, $file) {
    //error_log('action links:' .plugin_basename(__FILE__) . " "  . $file);
    if (basename(__FILE__) == basename($file)) { // would catch anything named lastpass.php but hopefully that's safe.
        $extra="";
        global $is_configured;
        if(!$is_configured) {
            $extra .= " [ WARNING not setup ] ";
        }
        $url = '<a href="options-general.php?page=lastpass_samlconfig">Settings'.$extra.'</a>';
        array_unshift($urls, $url);
    }
    return $urls;
}

///////  Add a settings menu.

add_action('admin_menu', 'lastpass_menu');

function lastpass_menu() {
    require_once(dirname(__FILE__).'/php/settings.php');
    lastpass_saml_config();
}
