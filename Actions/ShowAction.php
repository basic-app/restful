<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class ShowAction extends BaseAction
{

    public $modelName;

    public $model;

    public $id;

    public $data;

    public $beforeShow;

    public function initialize(?string $method = null)
    {
        parent::initialize($method);

        Assert::notEmpty($this->modelName, 'Model name not defined.');

        $this->model = model($this->modelName, false);

        Assert::notEmpty($this->model, 'Model not found: ' . $this->modelName);

        if ($this->id)
        {
            $this->data = $this->model->prepareBuilder()->findOne($this->id);
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

            if ($action->beforeShow)
            {
                $result = $this->trigger($action->beforeShow, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'result' => null
                ]);

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }
            }

            return $this->respondOK([
                'data' => $action->data
            ]);
        };
    }

}