<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class NewAction extends \BasicApp\Action\BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method)
        {    
            $data = $this->formModel->createEntity($this->request->getGet());

            return $this->respondOk([
                'data' => $data->toArray()
            ]);
        };
    }

}