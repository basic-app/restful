<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

trait ResourceControllerTrait
{

    public function respondUpdated($data = null, string $message = '')
    {
        $data['status'] = 'UPDATED';

        return parent::respondUpdated($data, 'UPDATED MESSAGE');
    }

    public function respondCreated($data = null, string $message = '')
    {
        $data['status'] = 'CREATED';

        return parent::respondCreated($data, 'MESSAGE CREATED');
    }

    public function respondError(array $data, $code = null)
    {
        $data['status'] = 'ERROR';

        if (!$code)
        {
            $code = $this->codes['server_error'];
        }

        return $this->respond($data, $code);
    }

    public function respondOk(array $data, $code = null)
    {
        $data['status'] = 'OK';

        if (!$code)
        {
            $code = 200;
        }

        return $this->respond($data, $code, 'MESSAGE OK');
    }

    public function respondInvalidData(array $data)
    {
        return $this->respondError($data, $this->codes['invalid_data']);
    }

}