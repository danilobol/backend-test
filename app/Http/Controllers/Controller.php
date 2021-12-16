<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="http://localhost:8100"),
 * @OA\Link (description="Tutorial", ref="Tutorial", operationId="tutorial", link="https://github.com/danilobol/backend-test/blob/development/Tutorial.pdf"),
 * @OA\Info(title="Challenge-Backend", version="0.0.1",
 *
 *     @OA\Contact(email="danilo.britoxd@hotmail.com", name="Danilo Brito"),
 *     @OA\Contact(name="https://github.com/danilobol/backend-test/blob/development/Tutorial.pdf"),
 *
 * )
 *
 *
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
