<?php

namespace Deployer;

set('local_build_path', PROJECT_ROOT.'/.silverstripe-deployer');

desc('Perform a deploy locally for upload to server.');
task('localbuild', function () {
	set('deploy_path', '{{local_build_path}}');
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
	upload('{{local_build_path}}/current/', '{{release_path}}');
});