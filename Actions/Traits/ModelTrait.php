<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions\Traits;

trait ModelTrait
{

    public $modelOne = 'modelOne';

    public $modelFindOrFail = 'modelFindOrFail';

    public $modelFindOne = 'modelFindOne';

    public $modelAll = 'modelAll';

    public $modelCreateEntity = 'modelCreateEntity';

    public $modelEntityPrimaryKey = 'modelEntityPrimaryKey';

    public $modelInsertID = 'modelInsertID';

    public $modelFillEntity = 'modelFillEntity';

    public $modelSave = 'modelSave';

    public $modelDelete = 'modelDelete';

    public $modelErrors = 'modelErrors';

    public $modelEntitySetField = 'modelEntitySetField';

    public function modelOne(...$params)
    {
        return $this->controller->callModel('one', $this->modelOne, ...$params);
    }

    public function modelFindOrFail(...$params)
    {
        return $this->controller->callModel('findOrFail', $this->modelFindOrFail, ...$params);
    }

    public function modelFindOne(...$params)
    {
        return $this->controller->callModel('findOne', $this->modelFindOne, ...$params);
    }

    public function modelAll(...$params)
    {
        return $this->controller->callModel('all', $this->modelAll, ...$params);
    }

    public function modelCreateEntity(...$params)
    {
        return $this->controller->callModel('createEntity', $this->modelCreateEntity, ...$params);
    }

    public function modelEntityPrimaryKey(...$params)
    {
        return $this->controller->callModel('entityPrimaryKey', $this->modelEntityPrimaryKey, ...$params);
    }

    public function modelInsertID(...$params)
    {
        return $this->controller->callModel('insertID', $this->modelInsertID, ...$params);
    }

    public function modelFillEntity(...$params)
    {
        return $this->controller->callModel('fillEntity', $this->modelFillEntity, ...$params);
    }

    public function modelSave(...$params)
    {
        return $this->controller->callModel('save', $this->modelSave, ...$params);
    }

    public function modelDelete(...$params)
    {
        return $this->controller->callModel('delete', $this->modelDelete, ...$params);
    }

    public function modelErrors(...$params)
    {
        return $this->controller->callModel('errors', $this->modelErrors, ...$params);
    }

    public function modelEntitySetField(...$params)
    {
        return $this->controller->callModel('entitySetField', $this->modelEntitySetField, ...$params);
    }    
    
}