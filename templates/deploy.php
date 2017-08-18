<?php
namespace Deployer;

require 'recipe/silverstripe-deployer.php';

// Configuration
set('repository', 'GIREPOSITORY');

// Hosts
host('example.com')
    ->set('user', 'SSHUSERNAME')
    ->stage('production');

host('staging.example.com')
    ->stage('staging');
