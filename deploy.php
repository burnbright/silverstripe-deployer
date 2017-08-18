<?php

namespace Deployer;

define('PROJECT_ROOT', realpath(__DIR__.'/../..'));

require 'recipe/composer.php';
require 'recipe/rsync.php';
require 'src/yamlconfig.php';

$config = Config::loadFromYaml(PROJECT_ROOT.'/deploy.yml');

// config
set('repository', $config->get('repository', null, Config::REQUIRED));
set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('keep_releases',  $config->get('keep_releases', 5));
set('default_stage', 'staging');
set('deploy_path', '~/deploy_{{stage}}');
set('rsync_dest','{{release_path}}');

inventory(PROJECT_ROOT.'/hosts.yml');

// tasks
require 'tasks/localbuild.php';
require 'tasks/silverstripe.php';

task('deploy', [
	'localbuild',
	'release',
	'cleanup',
	'success'
]);

task('release', [
	'deploy:prepare',
	'deploy:lock',
	'deploy:release',
	'localbuild:upload',
	'deploy:shared',
	'deploy:writable',
	'silverstripe:buildflush',
	'deploy:symlink',
	'deploy:unlock'
]);
