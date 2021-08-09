<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class DeleteAction extends BaseAction
{

    public $beforeDelete;

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

            if ($action->beforeDelete)
            {
                $result = $this->trigger($action->beforeDelete, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'response' => null
                ]);

                if ($result['response'] !== null)
                {
                    return $result['response'];
                }
            }

            if ($action->data instanceof ActiveEntityInterface)
            {
                $action->data->delete();
            }
            else
            {
                $action->model->deleteData($action->data);
            }
            
            return $this->respondDeleted();
        };
    }

}