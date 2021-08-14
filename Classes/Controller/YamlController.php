<?php

declare(strict_types=1);

namespace Site\SiteEndpointsexample\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class YamlController extends ActionController
{
    public function wowAction(): ResponseInterface
    {
        return new HtmlResponse(
            'hello from the yaml controller! 🙈'
        );
    }
}
