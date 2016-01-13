# Twig for PHPTransformers

[Twig](http://twig.sensiolabs.org/) support for [PHPTransformers](http://github.com/phptransformers/phptransformer).

## Install

Via Composer

``` bash
$ composer require phptransformers/twig
```

## Usage

``` php
$engine = new TwigTransformer();
echo $engine->render('Hello, {{ name }}!', array('name' => 'phptransformers');
```

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.