<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\Auth\Service\JwtAuth;
use App\Domain\Services\AccessService;
use App\Domain\User\UserEntity;
use Doctrine\ORM\EntityManager;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Class JwtAuthMiddleware
 * @package App\Application\Middleware
 */
final class JwtAuthMiddleware implements Middleware
{
    private JwtAuth $jwtAuth;

    private EntityManager $em;

    /**
     * The constructor.
     *
     * @param JwtAuth $jwtAuth The JWT auth
     * @param EntityManager $em
     */
    public function __construct(
        JwtAuth $jwtAuth,
        EntityManager $em
    ) {
        $this->jwtAuth = $jwtAuth;
        $this->em = $em;
    }

    /**
     * Invoke middleware.
     *
     * @param ServerRequestInterface $request The request
     * @param RequestHandlerInterface $handler The handler
     *
     * @return ResponseInterface The response
     * @throws Exception
     */
    public function process(Request $request, RequestHandler $handler): Response {
//        if ($request->getMethod() === 'GET' && $request->getUri()->getPath() === '/api/resource/discipline') {
//            return $handler->handle($request);
//        }

        if (empty($_COOKIE['PHPSESSID']) || empty($_COOKIE['authtoken']) || empty($_SESSION['userid'])) {
            throw new Exception('Unauthorized', 401);
        }

        $token = $_COOKIE['authtoken'];

        if (empty($token) || !$this->jwtAuth->validateToken($token)) {
            throw new Exception('Unauthorized', 401);
        }

        setcookie('authtoken', $token, time() + getenv('AUTH_TTL'), '/', '', false, true);
        setcookie('authl', '1', time() + getenv('AUTH_TTL'), '/', '', false, false);

        /** @var UserEntity $authorizedUser */
        $authorizedUser = $this->em->getRepository(UserEntity::class)->find($_SESSION['userid']);
        AccessService::setUser($authorizedUser);

//        $authorizedUser = $this->em->getRepository(UserEntity::class)->find($_SESSION['userid']);
//        PermissionAccessService::setUser($authorizedUser);

        return $handler->handle($request);
    }
}
