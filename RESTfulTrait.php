<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

use Webmozart\Assert\Assert;

trait RESTfulTrait
{

    // Models

    protected $createModelName;

    protected $createModel;

    protected $updateModelName;

    protected $updateModel;

    protected $parentModelName;

    protected $parentModel;

    protected $searchModelName;

    protected $searchModel;

    // Config

    protected $parentKey;

    protected $perPage;

    protected $perPageItems;

    // Data

    protected $data;

    protected $searchData;

    protected $parent;

    protected $errors = [];

    protected $validationErrors = [];

    public function initModels(array $models = ['createModel', 'updateModel', 'parentModel', 'searchModel'])
    {
        foreach($models as $model)
        {
            $modelName = $model . 'Name';

            if ($this->$modelName)
            {
                $this->$model = model($this->$modelName, false);

                Assert::notEmpty($this->$model, lang('Model not found: "{0}".', [$this->$modelName]));
            }
        }
    }

    public function getParent($refresh = false)
    {
        if ($this->parent && !$refresh)
        {
            return $this->parent;
        }

        Assert::notEmpty($this->parentModelName, 'Parent model name not defined.');

        Assert::notEmpty($this->parentModel, 'Parent model not found: ' . $this->parentModelName);

        $parentId = $this->request->getGet('parentId');

        Assert::notEmpty($parentId, 'parentId not defined.');
        
        $this->parent = $this->parentModel->findOrFail($parentId, 'Parent not found.');
    
        return $this->parent;
    }

    public function userCanMethod($user, string $method, &$error = null) : bool
    {
        return true;
    }

}