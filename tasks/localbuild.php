<?php

namespace Deployer;

/**
 * Builds to a local folder
 * @see https://deployer.org/docs/advanced/deploy-strategies#build-server
 */

set('local_build_path', '{{project_path}}/.silverstripe-deployer');

desc('Perform a deploy locally for upload to server.');
task('localbuild', function () {
	set('deploy_path', '{{local_build_path}}');
	set('keep_releases', 1);
	invoke('deploy:writable');
	invoke('deploy:prepare');
	invoke('deploy:release');
	invoke('deploy:update_code');
	invoke('deploy:vendors');
	invoke('deploy:symlink');
	invoke('cleanup');
})->local();

task('localbuild:upload', function () {
	upload('{{local_build_path}}/current/', '{{release_path}}', array(
		'options' => array(
			'--exclude=\'.git/\'',
			'--exclude=\'assets/\'',
			'--exclude=\'silverstripe-cache/\''
		)
	));
});
