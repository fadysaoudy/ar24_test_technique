<?php

namespace App\Http\Controllers;

use App\Http\Requests\DTO\Attachment\AttachmentUploadRequest;
use App\Services\AttachmentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __construct(
        protected AttachmentService $attachmentService,

    )
    {
    }
    public function index(): View
    {
        return view('pages.users.attachment.index');
    }

    /**
     * @throws \Exception
     */
    public function store(AttachmentUploadRequest $request)
    {
        return $this->attachmentService->store($request);
    }
}
