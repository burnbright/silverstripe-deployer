<?php

namespace Deployer;

define('PROJECT_ROOT', realpath(__DIR__.'/../../..'));

// required recipes
require 'recipe/composer.php';
require 'recipe/rsync.php';

// config
set('repository', 'UNDEFINED');
// prod = 5 releases, stage = 1 release
set('keep_releases', function () {
	$stagenames = array('test', 'stage', 'staging');
	return (in_array(get('stage'), $stagenames)) ? 1 : 5;
});

set('ssh_type', 'native');
set('ssh_multiplexing', true);
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

after('deploy:failed', 'deploy:unlock');