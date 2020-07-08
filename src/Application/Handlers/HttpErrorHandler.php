<?php
declare(strict_types=1);

namespace App\Application\Handlers;

use App\Application\Actions\ActionPayload;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Throwable;

class HttpErrorHandler extends SlimErrorHandler
{

    /**
     * @inheritdoc
     */
    protected function respond(): Response
    {
        /** @var Exception $exception */
        $exception = $this->exception;
        $statusCode = $exception->getCode() ?? 500;
        if ($statusCode < 200 || $statusCode > 500) $statusCode = 500;

        $data['message'] = $exception->getMessage();
        if (IS_DEV_MODE) $data['trace'] = $exception->getTrace();

        $payload = new ActionPayload($statusCode, $data);
        $encodedPayload = json_encode($payload, JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write($encodedPayload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
