<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;
use Webmozart\Assert\Assert;

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

            Assert::notEmpty($id, 'Primary key not found.');

            $result = $this->model->deleteOrFail($id);

            return $this->respondDeleted();
        };
    }

}