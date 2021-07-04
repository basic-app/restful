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

    public $modelName;

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
            Assert::notEmpty($action->modelName, 'Model name not defined.');

            $model = model($action->modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $action->modelName);

            $this->data = [];

            $ids = $this->request->getGet('ids');

            foreach($model->whereIn($model->primaryKey, $ids)->findAll() as $activeEntity)
            {
                $this->data[$activeEntity->getIdValue()] = $activeEntity;
            }

            foreach($ids as $id)
            {
                Assert::keyExists($this->data, $id, lang('Entity not found: #{id}', ['id' => $id]));
            }

            $validationErrors = [];

            $errors = [];

            if ($action->beforeMassUpdate)
            {
                $result = $this->trigger($action->beforeMassUpdate, [
                    'model' => $model,
                    'data' => $data,
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

            foreach($this->data as $id => $entity)
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
                'data' => $this->data,
                'validationErrors' => $validationErrors,
                'errors' => $errors
            ]);
        };
    }

}