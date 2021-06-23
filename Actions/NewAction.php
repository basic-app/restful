<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class NewAction extends \BasicApp\Action\BaseAction
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

            $defaults = [];

            if ($this->parentKey)
            {
                $this->parentData = $this->getParent();

                $parentId = $this->parentModel->getIdValue($this->parentData);
            
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