<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions\Traits;

trait FormModelTrait
{

    public function formModelOne(...$params)
    {
        return $this->controller->callFormModel('one', ...$params);
    }

    public function formModelFindOrFail(...$params)
    {
        return $this->controller->callFormModel('findOrFail', ...$params);
    }    

    public function formModelFindOne(...$params)
    {
        return $this->controller->callFormModel('findOne', ...$params);
    }

    public function formModelAll(...$params)
    {
        return $this->controller->callFormModel('all', ...$params);
    }

    public function formModelCreateEntity(...$params)
    {
        return $this->controller->callFormModel('createEntity', ...$params);
    }

    public function formModelEntityPrimaryKey(...$params)
    {
        return $this->controller->callFormModel('entityPrimaryKey', ...$params);
    }

    public function formModelInsertID(...$params)
    {
        return $this->controller->callFormModel('insertID', ...$params);
    }

    public function formModelFillEntity(...$params)
    {
        return $this->controller->callFormModel('fillEntity', ...$params);
    }

    public function formModelSave(...$params)
    {
        return $this->controller->callFormModel('save', ...$params);
    }

    public function formModelDelete(...$params)
    {
        return $this->controller->callFormModel('delete', ...$params);
    }

    public function formModelErrors(...$params)
    {
        return $this->controller->callFormModel('errors', ...$params);
    }

    public function formModelEntitySetField(...$params)
    {
        return $this->controller->callFormModel('entitySetField', ...$params);
    }

}