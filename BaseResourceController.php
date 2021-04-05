<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use BasicApp\Controller\ActionsTrait;
use BasicApp\Controller\ControllerTrait;

abstract class BaseResourceController extends \CodeIgniter\RESTful\ResourceController
{

    use ControllerTrait;

    use ActionsTrait;

    use RESTfulTrait;

    use ResourceControllerTrait;

}