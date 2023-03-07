<?php
    
    namespace App\Classes;
    
    use Symfony\Contracts\HttpClient\HttpClientInterface;
    use Symfony\Contracts\HttpClient\ResponseInterface;
    use Symfony\Contracts\HttpClient\ResponseStreamInterface;
    use Symfony\Component\HttpClient\HttpClient;
    
    class MyExtendedHttpClient implements HttpClientInterface
    {
        private $decoratedClient;

        public function __construct(HttpClientInterface $decoratedClient = null)
        {
            $this->decoratedClient = $decoratedClient ?? HttpClient::create();
        }

        public function request(string $method, string $url, array $options = []): ResponseInterface
        {
            // process and/or change the $method, $url and/or $options as needed
            $response = $this->decoratedClient->request($method, $url, $options);

            // if you call here any method on $response, the HTTP request
            // won't be async; see below for a better way

            return $response;
        }
        
        public function stream($responses, float $timeout = null): ResponseStreamInterface
        {
            return $this->decoratedClient->stream($responses, $timeout);
        }
        
        public function withOptions(array $options): static
        {
            
        }
    }
    
?>
