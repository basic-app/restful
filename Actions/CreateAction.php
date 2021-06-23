<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;
use BasicApp\Entity\ActiveEntityInterface;

class CreateAction extends \BasicApp\Action\Action
{

    public $modelName;

    public $parentModelName;

    public function run($method, ...$params)
    {
        $modelName = $this->modelName;

        $parentModelName = $this->parentModelName;

        return function($method) use ($modelName, $parentModelName)
        {
            Assert::notEmpty($modelName, 'Model name not defined.');

            $model = model($modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $modelName);

            $defaults = [];

            $parent = null;

            if ($this->parentKey)
            {
                Assert::notEmpty($parentModelName, 'Parent model not defined.');

                $parentModel = model($parentModelName, false);

                Assert::notEmpty($parentModel, 'Parent model not found: ' . $parentModelName);

                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId, 'parentId not defined.');
                
                $this->parentData = $parentModel->findOrFail($parentId, 'Parent not found.');

                $parentId = $parentModel->getIdValue($this->parentData);
            
                $defaults[$this->parentKey] = $parentId;
            }

            $this->data = $model->createData($defaults);

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $validationErrors = [];

            $errors = [];

            $this->data->fill(array_merge($this->request->getGet(), (array) $this->request->getJSON(true)));

            $insertID = null;

            if ($this->data instanceof ActiveEntityInterface)
            {
                $saved = $this->data->save($errors);

                if ($saved)
                {
                    $insertID = $this->data->getInsertID();
                }

                $validationErrors = $this->data->errors();
            }
            else
            {
                $saved = $model->save($this->data, $errors);

                if ($saved)
                {
                    $insertID = $model->getInsertID();
                }

                $validationErrors = $model->errors();
            }

            if ($saved)
            {
                return $this->respondCreated([
                    'insertID' => $insertID
                ]);
            }

            $result = [
                'data' => $this->data,
                'validationErrors' => (array) $validationErrors,
                'errors' => (array) $errors
            ];

            /*

            if ($parent)
            {
                $result['parent'] = $parent;
            }

            */
        
            return $this->respondInvalidData($result);
        };
    }

}