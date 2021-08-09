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

    public $beforeShow;

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
            if (!$action->data)
            {
                return $this->failNotFound();
            }

            $response = $this->responseParams;

            if ($action->beforeShow)
            {
                $result = $this->trigger($action->beforeShow, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'response' => null,
                    'responseParams' => $response
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