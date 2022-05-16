.PHONY: help
help: ## Shows this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\.]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: init
init: composer-install-app composer-install-dev-ops ## Install composer dependencies

.PHONY: update
update: composer-update-app composer-update-dev-ops ## Update composer dependencies

.PHONY: composer-install-app
composer-install-app:
	composer install

.PHONY: composer-update-app
composer-update-app:
	composer update

.PHONY: composer-install-dev-ops
composer-install-dev-ops:
	composer install -d ./dev-ops/ci

.PHONY: composer-update-dev-ops
composer-update-dev-ops:
	composer update -d ./dev-ops/ci

.PHONY: cs-fix
cs-fix: ## Run php-cs-fixer
	php dev-ops/ci/vendor/bin/php-cs-fixer fix --config dev-ops/ci/config/.php-cs-fixer.dist.php

.PHONY: phpunit
phpunit: ## Run phpunit with coverage
	php bin/phpunit --configuration dev-ops/ci/config/phpunit.xml.dist

.PHONY: tests
tests: cs-fix phpunit ## Run all tests
