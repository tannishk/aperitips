<?php

/**
 * @file
 * Set parameters from Platform.sh environment variables.
 */

// Configure the database.
if (isset($_ENV['PLATFORM_RELATIONSHIPS'])) {
    $relationships = json_decode(base64_decode($_ENV['PLATFORM_RELATIONSHIPS']), true);

    foreach ($relationships['database'] as $endpoint) {
        if (!empty($endpoint['query']['is_master'])) {
            $container->setParameter('database_driver', 'pdo_' . $endpoint['scheme']);
            $container->setParameter('database_host', $endpoint['host']);
            $container->setParameter('database_port', $endpoint['port']);
            $container->setParameter('database_name', $endpoint['path']);
            $container->setParameter('database_user', $endpoint['username']);
            $container->setParameter('database_password', $endpoint['password']);
            $container->setParameter('database_path', '');
            break;
        }
    }
}

// Set a default unique secret, based on a project-specific entropy value.
if (isset($_ENV['PLATFORM_PROJECT_ENTROPY'])) {
    $container->setParameter('kernel.secret', $_ENV['PLATFORM_PROJECT_ENTROPY']);
}

if (isset($_ENV['PLATFORM_VARIABLES'])) {
    $variables = json_decode(base64_decode($_ENV['PLATFORM_VARIABLES']), true);

    // Global configuration
    if (isset($variables['config'])) {

        // Okta configuration
        if (isset($variables['config']['okta'])) {
            $container->setParameter('okta_idp', $variables['config']['okta']['idp']);
            $container->setParameter('okta_token', $variables['config']['okta']['token']);
            $container->setParameter('okta_domain', $variables['config']['okta']['domain']);
        }
    }
}

# Store session into /tmp.
ini_set('session.save_path', '/tmp/sessions');