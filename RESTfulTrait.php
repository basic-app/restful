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

    public function callModel($method, $customFunctionName, ...$params)
    {
        if (method_exists($this, $customFunctionName))
        {
            return $this->{$customFunctionName}(...$params);
        }
        else
        {
            return $this->model->$method(...$params);
        }
    }

    public function callFormModel($method, $customFunctionName, ...$params)
    {
        if (method_exists($this, $customFunctionName))
        {
            return $this->{$customFunctionName}(...$params);
        }
        else
        {
            return $this->formModel->$method(...$params);
        }
    }

}