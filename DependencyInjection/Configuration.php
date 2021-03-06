<?php

namespace Arcanys\SSOAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('arcanys_sso_auth');

        $rootNode
            ->children()
                ->arrayNode('user_provider')
                    ->children()
                        ->scalarNode('class')->end()
                    ->end()
                ->end()
                ->arrayNode('sp')
                    ->children()
                        ->scalarNode('base_url')->end()
                    ->end()
                ->end()
                ->arrayNode('idp')
                    ->children()
                        ->scalarNode('entity_id')->end()
                        ->scalarNode('single_signon_service')->end()
                        ->scalarNode('single_logout_service')->end()
                        ->scalarNode('cert')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
