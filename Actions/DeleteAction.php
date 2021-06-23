<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class DeleteAction extends \BasicApp\Action\BaseAction
{

    public $modelName;

    public function run($method, ...$params)
    {
        $modelName = $this->modelName;

        return function($method, $id) use ($modelName)
        {
            Assert::notEmpty($modelName, 'Model name not defined.');

            $model = model($modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $modelName);

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