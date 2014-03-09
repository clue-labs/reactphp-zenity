<?php

use React\EventLoop\Factory;
use Clue\Zenity\React\Launcher;
use Clue\Zenity\React\Dialog\FileSelection;
use Clue\Zenity\React\Builder;

require __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$launcher = new Launcher($loop);
$builder = new Builder($launcher);

$progress = $builder->progress('Pseudo-processing...')->launch();

$progress->setPercentage(50);

$timer = $loop->addPeriodicTimer(0.2, function () use ($progress) {
    $progress->advance(mt_rand(-1, 3));
});

$progress->then(function () use ($timer, $builder) {
    $timer->cancel();

    $builder->info('Done')->launch();
});

$progress->then(null, function() use ($timer) {
    $timer->cancel();
});

$loop->run();
