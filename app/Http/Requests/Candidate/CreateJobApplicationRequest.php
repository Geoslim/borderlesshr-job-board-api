<?php

namespace App\Http\Requests\Candidate;

use App\Traits\HandlesJsonResponses;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobApplicationRequest extends FormRequest
{
    use HandlesJsonResponses;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'cover_letter' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'resume' =>  ['required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
        ];
    }

    /**
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cover_letter.file' => 'The cover letter must be a file.',
            'cover_letter.mimes' => 'The cover letter must be a PDF, DOC, or DOCX file.',
            'cover_letter.max' => 'The cover letter may not be greater than 5MB.',

            'resume.required' => 'A resume file is required.',
            'resume.file' => 'The resume must be a file.',
            'resume.mimes' => 'The resume must be a PDF, DOC, or DOCX file.',
            'resume.max' => 'The resume may not be greater than 10MB.',
        ];
    }
}
