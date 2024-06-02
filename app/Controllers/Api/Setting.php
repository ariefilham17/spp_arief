<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Setting extends ResourceController
{

    use ResponseTrait;

    protected $modelName = 'App\Models\SettingModel';
    protected $format    = 'json';

    public function update_setting()
    {
        $data   = $this->request->getPost();

        foreach ($data as $key => $value) {
            $this->model->where('kunci', $key)->set('nilai', $value)->update();
        }

        $response   = [
            'status'    => 200,
            'error'     => null,
            'messages'  => [
                'success'   => 'Berhasil Memperbaharui pengaturan'
            ]
        ];

        return $this->respondCreated($response);
    }
}
