<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait HandlesChatAttachments
{
    protected function chatAttachmentRules(): array
    {
        return [
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,wmv,pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:25600',
        ];
    }

    protected function chatAttachmentMessages(): array
    {
        return [
            'attachment.file' => 'The selected attachment is invalid.',
            'attachment.mimes' => 'Only images, videos, and common document files are allowed.',
            'attachment.max' => 'The selected file is too large. Maximum allowed size is 25 MB.',
        ];
    }

    protected function storeChatAttachment(Request $request): array
    {
        /** @var UploadedFile|null $file */
        $file = $request->file('attachment');

        if (!$file) {
            return [];
        }

        $mime = $file->getClientMimeType() ?: 'application/octet-stream';
        $attachmentType = $this->resolveAttachmentType($mime);

        $resourceType = match ($attachmentType) {
            'image' => 'image',
            'video' => 'video',
            default => 'raw',
        };

        $uploadResult = Cloudinary::uploadApi()->upload(
            $file->getRealPath(),
            [
                'folder' => 'e-pacd/chat-attachments',
                'resource_type' => $resourceType,
                'use_filename' => true,
                'unique_filename' => true,
                'overwrite' => false,
            ]
        );

        return [
            'attachment_path' => $uploadResult['secure_url'] ?? null,
            'attachment_name' => $file->getClientOriginalName(),
            'attachment_mime' => $mime,
            'attachment_type' => $attachmentType,
        ];
    }

    protected function resolveAttachmentType(string $mime): string
    {
        if (str_starts_with($mime, 'image/')) {
            return 'image';
        }

        if (str_starts_with($mime, 'video/')) {
            return 'video';
        }

        return 'document';
    }
}
