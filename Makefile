vendor: $(wildcard composer.lock)
	@composer self-update -q
	@composer validate --strict -q
	@composer check-platform-reqs -q
	@composer install -o --no-dev

dist:
	@mkdir dist

box.phar:
	@curl -LSs https://box-project.github.io/box2/installer.php | php

dist/version: $(wildcard .git/index) dist
	@git describe --exact-match --tags HEAD > dist/version

dist/zc.phar: dist vendor box.json box.phar dist/version
	@php -d phar.readonly=0 box.phar build

