<?php


namespace App\Controller;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class testClientController
{
    #[Route('/', name: 'action')]
    public function __invoke()
    {
        $client = HttpClient::create();
        $call1 = $client->request('GET', 'https://httpstat.us/404');
        $call2 = $client->request('GET', 'https://httpstat.us/401');
        $call3 = $client->request('GET', 'https://httpstat.us/400');


        try {
            $content = sprintf(
                '{"call1": %s, "call2": %s, "call3": %s}',
                $call1->getContent(),
                $call2->getContent(),
                $call3->getContent()
            );
        } catch (\Exception $e) {
            throw new BadRequestHttpException('Invalid JSON response');
        }
        return new JsonResponse($content, Response::HTTP_PARTIAL_CONTENT, [], true);
    }

}