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

            if ($action->beforeMassEdit)
            {
                $result = $this->trigger($action->beforeMassEdit, [
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