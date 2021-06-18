<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

class MassEditAction extends BaseAction
{

    public $modelName;

    public function run($method, ...$params)
    {
        $modelName = $this->modelName;

        return function($method) use ($modelName)
        {
            if ($modelName)
            {
                $model = model($modelName, false);

                Assert::notEmpty($model, 'Model not found: ' . $modelName);
            }
            else
            {
                $model = $this->model;
            }

            $this->data = $model->createEntity();

            $this->data->fill($this->request->getGet());

            if (!$this->userCanMethod($this->user, $method, $error))
            {
                $this->throwSecurityException($error ?? lang('Access denied.'));
            }            

            return $this->respondOK([
                'data' => $this->data
            ]);
        };
    }

}