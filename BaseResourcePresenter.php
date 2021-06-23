<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use BasicApp\Controller\ActionsTrait;
use BasicApp\Controller\ControllerTrait;

abstract class BaseResourcePresenter extends \CodeIgniter\RESTful\ResourcePresenter
{

    use ControllerTrait;

    use ActionsTrait;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->initialize();
    }

    protected function initialize()
    {
    }

}