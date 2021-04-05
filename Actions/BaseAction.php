<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

abstract class BaseAction extends \BasicApp\Action\BaseAction
{

    public $parentKey;

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

    public $formModelOne = 'formModelOne';

    public $formModelFindOrFail = 'formModelFindOrFail';

    public $formModelFindOne = 'formModelFindOne';

    public $formModelAll = 'formModelAll';

    public $formModelCreateEntity = 'formModelCreateEntity';

    public $formModelEntityPrimaryKey = 'formModelEntityPrimaryKey';

    public $formModelInsertID = 'formModelInsertID';

    public $formModelFillEntity = 'formModelFillEntity';

    public $formModelSave = 'formModelSave';

    public $formModelDelete = 'formModelDelete';

    public $formModelErrors = 'formModelErrors';

    public $formModelEntitySetField = 'formModelEntitySetField';

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

    public function formModelOne(...$params)
    {
        return $this->controller->callFormModel('one', $this->formModelOne, ...$params);
    }

    public function formModelFindOrFail(...$params)
    {
        return $this->controller->callFormModel('findOrFail', $this->formModelFindOrFail, ...$params);
    }    

    public function formModelFindOne(...$params)
    {
        return $this->controller->callFormModel('findOne', $this->formModelFindOne, ...$params);
    }

    public function formModelAll(...$params)
    {
        return $this->controller->callFormModel('all', $this->formModelAll, ...$params);
    }

    public function formModelCreateEntity(...$params)
    {
        return $this->controller->callFormModel('createEntity', $this->formModelCreateEntity, ...$params);
    }

    public function formModelEntityPrimaryKey(...$params)
    {
        return $this->controller->callFormModel('entityPrimaryKey', $this->formModelEntityPrimaryKey, ...$params);
    }

    public function formModelInsertID(...$params)
    {
        return $this->controller->callFormModel('insertID', $this->formModelInsertID, ...$params);
    }

    public function formModelFillEntity(...$params)
    {
        return $this->controller->callFormModel('fillEntity', $this->formModelFillEntity, ...$params);
    }

    public function formModelSave(...$params)
    {
        return $this->controller->callFormModel('save', $this->formModelSave, ...$params);
    }

    public function formModelDelete(...$params)
    {
        return $this->controller->callFormModel('delete', $this->formModelDelete, ...$params);
    }

    public function formModelErrors(...$params)
    {
        return $this->controller->callFormModel('errors', $this->formModelErrors, ...$params);
    }

    public function formModelEntitySetField(...$params)
    {
        return $this->controller->callFormModel('entitySetField', $this->formModelEntitySetField, ...$params);
    }

    public function modelEntitySetField(...$params)
    {
        return $this->controller->callModel('entitySetField', $this->modelEntitySetField, ...$params);
    }

}