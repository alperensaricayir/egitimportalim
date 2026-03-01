<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_paid' => 'required|boolean',
            'price' => 'nullable|numeric|min:0|required_if:is_paid,1',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'remove_thumbnail' => 'sometimes|boolean',
        ];
    }
}
