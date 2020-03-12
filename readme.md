<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>


## About 

Maestriam Samurai is a package for creating and managing Laravel Blade-based themes, using component and include function of Blade.  
You can publishing your themes and install in other projects.

## Install

Creating a theme
``` bash
composer require maestriam/samurai
```

## Getting Start

Creating a new theme
``` bash
php artisan samurai:make-theme my-theme
```

Creating a new include 
``` bash
php artisan samurai:make-include my-theme my-include
```

To edit your include file, go to themes/my-theme/src/my-include/my-include-include.blade.php

Creating a new component
``` bash
php artisan samurai:make-component my-theme my-component
```

To edit your include file, go to themes/my-theme/src/my-component/my-component-component.blade.php

Using theme in your project
``` bash
php artisan samurai:use my-theme
```

To use component in your view.blade.php, use:
``` bash
@myComponent()

    My content inside

@endmyComponent()
```

To use include in your view.blade.php, use:
``` bash
@myInclude()
```
