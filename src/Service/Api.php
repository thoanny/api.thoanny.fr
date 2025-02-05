<?php namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class Api {
    private function createResponse($code = 200, $message = 'OK'): JsonResponse
    {
        return new JsonResponse(['code' => $code, 'message' => $message], $code);
    }
    public function createForbiddenException(string $message = 'Forbidden'): JsonResponse
    {
        return $this->createResponse(403, $message);
    }

    public function createNotFoundException(string $message = 'Not found'): JsonResponse
    {
        return $this->createResponse(404, $message);
    }
}
