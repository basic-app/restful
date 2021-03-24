<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Exception;
use CodeIgniter\Controller;

abstract class BaseAction extends \BasicApp\Action\BaseAction
{

    public function __construct(Controller $controller, array $params = [])
    {
        parent::__construct($controller);

        foreach($params as $key => $value)
        {
            if (property_exists($this, $key))
            {
                $this->$key = $value;
            }
            else
            {
                throw new Exception('Unknown property: ' . $key);
            }
        }
    }

}