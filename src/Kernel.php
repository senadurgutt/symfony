<?php
// src/Kernel.php
namespace App;

use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class Kernel extends BaseKernel
{
    public function registerBundles(): iterable
    {
        $contents = [
            // List your bundles here
        ];

        foreach ($contents as $bundle) {
            yield $bundle;
        }
    }

    public function configureContainer(LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir().'/config/packages/*.yaml');
        $loader->load($this->getProjectDir().'/config/services.yaml');
    }

    public function configureRoutes(LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir().'/config/routes/*.yaml');
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load($this->getProjectDir().'/config/services.yaml');
    }
}
