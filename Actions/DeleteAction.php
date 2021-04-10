<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;

class DeleteAction extends BaseAction
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

            $id = $this->model->entityPrimaryKey($data);

            assert($id ? true : false);

            $result = $this->model->delete($id);

            assert($result);

            return $this->respondDeleted([
                'code' => $this->codes['deleted']
            ]);
        };
    }

}