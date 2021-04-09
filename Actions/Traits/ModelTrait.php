<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions\Traits;

trait ModelTrait
{

    public function modelOne(...$params)
    {
        return $this->controller->callModel('one', ...$params);
    }

    public function modelFindOrFail(...$params)
    {
        return $this->controller->callModel('findOrFail', ...$params);
    }

    public function modelFindOne(...$params)
    {
        return $this->controller->callModel('findOne', ...$params);
    }

    public function modelAll(...$params)
    {
        return $this->controller->callModel('all', ...$params);
    }

    public function modelCreateEntity(...$params)
    {
        return $this->controller->callModel('createEntity', ...$params);
    }

    public function modelEntityPrimaryKey(...$params)
    {
        return $this->controller->callModel('entityPrimaryKey', ...$params);
    }

    public function modelInsertID(...$params)
    {
        return $this->controller->callModel('insertID', ...$params);
    }

    public function modelFillEntity(...$params)
    {
        return $this->controller->callModel('fillEntity', ...$params);
    }

    public function modelSave(...$params)
    {
        return $this->controller->callModel('save', ...$params);
    }

    public function modelDelete(...$params)
    {
        return $this->controller->callModel('delete', ...$params);
    }

    public function modelErrors(...$params)
    {
        return $this->controller->callModel('errors', ...$params);
    }

    public function modelEntitySetField(...$params)
    {
        return $this->controller->callModel('entitySetField', ...$params);
    }    
    
}