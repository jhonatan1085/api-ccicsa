<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *          title="Cicsa Api",
 *          description="Cicsa Controller",
 *          version="1"
 * )
 * @OA\Server(
 *          url="http://localhost:8080/api",
 *          description="Servidor Local"
 * )
 * @OA\Server(
 *          url="https://cicsa.situaweb.com/public/api",
 *          description="Servidor de Producción"
 * )
 * @OA\SecurityScheme(
 *    securityScheme="bearerAuth",
 *    in="header",
 *    name="bearerAuth",
 *    type="http",
 *    scheme="bearer",
 *    bearerFormat="JWT"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
