<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zim32\TestTask\App\TestTaskApp;
use Zim32\TestTask\Contract\BinCountryResolverInterface;
use Zim32\TestTask\Contract\CommissionCalculatorInterface;
use Zim32\TestTask\Contract\CurrencyConverterInterface;
use Zim32\TestTask\Contract\ExchangeRatesProviderInterface;
use Zim32\TestTask\Service\DefaultBinCountryResolver;
use Zim32\TestTask\Service\DefaultCommissionCalculator;
use Zim32\TestTask\Service\DefaultCurrencyConverter;
use Zim32\TestTask\Service\DefaultExchangeRatesProvider;

/**
 * Creates dependency injection container, with all registered services
 *
 * @return ContainerInterface
 */
function createContainer(): ContainerInterface
{
    $builder = new ContainerBuilder();

    $builder->setParameter('curr_converter_api_key', 'Hmti8P1Kl6Q4W6fjZL2ZVw6bkR5zef0e');

    $builder
        ->register(TestTaskApp::class)
        ->setPublic(true)
        ->setAutowired(true);

    $builder
        ->register(CommissionCalculatorInterface::class)
        ->setClass(DefaultCommissionCalculator::class)
        ->setAutowired(true);

    $builder
        ->register(BinCountryResolverInterface::class)
        ->setClass(DefaultBinCountryResolver::class)
        ->setAutowired(true);

    $builder
        ->register(CurrencyConverterInterface::class)
        ->setClass(DefaultCurrencyConverter::class)
        ->setAutowired(true);

    $builder
        ->register(ExchangeRatesProviderInterface::class)
        ->setClass(DefaultExchangeRatesProvider::class)
        ->setAutowired(true);

    $builder->compile();

    return $builder;
}
