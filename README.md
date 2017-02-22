# It's a Dog! Documentation
It's a Dog is a website where user's can create one or more doggy gift registries, and enter a 
sweepstakes to win prizes.

## Developer Quick Start

  * Setup your Dev Environment with [MAMP on Windows](https://app.tettra.co/teams/brainbytes/pages/run-mamp-pro-with-ssl-xdebug-on-windows) or [docker-compose-wordpress](https://github.com/brainbytes/docker-compose-wordpress)
  * Deploy using the [Standard Procedure for WP Engine](https://app.tettra.co/teams/brainbytes/pages/wordpress-deployment-with-wpengine)

### How this Site is Glued Together

  * Users can register [via Facebook](https://timersys.com/facebook-login/docs/) 
    or [simple username and password](https://wordpress.org/plugins/wp-register-profile-with-shortcode/)
  * Dogs are a custom post type, with input forms rendered via the 
    [Advanced Custom Fields (ACF)](https://www.advancedcustomfields.com/resources/) plug-in.
  * Available registry products are also a custom post type that pull data using the 
    AmazonProductAPI custom post type (_why is that a custom post type --james_)

TODO: How do I add a form? For example, if I were going to add the form to the `/manage-registry` page?