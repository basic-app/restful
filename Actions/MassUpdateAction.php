<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class MassUpdateAction extends BaseAction
{

    public $beforeMassUpdate;

    public function initialize(?string $method = null)
    {
        parent::initialize($method);
    }

    public function run(...$params)
    {
        $action = $this;

        return function(...$params) use ($action)
        {
            $action->data = [];

            $ids = $this->request->getGet('ids');

            foreach($action->model->whereIn($action->model->primaryKey, $ids)->findAll() as $activeEntity)
            {
                $action->data[$activeEntity->getIdValue()] = $activeEntity;
            }

            foreach($ids as $id)
            {
                Assert::keyExists($action->data, $id, lang('Entity not found: #{id}', ['id' => $id]));
            }

            $validationErrors = [];

            $errors = [];

            if ($action->beforeMassUpdate)
            {
                $result = $this->trigger($action->beforeMassUpdate, [
                    'model' => $action->model,
                    'data' => $action->data,
                    'errors' => $errors,
                    'validationErrors' => $validationErrors,
                    'result' => null
                ]);

                if ($result['result'] !== null)
                {
                    return $result['result'];
                }

                $errors = $result['errors'];

                $validationErrors = $result['validationErrors'];
            }

            $saved = true;

            foreach($action->data as $id => $entity)
            {
                $entity->fill($this->getRequestData());
            
                if (!$entity->save($customErrors))
                {
                    $saved = false;

                    $validationErrors[$id] = (array) $entity->errors();
                
                    if ($customErrors)
                    {
                        $error = array_merge($errors, $customErrors);
                    
                        unset($customErrors);
                    }
                }
            }

            if ($saved)
            {
                return $this->respondUpdated();
            }
                    
            return $this->respondInvalidData([
                'data' => $action->data,
                'validationErrors' => $validationErrors,
                'errors' => $errors
            ]);
        };
    }

}