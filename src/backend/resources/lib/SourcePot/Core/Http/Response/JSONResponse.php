<?php

namespace SourcePot\Core\Http\Response;

class JSONResponse extends BasicResponse
{
   protected int $statusCode = 200;
   protected array $headers = [
      'content-type' => 'application/json'
   ];

   // Because this returns a 'self', the function needs to be present on the implementing class
   public static function create(): self
   {
      return new self();
   }

   public function setBody(mixed $body): self
   {
      $body = json_encode($body);

      return parent::setBody($body);
   }
}
