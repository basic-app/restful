<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use BasicApp\Action\ActionTrait;
use BasicApp\Controller\ControllerTrait;

abstract class BaseResourceController extends \CodeIgniter\RESTful\ResourceController
{

    use ControllerTrait;

    use ActionTrait;

    use RESTfulTrait;    

}