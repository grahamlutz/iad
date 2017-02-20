=== LastPass SAML Single Sign-On ===
Tags: saml, lastpass, last pass, password, sso, single sign-on, single sign on, single, sign-on, authorization, authentication
Requires at least: 3.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The LastPass SAML plugin allows your LastPass Enterprise account to automatically create accounts and login to your Wordpress installation. 

== Description ==

The LastPass SAML Single Sign-On plugin allows your LastPass Enterprise account to automatically create accounts and login to each of your Wordpress installations.   

Within you LastPass Enterprise account you can specify groups, individual users or that all users should be authorized to login and to have accounts created.

LastPass accounts can be created/disabled via API, Active Directory or via the LastPass.com website. 

== Installation ==

To install 

1. Unzip LastPass-Wordpress-plugin.zip to the `/wp-content/plugins/` directory OR
   go to Plugins -> Install and utilize the upload a plugin in .zip format link.
2. Go to the Plugin Settings -> LastPass Settings and specify the URLs and SAML Certificate
3. Activate the plugin through the 'Plugins' menu in WordPress and open a different browser to test logging in!

== Frequently Asked Questions ==

= How do I use this with LastPass? =

Setup a LastPass Enterprise account, go to the SAML section and setup the Wordpress 

= Can I login utilizing the standard login after enabling this? =

Yes go to http://<YOURBLOGURL/wp-login.php?nolastpass=1

== Screenshots ==

1. This the settings screen where you enter the login, logout and SAML certificate from LastPass. 

== Changelog ==

= 1.0 =
* Initial release


== Upgrade Notice ==

= 1.0 =
Initial release

== Arbitrary section ==
