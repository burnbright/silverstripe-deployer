# Deployer recipe for SilverStripe websites

An opinionated wrapper around Deployer for deploying SilverStripe sites.

Goals:
 * Simple to install
 * Configure using yaml and ENV variables
 * Build local and transfer output onto server.
 * Deploy from CI/CD or local environment.
 * Share tasks accross projects, but not config.
 * Keep secrets secret.
 * Extensible

# Install

Include in your project:
`compsoer require --dev burnbright/silverstripe-deployer`

# Init

This command will create a deploy.yml file in your project root:
`vendor/bin/ssdep init`

## PRO Tip

To avoid needing to type `vendor/bin/ssdep`, update your PATH to search the local vendor/bin folder:
```
export PATH=$PATH:./vendor/bin
```
Then you only need to type `ssdep` from the root of your project.

# Usage

`vendor/bin/ssdep deploy staging`

# Sources

https://deployer.org
https://www.silverstripe.org/blog/making-deployment-a-piece-of-cake-with-deployer/
https://gist.github.com/bummzack/b9e4a3ef0d16ab303aab66a779f92c6e
https://gist.github.com/lerni/26bd8ce1861ed563fb5731236f6baf46
