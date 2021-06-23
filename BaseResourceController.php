<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use BasicApp\Controller\ActionsTrait;
use BasicApp\Controller\ControllerTrait;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use BasicApp\Action\ActionInterface;

abstract class BaseResourceController extends \CodeIgniter\RESTful\ResourceController
{

    use ControllerTrait;

    use ActionsTrait;

    protected $format = 'json';

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param LoggerInterface   $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->initialize();
    }

    protected function initialize()
    {
    }

}