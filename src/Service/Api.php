<?php namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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

    public function createConflictException(string $message = 'Conflict'): JsonResponse
    {
        return $this->createResponse(409, $message);
    }

    public function createBadRequestException(string $message = 'Bad request'): JsonResponse
    {
        return $this->createResponse(400, $message);
    }

    public function respondCreated(string $message = 'Created'): JsonResponse
    {
        return $this->createResponse(201, $message);
    }

    public function respondOk(string $message = 'Ok'): JsonResponse
    {
        return $this->createResponse(200, $message);
    }

    public function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);
        return $request;
    }
}
