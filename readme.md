<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>


# Maestriam\Samurai 🔴

## About 

**Maestriam\Samurai** is a simple package for creating and managing themes for Laravel applications, using [component](https://laravel.com/docs/5.8/blade#components-and-slots) and [include](https://laravel.com/docs/5.8/blade#including-sub-views) functions of Laravel Blade.  
You can publishing your themes and install-it in other projects using composer.  
**Under construction!**

## Requirements

- Laravel 6.*^ 

## Install

**Install via composer**
``` bash
composer require maestriam/samurai
```

## Getting Start

**Creating a new theme**
``` bash
php artisan samurai:make-theme my-theme
```

**Creating a new include** 
``` bash
php artisan samurai:make-include my-theme my-include
```

To edit your include file, go to themes/my-theme/src/my-include/my-include-include.blade.php

**Creating a new component**
``` bash
php artisan samurai:make-component my-theme my-component
```

To edit your include file, go to themes/my-theme/src/my-component/my-component-component.blade.php

**Using theme in your project**
To publish your assets and define your theme as current:
``` bash
php artisan samurai:use my-theme
```

**Using components into blade files**
To use component in your view.blade.php, use:
``` bash
@myComponent()

    My content inside

@endmyComponent()
```

**Using includes into blade files**  
To use include in your view.blade.php, use:
``` bash
@myInclude()
```

**Load assets into theme files**  
To import any file into your theme(like css, js, imgs), use:
``` bash
<script src="@public('js/index.js')" />
```