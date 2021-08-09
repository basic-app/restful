<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class UpdateAction extends BaseAction
{

    public $beforeUpdate;

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

            $action->data->fill($this->getRequestData());

            $validationErrors = [];

            $errors = [];

            if ($action->beforeUpdate)
            {
                $result = $this->trigger($action->beforeUpdate, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'errors' => $errors,
                    'validationErrors' => $validationErrors,
                    'response' => null
                ]);

                if ($result['response'] !== null)
                {
                    return $result['response'];
                }

                $errors = $result['errors'];

                $validationErrors = $result['validationErrors'];
            }

            if ($action->data instanceof ActiveEntityInterface)
            {
                if ($action->data->save($errors))
                {
                    return $this->respondUpdated();
                }

                $validationErrors = $action->data->errors();
            }
            else
            {
                if ($action->model->save($action->data, $errors))
                {
                    return $this->respondUpdated();
                }

                $validationErrors = $action->model->errors();
            }
        
            return $this->respondInvalidData([
                'data' => $action->data,
                'validationErrors' => (array) $validationErrors,
                'errors' => (array) $errors
            ]);
        };
    }

}