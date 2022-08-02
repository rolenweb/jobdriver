<?php

declare(strict_types=1);

namespace App\Parsers\Parser;

use Illuminate\Http\Client\Response;

class ParserResponse
{
    private Response $response;

    private array $result;

    /**
     * @param Response $response
     * @param array $result
     */
    public function __construct(Response $response, array $result)
    {
        $this->response = $response;
        $this->result = $result;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}
