# Deployer recipe for SilverStripe websites

Opinionated recipe for deploying SilverStripe projects via Deployer.

https://deployer.org

## Goals

* Simple to install.
* Configure using yaml and ENV variables.
* Build locally and transfer output onto server.
* Deploy from CI/CD or local environment.
* Share tasks across projects, but not config.
* Keep secrets secret.
* Extensible. You can customise deploy.php.
* Multiple projects/domains/stages per host.

## Opinions

 * Defaults to 'staging' for deploys etc
 * Assumes key-based SSH authentication is configured for each host.
 * Deploys into `~/deploy/{hostname}`. e.g.
	* `~/deploy/example.com`
	* `~/deploy/test.example.com`

## Installation and setup

Include in your project:
`composer require --dev burnbright/silverstripe-deployer`
This will add required vendor packages, and in particular the bin to run deployer: `vendor/bin/dep`.

Copy the deploy.php template to your project root:
`cp vendor/burnbright/silverstripe-deployer/templates/deploy.php deploy.php`

Modify your `deploy.php` file to suit your project.

Add `.silverstripe-deployer` to your gitignore.

### Simplify vendor commands

To avoid needing to type `vendor/bin/dep`, update your PATH to search the local vendor/bin folder:
```
export PATH=$PATH:./vendor/bin
```
Then you only need to type `dep` from the root of your project.

## Usage

(Assumes you've added ./vendor/bin to your PATH, otherwise use `vendor/bin/dep`)

 * `dep` - will list available commands.
 * `dep deploy` - defaults to deploying to 'staging'.
 * `dep deploy production` - deploy to 'production'.
 * `dep ssh` - ssh into a host.

## Influences

* https://www.silverstripe.org/blog/making-deployment-a-piece-of-cake-with-deployer
* https://gist.github.com/bummzack/b9e4a3ef0d16ab303aab66a779f92c6e
* https://gist.github.com/lerni/26bd8ce1861ed563fb5731236f6baf46
* https://github.com/dnadesign/shipistrano