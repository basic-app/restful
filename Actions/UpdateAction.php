<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class UpdateAction extends \BasicApp\Action\Action
{

    public $modelName;

    public function run($method, ...$params)
    {
        $modelName = $this->modelName;

        return function($method, $id) use ($modelName)
        {
            Assert::notEmpty($modelName, 'Model name not defined.');

            $model = model($modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $modelName);

            $this->data = $model->findOne($id);

            if (!$this->data)
            {
                return $this->failNotFound();
            }

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $this->data->fill($this->request->getJSON(true));

            if ($this->data instanceof ActiveEntityInterface)
            {
                $saved = $this->data->save($errors); 

                $validationErrors = $this->data->errors();
            }
            else
            {
                $saved = $model->save($this->data, $errors);
            
                $validationErrors = $model->errors();
            }

            if ($saved)
            {
                return $this->respondUpdated();
            }

            $result = [
                'data' => $this->data,
                'validationErrors' => (array) $validationErrors,
                'errors' => (array) $errors
            ];
        
            return $this->respondInvalidData($result);
        };
    }

}