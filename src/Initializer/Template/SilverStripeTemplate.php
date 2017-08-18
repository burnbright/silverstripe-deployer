<?php

namespace Deployer\Initializer\Template;

class SilverStripeTemplate extends Template
{

    protected function getTemplateContent($params)
    {
        $stats = $params['allow_anonymous_stats']
            ? ''
            : "set('allow_anonymous_stats', false);";

        $repository = $params['repository'];
        
        return <<<PHP
<?php
namespace Deployer;

require 'recipe/silverstripe-deployer.php';

// Configuration
set('repository', '${repository}');

// Hosts
host('example.com')
//  ->set('user', 'SSHUSERNAME')
    ->stage('production');

host('staging.example.com')
//  ->set('user', 'SSHUSERNAME')
    ->stage('staging');

${stats}
PHP;
    }

}
