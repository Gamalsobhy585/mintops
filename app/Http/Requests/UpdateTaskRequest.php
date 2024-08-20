<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'status' => 'sometimes|in:completed,in progress,not started',
            'priority' => 'sometimes|in:low,medium,high',
            'category_id' => 'sometimes|exists:categories,id',
            'team_id' => 'sometimes|exists:teams,id',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'start_date.date' => 'The start date must be a valid date.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
            'status.in' => 'The status must be one of the following: completed, in progress, not started.',
            'priority.in' => 'The priority must be one of the following: low, medium, high.',
            'category_id.exists' => 'The selected category does not exist.',
            'team_id.exists' => 'The selected team does not exist.',
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}
