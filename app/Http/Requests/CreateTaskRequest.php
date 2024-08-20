<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true; 
    }

   
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|string|in:not started,in progress,completed',
            'priority' => 'required|string|in:low,medium,high',
            'category_id' => 'required|exists:categories,id',
            'team_id' => 'required|exists:teams,id',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
    


    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            
            'start_date.required' => 'The start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            
            'end_date.required' => 'The end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be on or after the start date.',
            
            'status.required' => 'The status is required.',
            'status.string' => 'The status must be a string.',
            'status.in' => 'The status must be one of the following: not started, in progress, completed.',
            
            'priority.required' => 'The priority is required.',
            'priority.string' => 'The priority must be a string.',
            'priority.in' => 'The priority must be one of the following: low, medium, high.',
            
            'category_id.required' => 'The category is required.',
            'category_id.exists' => 'The selected category does not exist.',
            
            'team_id.required' => 'The team is required.',
            'team_id.exists' => 'The selected team does not exist.',
            
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}
