<?php

namespace App\Controllers;

use App\Models\SettingModel;

class Setting extends BaseController
{
    public function index()
    {
        $model      = new SettingModel();
        $setting    = $model->where('status', 1)->get()->getResultArray() ?? [];

        $data   = [
            'page'      => "Setting",
            'title'     => 'Setting',
            'data'      => compact('setting')
        ];

        return view('page/setting/index', $data);
    }
}
