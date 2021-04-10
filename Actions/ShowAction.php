<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;

class ShowAction extends BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {
            $data = $this->model->findOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            return $this->respondOK([
                'data' => $data->toArray()
            ]);
        };
    }

}