<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class CreateAction extends BaseAction
{

    use ParentTrait;

    public $beforeCreate;

    public function initialize()
    {
        parent::initialize();

        $this->initializeParent();
    }

    public function run(...$params)
    {
        $action = $this;

        return function(...$params) use ($action)
        {
            $defaults = [];

            if ($action->parentKey)
            {            
                $defaults[$action->parentKey] = $action->parentId;
            }

            $action->data = $action->model->createData($defaults);

            $action->data->fill($this->getRequestData($this->request->getGet()));

            $errors = [];

            $validationErrors = [];

            if ($action->beforeCreate)
            {
                $result = $this->trigger($action->beforeCreate, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'parentModel' => $action->parentModel,
                    'parentData' => $action->parentData,
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

            if (!$errors && !$validationErrors)
            {
                if ($action->data instanceof ActiveEntityInterface)
                {
                    if ($action->data->save($errors))
                    {
                        $insertID = $action->data->getInsertID();

                        return $this->respondCreated([
                            'insertID' => $insertID
                        ]);
                    }

                    $validationErrors = $action->data->errors();
                }
                else
                {
                    if ($action->model->save($action->data, $errors))
                    {
                        $insertID = $action->model->getInsertID();
                 
                        return $this->respondCreated([
                            'insertID' => $insertID
                        ]);
                    }

                    $validationErrors = $action->model->errors();
                }
            }
        
            return $this->respondInvalidData([
                'data' => $action->data,
                'validationErrors' => (array) $validationErrors,
                'errors' => (array) $errors,
                'parentData' => $action->parentData
            ]);
        };
    }

}