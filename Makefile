PHPUNIT=vendor/bin/phpunit
README_TESTER=vendor/bin/readme-tester
PHPSTAN=vendor/bin/phpstan
PHPCS=vendor/bin/phpcs

COMPOSER_CMD=composer

.DEFAULT_GOAL=all

.PHONY: all clean

all: test analyze

clean:
	rm composer.lock
	rm -rf vendor
	rm -rf vendor-bin

.PHONY: test analyze phpunit examples phpstan phpcs

test: phpunit examples

phpunit: vendor-bin/installed
	$(PHPUNIT)

examples: vendor-bin/installed
	$(README_TESTER) README.md

analyze: phpstan phpcs

phpstan: vendor-bin/installed
	$(PHPSTAN) analyze -l 7 src

phpcs: vendor-bin/installed
	$(PHPCS)

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

vendor-bin/installed: vendor/installed
	$(COMPOSER_CMD) bin phpunit require phpunit/phpunit:^7
	$(COMPOSER_CMD) bin readme-tester require hanneskod/readme-tester:^1.0@beta
	$(COMPOSER_CMD) bin phpstan require "phpstan/phpstan:<2"
	$(COMPOSER_CMD) bin phpcs require squizlabs/php_codesniffer:^3
	touch $@
