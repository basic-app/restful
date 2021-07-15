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