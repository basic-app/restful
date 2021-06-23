<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class DeleteAction extends BaseAction
{

    public function run($method, ...$params)
    {
        return function($method, $id)
        {
            Assert::notEmpty($this->modelName, 'Model name not defined.');

            Assert::notEmpty($this->model, 'Model not found: ' . $this->modelName);

            $data = $this->model->findOne($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            if (!$this->userCanMethod($this->user, $method, $data))
            {
                $this->throwSecurityException(lang('Access denied.'));
            }

            if ($data instanceof ActiveEntityInterface)
            {
                $data->delete();
            }
            else
            {
                $this->model->deleteData($data);
            }
            
            return $this->respondDeleted();
        };
    }

}