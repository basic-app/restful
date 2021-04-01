<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;

class ShowAction extends \BasicApp\Action\BaseAction
{

    public $findOne = 'modelFindOne';

    public function _remap($method, ...$params)
    {
        $action = $this;

        return function($method, $id) use ($action)
        {
            if ($action->findOne && method_exists($this, $action->findOne))
            {
                $data = $this->{$action->findOne}($id);
            }
            else
            {
                $data = $this->model->findOne($id);
            }

            if (!$data)
            {
                return $this->failNotFound();
            }

            return $this->respondOk([
                'data' => $data->toArray()
            ]);
        };
    }

}