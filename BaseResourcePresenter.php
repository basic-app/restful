<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use BasicApp\Action\ActionTrait;
use BasicApp\Controller\ControllerTrait;

abstract class BaseResourcePresenter extends \CodeIgniter\RESTful\ResourcePresenter
{

    use ControllerTrait;

    use ActionTrait;

    use RESTfulTrait;

}