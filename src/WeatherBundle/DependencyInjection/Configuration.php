<?php

namespace Nfq\WeatherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nfq_weather');

        $rootNode
            ->children()
                ->scalarNode('provider')
                    ->isRequired()
                ->end()
                ->arrayNode('providers')
                    ->children()
                        ->scalarNode('yahoo')->end()
                        ->arrayNode('openweathermap')
                            ->children()
                                ->scalarNode('api_key')
                                    ->defaultValue('api_key')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('delegating')
                            ->children()
                                ->arrayNode('providers')
                                    ->isRequired()
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}