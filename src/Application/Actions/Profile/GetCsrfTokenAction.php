<?php
declare(strict_types=1);

namespace App\Application\Actions\Profile;

use App\Application\Actions\Action;
use App\Domain\Auth\Service\AuthService;
use App\Domain\User\Persistence\UserRepository;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Selective\Csrf\CsrfMiddleware;
use Slim\Exception\HttpBadRequestException;

/**
 * Class GetCsrfTokenAction
 * @package App\Application\Actions\Profile
 */
class GetCsrfTokenAction extends Action
{
    private CsrfMiddleware $csrfMiddleware;

    public function __construct(
        LoggerInterface $logger,
        CsrfMiddleware $csrfMiddleware
    )
    {
        parent::__construct($logger);
        $this->csrfMiddleware = $csrfMiddleware;
    }

    /**
     * @return Response
     * @throws Exception
     */
    protected function action(): Response
    {
        $token = $this->csrfMiddleware->getToken();
        $this->response = $this->response->withHeader('X-CSRF-Token', $token);

        return $this->respondWithData(null, 200);
    }
}
