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

    public $beforeMassEdit;

    public $defaultParams = [];

    public function initialize()
    {
        parent::initialize();
    }

    public function run(...$params)
    {
        $action = $this;

        return function(...$params) use ($action)
        {
            $action->data = $action->model->createEntity();

            $action->data->fill($this->request->getGet());

            $params = $action->defaultParams;

            $params['data'] = $action->data;

            if ($action->beforeMassEdit)
            {
                $result = $this->trigger($action->beforeMassEdit, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'defaultParams' => $action->defaultParams,
                    'params' => [],
                    'result' => null
                ]);

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }

                $params = array_merge($params, $result['params']);
            }

            return $this->respondOK($params);
        };
    }

}