# Site-EndpointsExample

This extension serves as an example to show how to use `site/site-endpoints` for third-party-extensions.

## Requirements
- PHP +8.0
- TYPO3 +11.3

Note that it has not been tested _yet_ on any lower TYPO3/PHP version.

### Registration of an endpoint

##### YAML-API
1. Head over into the `ext_localconf.php` of your own extension.
2. Add the following snippet:
```php
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    Site\SiteEndpoints\Provider\EndpointsProvider::class
)->loadYaml(
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath(
        'site_endpointsexample',
        'Configuration/Endpoints.yaml'
    )
);
```

**Note:** The `loadYaml` requires an absolute path to a YAML file which looks like this:
```yaml
routes:
  - prefix: '/yaml'
    groups:
    - routePath: '/v2'
      middlewares:
        - 'Site\SiteEndpoints\Middleware\ExtbaseBridge'
      routes:
        - methods: [GET]
          routePath: '/wow'
          callback: 'Site\SiteEndpointsexample\Controller\YamlController->wow'
```

##### PHP-API
1. Head over into the `ext_localconf.php` of your own extension.
2. Add the following snippet:
```php
\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    Site\SiteEndpoints\Provider\EndpointsProvider::class
)->add(
    (new Site\SiteEndpoints\Configuration\RouteIdentifier())
    ->setIdentifier('/identifier')
    ->addGroup(
        (new Site\SiteEndpoints\Configuration\RouteGroup())
        ->setRoutePath('/routegrouppath')
        ->addMiddleware(
            Site\SiteEndpoints\Middleware\ExtbaseBridge::class
        )
        ->addRoute(
            (new Site\SiteEndpoints\Configuration\Route())
            ->setRoutePath('/routepath')
            ->setCallback(
                Site\SiteTests\Controller\TestController::class,
                'test'
            )
        )
    )
);
```

So we got a new URI pathname called `/identifier/routegrouppath/routepath`.

`RouteIdentifier` **– The wrapper for the `RouteGroup` and `Route`**<br>
It's strongly recommended to have an unique `identifier`. Specific use-cases are:
- Kickstarting a new project? Use `/api` as identifier.
- Writing a third-party-extension? Use either your extension key with dash instead of underscore e.g. `/site-endpointsexample` or an unique string you could come up.

`RouteGroup` **– PSR-15 Middlewares and the next slug**<br>
`/routegrouppath` can be interpreted as some sort of `versioning-identifier`.
The default setup (in YAML) shipped by `site/site-endpoints` delivers the `routeGroupPath` as `/v1` which looks prefixed with the `identifier` as this: `/api/v1`.

`Route` **– Final slug which maps with it to controller->action**<br>
`/routepath` is the final slug/path-segment. This one has no rules at all, feel free to write/configure this as you like.

---

Change those slugs/path-segments as you need them as the controller-/action names to be, flush caches and you're ready to use them!
