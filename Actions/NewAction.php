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

    public function initialize(?string $method = null)
    {
        parent::initialize($method);

        $this->initializeParent();

        Assert::notEmpty($this->modelName, 'Model name not defined.');

        $this->model = model($this->modelName, false);

        Assert::notEmpty($this->model, 'Model not found: ' . $this->modelName);
    
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

            if ($action->beforeNew)
            {
                $result = $this->trigger($action->beforeNew, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'parentModel' => $action->parentModel,
                    'parentData' => $action->parentData,
                    'result' => null
                ]);

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }
            }
        
            return $this->render($action->template, [
                'parentData' => $action->parentData,
                'data' => $action->data
            ]);
        };
    }

}