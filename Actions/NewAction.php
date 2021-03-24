<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class NewAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method)
        {
            assert($this->model ? true : false);
            
            $data = $this->model->createEntity($this->request->getGet());

            return $this->respond([
                'data' => $data->toArray()
            ]);
        };
    }

}