ZC=$(or $(wildcard dist/zc.phar), bin/zc)

vendor: $(wildcard composer.lock)
	@composer self-update -q
	@composer validate --strict -q
	@composer check-platform-reqs -q
	@composer install -o --no-dev

vendor/bin/grumphp:
	@composer self-update -q
	@composer validate --strict -q
	@composer check-platform-reqs -q
	@composer install -o

vendor/bin/phpunit: vendor/bin/grumphp
.git/hooks/pre-commit: vendor/bin/grumphp
.git/hooks/commit-msg: vendor/bin/grumphp

test: vendor/bin/grumphp
	@vendor/bin/grumphp run

test-reports/coverage.xml: vendor/bin/phpunit
	@vendor/bin/phpunit --coverage-clover=./test-reports/coverage.xml

codecov: test-reports/coverage.xml
	@curl -LSs https://codecov.io/bash | bash

dist:
	@mkdir dist

box.phar: box.json
	@curl -LSs https://box-project.github.io/box2/installer.php | php

dist/version: $(wildcard .git/index) dist
	@git tag | tail -n -1 > dist/version

dist/zc.phar: dist vendor box.phar dist/version
	@php box.phar validate
	@php -d phar.readonly=0 box.phar build

dist/zc-$${BITBUCKET_TAG}.phar: dist/zc.phar
	@cp dist/zc.phar dist/zc-$${BITBUCKET_TAG}.phar

verify: dist/zc.phar application-test
	@php box.phar verify dist/zc.phar

distribution: dist/zc-$${BITBUCKET_TAG}.phar verify
	@for phar in dist/*.phar; do \
		curl -X POST --user "$${BUILD_AUTH}" \
		"https://api.bitbucket.org/2.0/repositories/$${BITBUCKET_REPO_OWNER}/$${BITBUCKET_REPO_SLUG}/downloads" \
		--form files=@"$${phar}"; \
		done;

composer.json.gz: composer.json
	@gzip -k composer.json

application-test: composer.json.gz bitbucket-pipelines.yml
	$(ZC) --version | grep version
	$(ZC) --help | grep PATTERN
	$(ZC) string:contains zero-config/cli composer.json
	$(ZC) pcre:match '#zero-config/cli#' composer.json
	$(ZC) pcre:replace '#zero-config/(cli)#' 'coke-zero/$$1' composer.json | grep coke-zero/cli
	$(ZC) pcre:match+replace '#zero-config/(cli)#' 'coke-zero/$$1' composer.json
	$(ZC) pcre:match '#zero-config/cli#' composer.json.gz
	$(ZC) string:contains '/testing-suite"' composer.json bitbucket-pipelines.yml
	cat composer.json | $(ZC) string:contains zero-config/cli
	cat composer.json | $(ZC) string:contains zero-config/cli - bitbucket-pipelines.yml

clean:
	@rm -rf dist
	@rm -rf test-reports
	@rm -f composer.json.gz
