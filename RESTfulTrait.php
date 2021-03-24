<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

trait RESTfulTrait
{

    protected $formModelName;

    protected $formModel;

    /**
     * Set or change the model this controller is bound to.
     * Given either the name or the object, determine the other.
     *
     * @param object|string|null $which
     *
     * @return void
     */
    public function setFormModel($which = null)
    {
        // save what we have been given
        if ($which)
        {
            $this->formModel     = is_object($which) ? $which : null;
            $this->formModelName = is_object($which) ? null : $which;
        }

        // make a model object if needed
        if (empty($this->formModel) && ! empty($this->formModelName))
        {
            if (class_exists($this->formModelName))
            {
                $this->formModel = model($this->formModelName);
            }
        }

        // determine model name if needed
        if (! empty($this->formModel) && empty($this->formModelName))
        {
            $this->formModelName = get_class($this->formModel);
        }
    }

    protected function formModelErrors() : array
    {
        return $this->formModel->errors();
    }

    protected function formModelSave($data) : bool
    {
        return $this->formModel->save($data);
    }

    protected function formModelFind($id = null)
    {
        return $this->formModel->find($id);
    }

    protected function formModelFindAll(int $limit = 0, int $offset = 0)
    {
        return $this->formModel->findAll($limit, $offset);
    }

    public function formModelDelete($id = null, bool $purge = false)
    {
        return $this->formModel->delete($id, $purge);
    }

    public function formModelInsertID()
    {
        return $this->formModel->insertID();
    }

    public function formModelIdValue($data)
    {
        return $this->formModel->idValue($data);
    }

    public function formModelReturnType()
    {
        return $this->formModel->returnType;
    }

    public function formModelPrimaryKey()
    {
        return $this->formModel->primaryKey;
    }

    public function formModelAllowedFields()
    {
        return $this->formModel->allowedFields;
    }

    protected function modelErrors() : array
    {
        return $this->model->errors();
    }

    protected function modelSave($data) : bool
    {
        return $this->model->save($data);
    }

    protected function modelFind($id = null)
    {
        return $this->model->find($id);
    }

    protected function modelFindAll(int $limit = 0, int $offset = 0)
    {
        return $this->model->findAll($limit, $offset);
    }

    public function modelDelete($id = null, bool $purge = false)
    {
        return $this->model->delete($id, $purge);
    }

    public function modelInsertID()
    {
        return $this->model->insertID();
    }

    public function modelIdValue($data)
    {
        return $this->model->idValue($data);
    }

    public function modelReturnType()
    {
        return $this->model->returnType;
    }

    public function modelPrimaryKey()
    {
        return $this->model->primaryKey;
    }

    public function modelAllowedFields()
    {
        return $this->model->allowedFields;
    }


}