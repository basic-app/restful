<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

trait ResourceControllerTrait
{

    public function respondDeleted($data = null, string $message = '')
    {
        $data['status'] = 'DELETED';

        return parent::respondDeleted($data, $message);
    }

    public function respondUpdated($data = null, string $message = '')
    {
        $data['status'] = 'UPDATED';

        return parent::respondUpdated($data, $message);
    }

    public function respondCreated($data = null, string $message = '')
    {
        $data['status'] = 'CREATED';

        return parent::respondCreated($data, $message);
    }

    public function respondError(array $data, $code = null, string $message = '')
    {
        $data['status'] = 'ERROR';

        if (!$code)
        {
            $code = $this->codes['server_error'];
        }

        return $this->respond($data, $code, $message);
    }

    public function respondOk(array $data, $code = null, string $message = '')
    {
        $data['status'] = 'OK';

        if (!$code)
        {
            $code = 200;
        }

        return $this->respond($data, $code, $message);
    }

    public function respondInvalidData(array $data, string $message = '')
    {
        return $this->respondError($data, $this->codes['invalid_data'], $message);
    }

}