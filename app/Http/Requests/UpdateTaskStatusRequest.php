<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(TaskStatus::class)],
        ];
    }
}
