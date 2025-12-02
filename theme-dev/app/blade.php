<?php

use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

$viewsPath = __DIR__ . '/../source/views';
$cachePath = __DIR__ . '/../storage/cache/views';

$filesystem = new Filesystem;
$viewFinder = new FileViewFinder($filesystem, [$viewsPath]);
$dispatcher = new Dispatcher;

$engineResolver = new EngineResolver;

$engineResolver->register('blade', function () use ($filesystem, $cachePath) {
    return new \Illuminate\View\Engines\CompilerEngine(
        new \Illuminate\View\Compilers\BladeCompiler($filesystem, $cachePath)
    );
});

$app['view'] = new Factory(
    $engineResolver,
    $viewFinder,
    $dispatcher
);

$app['view']->addExtension('blade.php', 'blade');


function blade($template, $data = [])
{   
    global $app;
    return $app['view']->make($template, $data)->render();
}
