<?php

namespace Deployer;

define('LOCAL_BUILD_PATH', PROJECT_ROOT.'/.silverstripe-deployer');

function buildPath() {
	return LOCAL_BUILD_PATH;
}

desc('Perform a deploy locally for upload to server.');
task('localbuild', function () {
	set('deploy_path', buildPath());
	set('keep_releases', 1);
	invoke('deploy:writable');
	invoke('deploy:prepare');
	invoke('deploy:release');
	invoke('deploy:update_code');
	invoke('deploy:vendors');
	// Add more build steps here
	invoke('deploy:symlink');
	invoke('cleanup'); // remove extra releases
})->local();

task('localbuild:upload', function () {
	upload(buildPath() . '/current/', '{{release_path}}');
});