<?php

namespace Deployer;

desc('Say hello to the world!');
task('helloworld', function () {
    writeln('Hello world!');
})->local();