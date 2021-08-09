<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class NewAction extends BaseAction
{

    use ParentTrait;

    public $template = 'new';

    public $beforeNew;

    public $responseParams = [];

    public function initialize()
    {
        parent::initialize();

        $this->initializeParent();
    
        if ($this->parentModelName)
        {
            $this->parentModel = model($this->parentModelName, false);

            Assert::notEmpty($this->parentModel, 'Parent model not found: ' . $this->parentModelName);
        }
    }

    public function run(...$params)
    {
        $action = $this;

        return function(...$params) use ($action)
        {    
            $defaults = [];

            if ($this->parentKey)
            {
                $defaults[$action->parentKey] = $action->parentId;
            }

            $action->data = $action->model->createData($defaults);

            $action->data->fill($this->request->getGet());

            $response = $action->responseParams;

            if ($action->beforeNew)
            {
                $result = $this->trigger($action->beforeNew, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'parentModel' => $action->parentModel,
                    'parentData' => $action->parentData,
                    'responseParams' => $response,
                    'response' => null
                ]);

                if ($result['response'] !== null)
                {
                    return $result['response'];
                }

                $response = array_merge($response, $result['responseParams']);
            }

            $response['parentData'] = $action->parentData;

            $response['data'] = $action->data;
        
            return $this->render($action->template, $response);
        };
    }

}