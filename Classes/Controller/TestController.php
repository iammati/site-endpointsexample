<?php

declare(strict_types=1);

namespace Site\SiteEndpointsexample\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class TestController extends ActionController
{
    public function testAction(): ResponseInterface
    {
        $this->view->assign('a', 'b');

        return new HtmlResponse(
            $this->view->render()
        );

        // Example in case it's necessary to render the page normally - note that TSFE is set to PageID 1
        // to make TSFE in general available, you may would like to change that by taking a look into
        // the FrontendEnvironment provided by site/site-endpoints aka. EXT:site_endpoints

        // $handler = GeneralUtility::makeInstance(RequestHandler::class);
        // return $handler->handle($this->request);
    }
}
