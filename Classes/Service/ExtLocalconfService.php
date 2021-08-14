<?php

declare(strict_types=1);

namespace Site\SiteEndpointsexample\Service;

use Site\SiteEndpoints\Configuration\Route;
use Site\SiteEndpoints\Configuration\RouteGroup;
use Site\SiteEndpoints\Configuration\RouteIdentifier;
use Site\SiteEndpoints\Middleware\ExtbaseBridge;
use Site\SiteEndpoints\Provider\EndpointsProvider;
use Site\SiteEndpointsexample\Controller\TestController;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ExtLocalconfService
{
    public function __construct()
    {
        GeneralUtility::makeInstance(EndpointsProvider::class)->add(
            (new RouteIdentifier())
            ->setIdentifier('/identifier')
            ->addGroup(
                (new RouteGroup())
                ->setRoutePath('/routegrouppath')
                ->addMiddleware(
                    ExtbaseBridge::class
                )
                ->addRoute(
                    (new Route())
                    ->setRoutePath('/routepath')
                    ->setCallback(
                        TestController::class,
                        'test'
                    )
                )
            )
        );

        GeneralUtility::makeInstance(EndpointsProvider::class)->loadYaml(
            ExtensionManagementUtility::extPath('site_endpointsexample', 'Configuration/Endpoints.yaml')
        );
    }
}
