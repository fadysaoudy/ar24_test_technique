<?php

namespace App\Services;

use App\Contracts\ApiResponseHandlerInterface;
use App\Contracts\EmailServiceInterface;
use App\Contracts\HttpWrapperInterface;
use App\Http\Requests\DTO\Email\EmailSendRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Catch_;

class EmailService implements EmailServiceInterface
{

    public function __construct(protected HttpWrapperInterface $httpWrapper, protected ApiResponseHandlerInterface $responseHandler)
    {

    }

    /**
     * @param EmailSendRequest $request
     * @throws Exception
     */
    public function store(EmailSendRequest $request)
    {
        $headers = ['Content-Type' => 'multipart/form-data'];
        try {
          $this->httpWrapper->post('/mail/', $request, $headers, true);

        }
        catch (Exception $e) {
            Log::error($e);
            throw new Exception($e->getMessage());
        }

    }
}
