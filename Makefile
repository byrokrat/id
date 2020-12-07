COMPOSER_CMD=composer
PHIVE_CMD=phive

PHPUNIT_CMD=vendor/bin/phpunit
README_TESTER_CMD=tools/readme-tester
PHPSTAN_CMD=tools/phpstan
PHPCS_CMD=tools/phpcs

.DEFAULT_GOAL=all

.PHONY: all
all: test analyze

.PHONY: clean
clean:
	rm -f composer.lock
	rm -rf vendor
	rm -rf tools

.PHONY: test
test: phpunit examples

.PHONY: phpunit
phpunit: vendor/installed $(PHPUNIT_CMD)
	$(PHPUNIT_CMD)

.PHONY: examples
examples: vendor/installed $(README_TESTER_CMD)
	$(README_TESTER_CMD) README.md

.PHONY: analyze
analyze: phpstan phpcs

.PHONY: phpstan
phpstan: vendor/installed $(PHPSTAN_CMD)
	$(PHPSTAN_CMD) analyze -l 8 src

.PHONY: phpcs
phpcs: $(PHPCS_CMD)
	$(PHPCS_CMD) src tests --standard=PSR2

composer.lock: composer.json
	@echo composer.lock is not up to date

vendor/installed: composer.lock
	$(COMPOSER_CMD) install
	touch $@

$(PHPUNIT_CMD): vendor/installed

tools/installed:
	$(PHIVE_CMD) install --force-accept-unsigned
	touch $@

$(README_TESTER_CMD): tools/installed

$(PHPSTAN_CMD): tools/installed

$(PHPCS_CMD): tools/installed
