<?php

namespace Deployer;

// required recipes
require 'recipe/composer.php';

// config
set('repository', 'UNDEFINED');

set('default_stage', 'staging');

// prod = 5 releases, stage = 1 release
set('keep_releases', function () {
	$stagenames = array('test', 'stage', 'staging');
	return (in_array(get('stage'), $stagenames)) ? 1 : 5;
});

set('ssh_type', 'native');
set('ssh_multiplexing', true);

set('deploy_base', '~/deploy');
set('deploy_path', '{{deploy_base}}/{{hostname}}/');
set('rsync_dest','{{release_path}}');

// tasks
require 'tasks/project.php';
require 'tasks/localbuild.php';
require 'tasks/silverstripe.php';
require 'tasks/silverstripe.env.php';

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
