<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use Webmozart\Assert\Assert;

abstract class BaseAction extends \BasicApp\Action\BaseAction
{

    public $modelName;

    public $model;

    public $id;

    public $data;

    public function initialize(?string $method = null)
    {
        parent::initialize($method);

        Assert::notEmpty($this->modelName, 'Model name not defined.');

        $this->model = model($this->modelName, false);

        Assert::notEmpty($this->model, 'Model not found: ' . $this->modelName);
    
        if ($this->id)
        {
            $this->data = $this->model->findOne($this->id);
        }
    }

}