<?php

namespace Bob\BuildConfig;

task('default', ['test', 'phpstan', 'sniff']);

desc('Run all tests');
task('test', ['phpunit', 'examples']);

desc('Run phpunit tests');
task('phpunit', function() {
    sh('phpunit', null, ['failOnError' => true]);
    println('Phpunit tests passed');
});

desc('Test examples');
task('examples', function() {
    sh('readme-tester README.md', null, ['failOnError' => true]);
    println('Examples passed');
});

desc('Run statical analysis using phpstan');
task('phpstan', function() {
    sh('phpstan analyze -l 7 src', null, ['failOnError' => false]);
    #sh('phpstan analyze -c phpstan.neon -l 7 src', null, ['failOnError' => false]);
    println('Phpstan analysis passed');
});

desc('Run php code sniffer');
task('sniff', function() {
    sh('phpcs', null, ['failOnError' => false]);
    println('Syntax checker passed');
});

desc('Globally install development tools');
task('install_dev_tools', function() {
    sh('composer global require consolidation/cgr', null, ['failOnError' => true]);
    sh('cgr phpstan/phpstan', null, ['failOnError' => true]);
    sh('cgr phpunit/phpunit', null, ['failOnError' => true]);
    sh('cgr squizlabs/php_codesniffer', null, ['failOnError' => true]);
    sh('cgr hanneskod/readme-tester:^1.0@beta', null, ['failOnError' => true]);
});
