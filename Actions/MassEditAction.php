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

    public $responseParams = [];

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

            $response = $action->responseParams;

            if ($action->beforeMassEdit)
            {
                $result = $this->trigger($action->beforeMassEdit, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'responseParams' => $response,
                    'response' => null
                ]);

                if ($result['response'] !== null)
                {
                    return $result['response'];
                }

                $response = array_merge($response, $result['responseParams']);
            }

            $response['data'] = $action->data;

            return $this->respondOK($response);
        };
    }

}