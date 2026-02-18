<?php

use Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/
$app = Application::configure(basePath: dirname(__DIR__))->create();

return $app;
