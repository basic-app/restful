<?php
/**
 * @author basic-app <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\RESTful;

trait ResourceControllerTrait
{

    public function prepareResponse(array $data) : array
    {
        return $data;
    }

    public function respondDeleted($data = null, string $message = '')
    {
        $data['status'] = 'DELETED';

        $data = $this->prepareResponse($data);

        return parent::respondDeleted($data, $message);
    }

    public function respondUpdated($data = null, string $message = '')
    {
        $data['status'] = 'UPDATED';

        $data = $this->prepareResponse($data);

        return parent::respondUpdated($data, $message);
    }

    public function respondCreated($data = null, string $message = '')
    {
        $data['status'] = 'CREATED';

        $data = $this->prepareResponse($data);

        return parent::respondCreated($data, $message);
    }

    public function respondError(array $data, $code = null, string $message = '')
    {
        $data['status'] = 'ERROR';

        if (!$code)
        {
            $code = $this->codes['server_error'];
        }

        $data = $this->prepareResponse($data);

        return $this->respond($data, $code, $message);
    }

    public function respondOK(array $data, $code = null, string $message = '')
    {
        $data['status'] = 'OK';

        if (!$code)
        {
            $code = 200;
        }

        $data = $this->prepareResponse($data);

        return $this->respond($data, $code, $message);
    }

    public function respondInvalidData(array $data, string $message = '')
    {
        $data = $this->prepareResponse($data);
        
        return $this->respondError($data, $this->codes['invalid_data'], $message);
    }

}