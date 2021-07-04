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

    public $id;

    public $modelName;

    public $model;

    public $data;

    public $beforeDelete;

    public function initialize(?string $method = null)
    {
        parent::initialize($method);

        Assert::notEmpty($this->modelName, 'Model name not defined.');

        $this->model = model($this->modelName, false);

        Assert::notEmpty($this->model, 'Model not found: ' . $this->modelName);

        if ($this->id)
        {
            $this->data = $this->model->findOne($this->id);
        }
    }

    public function run(...$params)
    {
        $action = $this;

        return function(...$params) use ($action)
        {
            if (!$action->data)
            {
                return $this->failNotFound();
            }

            if ($action->beforeDelete)
            {
                $result = $this->trigger($action->beforeDelete, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'result' => null
                ]);

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }
            }

            if ($action->data instanceof ActiveEntityInterface)
            {
                $action->data->delete();
            }
            else
            {
                $action->model->deleteData($action->data);
            }
            
            return $this->respondDeleted();
        };
    }

}