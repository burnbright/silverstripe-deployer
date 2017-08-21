<?php

namespace Deployer;

/**
 * Tasks for project in local working directory.
 */

set('project_path', realpath(__DIR__.'/../../..'));

desc('Upload files from gitlab project to remote release path');
task('project:build', function () {
	set('release_path', '{{project_path}}');
	writeln("Assuming project path is in a deployable state.");
})->local();

desc('Upload files from gitlab project to remote release path');
task('project:upload', function () {
	upload('{{project_path}}/', '{{release_path}}', array(
		'options' => "-azP --exclude='.git/' --exclude='assets/'"
	));
});
