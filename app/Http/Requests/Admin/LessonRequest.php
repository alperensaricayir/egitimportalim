<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url|max:2048',
            'order' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_preview' => 'sometimes|boolean',
        ];
    }
}

