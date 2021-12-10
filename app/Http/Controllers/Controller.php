<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="http://localhost:8100"),
 * @OA\Info(title="Challenge-Backend", version="0.0.1",
 *
 *     @OA\Contact(email="danilo.britoxd@hotmail.com", name="Danilo Brito"),
 * )
 *
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
