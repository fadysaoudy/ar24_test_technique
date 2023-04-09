<?php

namespace App\Services;

use App\Contracts\AttachmentServiceInterface;
use App\Contracts\HttpWrapperInterface;
use App\Exceptions\AttachmentEmptyNameException;
use App\Exceptions\AttachmentMissingFileException;
use App\Exceptions\AttachmentToBigException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\DTO\Attachment\AttachmentUploadRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class AttachmentService implements AttachmentServiceInterface
{
    public function __construct(protected HttpWrapperInterface $httpWrapper)
    {

    }

    /**
     * @throws Exception
     */
    public function store(AttachmentUploadRequest $request): string
    {
        try {
            $headers = ['Content-Type' => 'multipart/form-data'];
            $response = $this->httpWrapper->post('/attachment', $request, $headers, true);
        } catch (UserNotFoundException $e) {
            Log::error($e);
            throw  UserNotFoundException::NotFound();
        } catch (AttachmentEmptyNameException $e) {
            Log::error($e);
            throw  AttachmentEmptyNameException::EmptyName();
        } catch (AttachmentMissingFileException $e) {
            Log::error($e);
            throw  AttachmentMissingFileException::MissingFile();
        } catch (AttachmentToBigException $e) {
            Log::error($e);
            throw  AttachmentToBigException::tooBig();
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e->getMessage());
        }

        return $response;

    }
}
