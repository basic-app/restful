<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Closure;
use Webmozart\Assert\Assert;

class EditAction extends BaseAction
{

    public $modelName;

    public $model;

    public $data;

    public $id;

    public $beforeEdit;

    public $template = 'edit';

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

            if ($action->beforeEdit)
            {
                $result = $this->trigger($action->beforeEdit, [
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