<p align="center">
    <img width="256" src="http://project.maestriam.com.br/modules/maestro/img/samurai.png">
</p>

<p align="center"><b>Create awsome themes for your Laravel projects.</b></p>


# 🔴 Maestriam/Samurai

**Maestriam/Samurai** is a simple package for creating and managing themes for Laravel applications, using [component](https://laravel.com/docs/5.8/blade#components-and-slots) and [include](https://laravel.com/docs/5.8/blade#including-sub-views) functions of Laravel Blade.  
You can publishing your themes and install-it in another projects using composer.  
**Under construction!**

## Requirements

- Laravel 6.*^ 

## Installation

**Install via composer**
``` bash
composer require maestriam/samurai
```

**Publish samurai.php into config folder**
``` bash
php artisan vendor:publish --tag=Samurai
```

## Getting Started

To create a new theme
``` bash
php artisan samurai:make-init
```

**Creating a new theme with default configs**
``` bash
php artisan samurai:make-theme my-vendor/my-theme
```

**Creating a new include** 
``` bash
php artisan samurai:make-include my-vendor/my-theme my-include
```

To edit your include file, go to themes/my-vendor/my-theme/src/my-include/my-include-include.blade.php

**Creating a new component**
``` bash
php artisan samurai:make-component my-vendor/my-theme my-component
```

To edit your include file, go to themes/my-vendor/my-theme/src/my-component/my-component-component.blade.php

**Using theme in your project**  
To publish your assets and define your theme as current:
``` bash
php artisan samurai:use my-vendor/my-theme
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
To import any file into your theme(like css, js, imgs), use directive @public.  
E.g:
``` bash
<script src="@public('js/index.js')" />
```
  
    
## Author Notes
*Hello, my name is [Giuliano Sampaio](https://github.com/giusampaio). I'm developer since 2006 and `mastriam/samurai` author*  
*This is my first open source project and I would like to know your opinion, suggestions for improvements and, of course, new committs to help the project grow. Feel free to add on [Linked-in](https://www.linkedin.com/in/giuliano-sampaio-812ba340/) or follow me on [Github](https://github.com/giusampaio).*  
*I'm still working hard to fix and improve some parts of the code, but I hope to get it as soon as possible.*  
*I hope this project can help you improve your blade views in your Laravel projects, just as it is helping me.*

*Best regards and good codes.*  

*Made with ❤️ and 🍺!*