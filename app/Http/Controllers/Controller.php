<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $id
     * @param string $message
     * @return mixed
     */
    public function checkAndGet($id, $message = '')
    {
        $table = $this->model->getTable();
        $config = config("status.{$table}");
        $info = $this->model->find($id);
        if (!$info || $info->status != $config['available']) {
            abort(404, $message ? $message : "This {$table} does not exist.");
        }
        return $info;
    }
}
