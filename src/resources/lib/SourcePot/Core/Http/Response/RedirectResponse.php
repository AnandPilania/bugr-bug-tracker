<?php

namespace SourcePot\Core\Http\Response;

class RedirectResponse extends BasicResponse
{
    protected int $statusCode = 301;
    protected array $headers = [];
    
    // Because this returns a 'self', the function needs to be present on the implementing class
    public static function create(): self
    {
        return new self;
    }

    public function setBody(string $body): self
    {
        // as this is a redirect response, take the content of $body to be a url to redirect to
        $this->setHeader('location', $body);
        
        return $this;
    }
}
