<?php

/**
 * This file is part of tbbc/rest-util
 *
 * (c) The Big Brains Company <contact@thebigbrainscompany.org>
 *
 */

namespace Tbbc\RestUtilBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Compiler pass for user custom error factories
 *
 * @author Benjamin Dulau <benjamin.dulau@gmail.com>
 */
class ErrorFactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('tbbc_rest_util.error.error_resolver')) {
            return;
        }

        $errorResolverDefinition = $container->getDefinition(
            $container->getParameter('tbbc_rest_util.error_resolver_service_id')
        );
        foreach ($container->findTaggedServiceIds('tbbc_rest_util.error_factory') as $id => $attributes) {
            $errorResolverDefinition->addMethodCall('registerFactory', array(new Reference($id)));
        }
    }
}
