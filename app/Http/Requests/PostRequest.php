<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'content' => 'required|string',
            'description' => 'nullable|string|max:200',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'publish_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.string' => 'Tiêu đề phải là một chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá 100 ký tự.',
            'content.required' => 'Vui lòng nhập nội dung.',
            'content.string' => 'Nội dung phải là một chuỗi.',
            'description.string' => 'Mô tả phải là một chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 200 ký tự.',
            'thumbnail.image' => 'Tệp tải lên phải là hình ảnh.',
            'thumbnail.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
            'thumbnail.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'publish_date.date' => 'Ngày xuất bản không hợp lệ.',
        ];
    }
}
