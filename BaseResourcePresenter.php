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
    use RESTful2Trait;
    use ResourcePresenterTrait;

    use Traits\IndexTrait;
    use Traits\NewTrait;
    use Traits\CreateTrait;
    use Traits\EditTrait;
    use Traits\ViewTrait;
    use Traits\UpdateTrait;
    use Traits\MassEditTrait;    
    use Traits\MassUpdateTrait;
    use Traits\DeleteTrait;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->initialize();
    }

    public function _remap($method, ...$params)
    {
        if (method_exists($this, $method))
        {
            return $this->$method(...$params);
        }

        return $this->remapAction($method, ...$params);
    }

    protected function initialize()
    {
    }

}