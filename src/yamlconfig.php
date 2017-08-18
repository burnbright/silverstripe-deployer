<?php

namespace Deployer;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Helper for getting additional config out of deployer yaml file
 */
class Config {

	const REQUIRED = true;

	public $yaml = null;

	protected $file;

	static function loadFromYaml($file) {
		$config = new Config();
		$config->file = $file;
		try {
			$config->yaml = Yaml::parse(file_get_contents($file));
		} catch (ParseException $e) {
			printf("Unable to parse the YAML string: %s", $e->getMessage());
		}
		return $config;
	}
	
	public function get($key, $default, $required = false) {
		if (isset($this->yaml[$key])) {
			return $this->yaml[$key];
		} elseif ($required) {
			throw new \Exception("The '" . $key . "' value must be set inside " . $this->file);
		}
		return $default;
	}

}
