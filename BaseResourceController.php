<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use BasicApp\Action\ControllerActionTrait;
use BasicApp\Controller\ControllerTrait;

abstract class BaseResourceController extends \CodeIgniter\RESTful\ResourceController
{

    use ControllerTrait;

    use ControllerActionTrait;

    use RESTfulTrait;

}