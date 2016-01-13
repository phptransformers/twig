<?php

namespace PhpTransformers\PhpTransformer\Test;

use PhpTransformers\Twig\TwigTransformer;

class TwigTransformerTest extends \PHPUnit_Framework_TestCase
{
    public function testRenderFile()
    {
        $engine = new TwigTransformer();
        $template = __DIR__.'/Fixtures/TwigTransformer.twig';
        $locals = array(
            'name' => 'Linus',
        );
        $actual = $engine->renderFile($template, $locals);
        self::assertEquals('Hello, Linus!', $actual);
    }

    public function testRender()
    {
        $engine = new TwigTransformer();
        $template = file_get_contents('tests/Fixtures/TwigTransformer.twig');
        $locals = array(
            'name' => 'Linus',
        );
        $actual = $engine->render($template, $locals);
        self::assertEquals('Hello, Linus!', $actual);
    }

    public function testGetName()
    {
        $engine = new TwigTransformer();
        self::assertEquals('twig', $engine->getName());
    }

    public function testTwigProvided()
    {
        $loader = new \Twig_Loader_Filesystem();
        $loader->addPath(__DIR__.DIRECTORY_SEPARATOR.'Fixtures', 'test');
        $twig = new \Twig_Environment($loader);
        $engine = new TwigTransformer(array('twig' => $twig));

        $template = '@test/TwigTransformer.twig';
        $locals = array(
            'name' => 'Linus',
        );
        $actual = $engine->renderFile($template, $locals);
        self::assertEquals('Hello, Linus!', $actual);
    }
}
