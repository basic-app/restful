<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class NewAction extends \BasicApp\Action\Action
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

            $this->data->fill($this->request->getGet());

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }

            $result = [
                'data' => $this->data
            ];

            /*
            if ($parent)
            {
                $result['parentData'] = $this->parentData;
            }
            */

            return $this->respondOK($result);
        };
    }

}