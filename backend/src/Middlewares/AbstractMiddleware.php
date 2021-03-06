<?php
namespace CkmTiming\Middlewares;

use Psr\Container\ContainerInterface as Container;

abstract class AbstractMiddleware
{
    /** @var Container */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
