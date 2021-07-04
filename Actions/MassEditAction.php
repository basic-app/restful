<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class MassEditAction extends BaseAction
{

    public $modelName;

    public $beforeMassEdit;

    public function initialize(?string $method)
    {
        parent::initialize($method);
    }

    public function run(...$params)
    {
        $action = $this;

        return function(...$params) use ($action)
        {
            Assert::notEmpty($action->modelName, 'Model name not defined.');

            $model = model($action->modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $action->modelName);

            $data = $model->createEntity();

            $data->fill($this->request->getGet());

            if ($action->beforeMassEdit)
            {
                $result = $this->trigger($action->beforeMassEdit, [
                    'model' => $model,
                    'data' => $data,
                    'result' => null
                ]);

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }
            }

            return $this->respondOK([
                'data' => $data
            ]);
        };
    }

}