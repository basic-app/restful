<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

class EditAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {
            assert($this->model ? true : false);
            
            assert($id ? true : false);

            $data = $this->modelFind($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            return $this->respond(['data' => $data->toArray()]);
        };
    }


}