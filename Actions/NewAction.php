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
        $action = $this;

        return function($method) use ($action)
        {    
            $data = $action->formModelCreateEntity($this->request->getGet());

            return $this->respondOK([
                'data' => $data->toArray()
            ]);
        };
    }

}