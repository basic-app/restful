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
        $action = $this;

        return function($method, $id) use ($action)
        {
            $data = $action->modelFindOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            return $this->respondOk([
                'data' => $data->toArray()
            ]);
        };
    }

}