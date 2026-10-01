<?php
return ['default'=>env('CACHE_STORE','file'),'stores'=>['file'=>['driver'=>'file','path'=>storage_path('framework/cache/data')]],'prefix'=>env('CACHE_PREFIX',strtolower(env('APP_NAME','laravel')).'-cache-')];
