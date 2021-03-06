# Html Menu Generator for Laravel

[![Build Status](https://travis-ci.org/hoangphison/laravel-menu.svg?branch=master)](https://travis-ci.org/hoangphison/laravel-menu)
[![StyleCI](https://styleci.io/repos/111900225/shield?branch=master)](https://styleci.io/repos/111900225)

This is the Laravel version of [our menu package](https://github.com/hoangphison/menu) adds some extras like convenience methods for generating URLs and macros.

Documentation is available at https://docs.spatie.be/menu.

Upgrading from version 1? There's a [guide](https://github.com/spatie/laravel-menu#upgrading-to-20) for that!

```php
Menu::macro('main', function () {
    return Menu::newMenu()
        ->action('HomeController@index', 'Home')
        ->action('AboutController@index', 'About')
        ->action('ContactController@index', 'Contact')
        ->setActiveFromRequest();
});
```

```html
<nav class="navigation">
    {!! Menu::main() !!}
</nav>
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Install

You can install the package via composer:

``` bash
$ composer require hoangphison/laravel-menu
```

## Usage

Documentation is available at https://docs.spatie.be/menu.

## Upgrading to 2.0

Upgrading to 2.0 should be pretty painless for most use cases.

- Link builder methods have been renamed and now have a `to` prefix: `Link::toAction`, `Link::toRoute` and `Link::toUrl`.
- See `hoangphison/menu`'s [upgrade guide](https://github.com/spatie/menu#upgrading-to-20) for more.

### New features...

- Added: Added a `View` item implementation to use blade views as menu items

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
