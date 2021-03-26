<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful\Actions;

use CodeIgniter\Exceptions\PageNotFoundException;

class DeleteAction extends \BasicApp\Action\BaseAction
{

    public function _remap($method, ...$params)
    {
        return function($method, $id)
        {            
            assert($id ? true : false);

            $data = $this->modelFind($id);

            if (!$data)
            {
                return $this->failNotFound();
            }

            $id = $this->modelIdValue($data);

            assert($id ? true : false);

            $result = $this->modelDelete($id);

            assert($result);

            return $this->respondDeleted([
                'code' => $this->codes['deleted'],
                'message' => "DELETED"
            ]);
        };
    }

}