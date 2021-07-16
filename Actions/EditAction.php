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

    public $beforeEdit;

    public $template = 'edit';

    public $defaultParams = [];

    public function initialize()
    {
        parent::initialize();

        Assert::notEmpty($this->id);
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
                    'defaultParams' => $action->defaultParams,
                    'result' => null
                ]);

                $action->defaultParams = $result['defaultParams'];

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }
            }

            $params = $action->defaultParams;

            $params['data'] = $action->data;

            return $this->respondOK($params);
        };
    }

}