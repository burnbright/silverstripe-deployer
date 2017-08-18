<?php

namespace Deployer;

set('shared_dirs', [
	'assets'
]);

task('silverstripe:build', function () {
	return run('{{bin/php}} {{release_path}}/framework/cli-script.php /dev/build');
})->desc('Run /dev/build');

task('silverstripe:buildflush', function () {
	return run('{{bin/php}} {{release_path}}/framework/cli-script.php /dev/build flush=all');
})->desc('Run /dev/build?flush=all');
