<?php

namespace PhpTransformers\Twig;

use PhpTransformers\PhpTransformer\Transformer;
use Twig_Loader_Chain;
use Twig_Loader_Filesystem;
use Twig_Environment;

class TwigTransformer extends Transformer
{
    protected $twig;
    protected $loaders = array();

    public function __construct(array $options = array())
    {
        if (isset($options['twig'])) {
            $this->twig = $options['twig'];
        } else {
            $this->twig = new Twig_Environment(new Twig_Loader_Chain(), $options);
        }
    }

    public function getName()
    {
        return 'twig';
    }

    public function render($template, array $locals = array())
    {
        // Create a temporary template in the system tmp directiry
        $tmp = tempnam(sys_get_temp_dir(), 'phptransformer-twig');
        file_put_contents($tmp, $template);

        // Render the file
        $data = $this->renderFile($tmp, $locals);

        // Remove the temporary template
        unlink($tmp);

        return $data;
    }

    public function renderFile($file, array $locals = array())
    {
        // Construct a new loader from the base path.
        $path = dirname(realpath($file));
        if (!isset($this->loaders[$path])) {
            $this->loaders[$path] = new Twig_Loader_Filesystem($path);
        }

        // Save the current loader
        try {
            $previousLoader = $this->twig->getLoader();
        } catch (\LogicException $e) {
            $previousLoader = null;
        }

        // Set the filesystem loader to use
        $this->twig->setLoader($this->loaders[$path]);

        // Render the file using its file name.
        $data = trim($this->twig->render(basename($file), $locals));

        // Restore previous loader;
        if ($previousLoader) {
            $this->twig->setLoader($previousLoader);
        }

        return $data;
    }
}
