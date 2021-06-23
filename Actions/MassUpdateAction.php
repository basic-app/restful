<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class MassUpdateAction extends \BasicApp\Action\BaseAction
{

    public $modelName;

    public function run($method, ...$params)
    {
        $modelName = $this->modelName;

        return function($method) use ($modelName)
        {
            Assert::notEmpty($modelName, 'Model name not defined.');

            $model = model($modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $modelName);

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

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $saved = true;

            foreach($this->data as $id => $entity)
            {
                $entity->fill($this->request->getJSON(true));
            
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