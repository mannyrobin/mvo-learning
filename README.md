# Hip Med Site

Base WordPress install for [Hip Creative](https://hip.agency) medical clients. It uses composer to manage plugins and dependencies and gulp build frontend assets.

## How to use 

1. Clone and enter repo: `git clone git@gitlab.com:hipdevteam/hip-med-site && cd hip-med-site`
2. Get submodules: `git submodules init && git submodules update`
3. Install dependencies: `composer install`
4. Create `.env` in root and populate with needed variables ( checkout `.env.example` for an example )

## Additional Notes

The project follows the directory structure of [Bedrock](https://roots.io/bedrock). Everything you'd normally put in `wp-config.php` is under `/config`. Everything you'd normally find in `/wp-content` is under `/web/app`
