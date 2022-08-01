# SettingOperation

Backpack Setting Operation to save customize settings for each CRUD. Uses Backpackforlaravel. Works on Laravel 5.2 to Laravel 8. 

Backpackforlaravel is cool admin panel for laravel.

Many times it is necessary to make settings for some CRUDs, for example, for the transactions CRUD, you need bank port settings, or for product management, you need settings related to transportation, taxes, etc.

You can even make many of your backpack settings dynamic with this add-on.

## Installation

Via Composer

``` bash
$ composer require rezahmady/setting-operation
```
publish vendor :

``` bash
$ php artisan vendor:publish
```

migrate add-on table :

``` bash
$ php artisan migrate
```


## Why do you need this add-on ?

If you, like me, believe that each CRUD can be a separate module, then having the settings for each crud (module) is important.

The backpack has a settings add-on that I don't think is practical at all.Funny, you have to save the fields as json in the database. But in this add-on, like other operations such as CreateOperation and UpdateOperation, easily use the all backpack fields.

## Usage

**Step 1.** In your CrudController, use the operation trait:

    <?php
    
    namespace App\Http\Controllers\Admin;
    
    use Backpack\CRUD\app\Http\Controllers\CrudController;
    
    class ProductCrudController extends CrudController
    {
        use \Rezahmady\SettingOperation\SettingOperation;

**Step 2.** In your CrudController, add *setupSettingOperation* method and add your custom backpack fields:

        /**
        * Define what happens when the Setting operation is loaded.
        * 
        * @see https://github.com/rezahmady/setting-operation
        * @return void
        */
        protected function setupSettingOperation()
        {
            // backpack fields
        }

**Step 3.** To call the value of each field, you must use the *Setting* facade:

    use Rezahmady\SettingOperation\Setting;
    
    Setting::get(CRUD_TABLE_NAME.FIELD_NAME, DEFAULT);

**fast update field** To update or set new field you can use this:

    use Rezahmady\SettingOperation\Setting;
    
    Setting::set(CRUD_TABLE_NAME.FIELD_NAME, VALUE);


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email ahmadireza15@gmail.com instead of using the issue tracker.

## Credits

- [Reza Ahmadi Sabzevar][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/rezahmady/settingoperation.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rezahmady/settingoperation.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rezahmady/settingoperation/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/rezahmady/settingoperation
[link-downloads]: https://packagist.org/packages/rezahmady/settingoperation
[link-travis]: https://travis-ci.org/rezahmady/settingoperation
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/rezahmady
[link-contributors]: ../../contributors
