<?php

use Illuminate\Container\Container;
use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;

global $app;
$app = new Container;
$app->instance(ContainerContract::class, $app);

$viewsPath = get_template_directory() . '/source/views';
$cachePath = get_template_directory() . '/storage/cache/views';

$filesystem = new Filesystem;
$viewFinder = new FileViewFinder($filesystem, [$viewsPath]);

$bladeCompiler = new BladeCompiler($filesystem, $cachePath);

$engineResolver = new EngineResolver;
$engineResolver->register('blade', fn () => new CompilerEngine($bladeCompiler));

$dispatcher = new Dispatcher($app);
$app->instance(DispatcherContract::class, $dispatcher);

$viewFactory = new Factory($engineResolver, $viewFinder, $dispatcher, $app);
$app->instance(ViewFactoryContract::class, $viewFactory);
$app['view'] = $viewFactory;
$app['view']->addExtension('blade.php', 'blade');

$componentsFolder = $viewsPath . '/components';

if (is_dir($componentsFolder)) {
    foreach (glob($componentsFolder . '/*.blade.php') as $file) {
        $name = basename($file, '.blade.php');
        $bladeCompiler->component("components.$name", $name);
    }
}

function blade($template, $data = [])
{
    global $app;
    return $app['view']->make($template, $data)->render();
}
