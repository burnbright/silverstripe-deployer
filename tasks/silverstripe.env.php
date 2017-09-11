<?php

namespace Deployer;

desc('Generate _ss_environment.php file and upload to host');
task('silverstripe:env', function () {
	writeln('Configuring _ss_environment.php');

	$output = '<?php';
	
	if($ss_environment_type = askChoice('Environment type:',
		array('dev' => 'dev', 'test' => 'test', 'live' => 'live'), 'test'
	)) {
		$output .= "\ndefine(\"SS_ENVIRONMENT_TYPE\",\"${ss_environment_type}\");";
	}

	if($ss_database_server = ask('Database host:', 'localhost')){
		$output .= "\ndefine(\"SS_DATABASE_SERVER\",\"${ss_database_server}\");";
	}
	if($ss_database_username = ask('Database username:')) {
		$output .= "\ndefine(\"SS_DATABASE_USERNAME\",\"${ss_database_username}\");";
	}
	if($ss_database_password = askHiddenResponse('Database password:')) {
		$output .= "\ndefine(\"SS_DATABASE_PASSWORD\",\"${ss_database_password}\");";
	}

	if($ss_database_name = ask('Database name:')) {
		$output .= "\ndefine(\"SS_DATABASE_NAME\",\"${ss_database_name}\");";
	}
	if($ss_default_admin_username = ask('CMS default admin username:', 'cmsadmin')) {
		$output .= "\ndefine(\"SS_DEFAULT_ADMIN_USERNAME\",\"${ss_default_admin_username}\");";
	}
	if ($ss_default_admin_username) {
		if($ss_default_admin_password = askHiddenResponse('CMS default admin password:')) {
			$output .= "\ndefine(\"SS_DEFAULT_ADMIN_PASSWORD\",\"${ss_default_admin_password}\");";
		}
	}
	if($ss_error_log = ask('Error log path:')) {
		$output .= "\ndefine(\"SS_ERROR_LOG\",\"${ss_error_log}\");";
	}
	if($ss_error_email = ask('Error email:')) {
		$output .= "\ndefine(\"SS_ERROR_EMAIL\",\"${ss_error_email}\");";
	}
	if($ss_use_basic_auth = askChoice('Use basic authentication (password protect site):',
		array('yes' => 'yes', 'no' => 'no'), 'no'
	)) {
		if($ss_use_basic_auth === "yes"){
			$output .= "\ndefine(\"SS_USE_BASIC_AUTH\", true)";
		}
	}

	writeln('Resulting environment file:');
	writeln('---------------------------');
	writeln($output);

	$doupload = askConfirmation('Upload to server?');

	if ($doupload) {
		$tempfile = tempnam(sys_get_temp_dir(), '_ss_environment.php.remotedeploy');
		if(file_put_contents($tempfile, $output)){
			upload($tempfile, '{{deploy_path}}/_ss_environment.php');
			unlink($tempfile);
		} else {
			writeln('Failed to write temp file: '.$tempfile);
		}
	}

});

before('silverstripe:env', 'deploy:prepare');