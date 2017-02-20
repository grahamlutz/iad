<?php

define('WP_ADMIN', true);

function lastpass_saml_config() {
    $current_screen = add_submenu_page('options-general.php','LastPass SAML Settings', 'LastPass SAML Settings', 'manage_options', 'lastpass_samlconfig', 'lastpass_samlconfig_html');

    add_settings_section('lp_section', 'Setup LastPass SAML Login', '', 'lastpass_samlconfig');

    add_settings_field('lastpass_create_users', 'Automatically create users from LastPass when they attempt to login?', 'lp_create_users_html', 'lastpass_samlconfig', 'lp_section');
    register_setting('lastpass_samlconfig','lastpass_create_users');

    add_settings_field('lastpass_role', 'Role for created users', 'lp_new_user_role', 'lastpass_samlconfig', 'lp_section');
    register_setting('lastpass_samlconfig','lastpass_role');

    add_settings_field('lastpass_login_url', 'SAML Login URL', 'lp_login_url_html', 'lastpass_samlconfig', 'lp_section');
    register_setting('lastpass_samlconfig','lastpass_login_url');

    add_settings_field('lastpass_logout_url', 'SAML Logout URL', 'lp_logout_url_html', 'lastpass_samlconfig', 'lp_section');
    register_setting('lastpass_samlconfig','lastpass_logout_url');

    add_settings_field('lastpass_saml_certificate', 'LastPass SAML Certificate', 'saml_cert_html', 'lastpass_samlconfig', 'lp_section');
    register_setting('lastpass_samlconfig','lastpass_saml_certificate');

    add_contextual_help($current_screen,
        '<p>' . __('Use LastPass to login into WordPress without a password!') . '</p>' .
        '<p>' . __('<a href="https://lastpass.com/" target="_blank">LastPass</a>') . '</p>');
}

function lastpass_samlconfig_html() {
    ?>
    <h2>LastPass SAML Settings</h2><br/>
    <?php plugin_section_html() ?><br/>
    <form action="options.php" method="post">
        <?php settings_fields('lastpass_samlconfig'); ?>
        <?php do_settings_sections('lastpass_samlconfig'); ?>
        <p class="submit"><input type="submit" name="Submit" class="button-primary" value="Save Changes"/></p>
    </form>
    <?php
}

function saml_cert_html() {
    print '<textarea style="width:600px; height:440px;" name="lastpass_saml_certificate" id="lastpass_saml_certificate">';
    print get_option('lastpass_saml_certificate');
    print '</textarea>';
}

function lp_new_user_role() {
    print  '<select name="lastpass_role" id="lastpass_role">';
    $esc_role = esc_attr(get_option('lastpass_role'));
    if(!empty($esc_role))
      print "<option value='$esc_role'>$esc_role</option>\n";

    wp_dropdown_roles(); 
    print '            </select>';
}

function lp_create_users_html() {
    $input = '<input name="lastpass_create_users" id="lastpass_create_users" type="checkbox" value="1" ' . (get_option('lastpass_create_users') ? "checked='checked'" : "") . " >";
    print $input;
}

function lp_login_url_html() {
    print '<input style="width:590px;" name="lastpass_login_url" id="lastpass_login_url" type="input" value="' . esc_attr(get_option('lastpass_login_url')) . '"/>';
}

function lp_logout_url_html() {
    print '<input style="width:590px;" name="lastpass_logout_url" id="lastpass_logout_url" type="input" value="' . esc_attr(get_option('lastpass_logout_url')) . '"/>';
}

function plugin_section_html() {
   print "Your Entity ID is: <b>LastPass:WordPress:".get_site_url()."</b><br/>";
   print "Your Launch URL is : <b>".get_site_url()."/wp-admin/</b><br/>";
   print 'To get your LastPass SAML Certificate and setup your login on the LastPass site go here <a href="https://lastpass.com/enterprise_saml.php?service=wordpress" target="_blank">here</a><br/><br/>';
   print "To login without LastPass (e.g. for external users that do not have LastPass accounts, or for emergency purposes) once activated you go to <b><a href='".get_site_url()."/wp-login.php?nolastpass=1' target='_blank'>".get_site_url()."/wp-login.php?nolastpass=1</a></b><br/>";
}

