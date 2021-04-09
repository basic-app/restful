<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions\Traits;

trait FormModelTrait
{

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

}