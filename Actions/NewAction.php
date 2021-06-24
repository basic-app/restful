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

    public $template = 'new';

    public function run($method, ...$params)
    {
        $modelName = $this->modelName;

        $parentModelName = $this->parentModelName;

        $template = $this->template;

        return function($method) use ($modelName, $parentModelName, $template)
        {    
            Assert::notEmpty($modelName, 'Model name not defined.');

            $model = model($modelName, false);

            Assert::notEmpty($model, 'Model not found: ' . $modelName);

            $defaults = [];

            $parentData = null;

            if ($this->parentKey)
            {
                Assert::notEmpty($parentModelName, 'Parent model not defined.');

                $parentModel = model($parentModelName, false);

                Assert::notEmpty($parentModel, 'Parent model not found: ' . $parentModelName);

                $parentId = $this->request->getGet('parentId');

                Assert::notEmpty($parentId, 'parentId not defined.');
                
                $parentData = $parentModel->findOrFail($parentId, 'Parent not found.');

                $parentId = $parentModel->getIdValue($parentData);

                $defaults[$this->parentKey] = $parentId;
            }

            $data = $model->createData($defaults);

            $data->fill($this->request->getGet());

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }
        
            return $this->render($template, [
                'parentData' => $parentData,
                'data' => $data
            ]);
        };
    }

}