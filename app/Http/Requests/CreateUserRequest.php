<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
      // 'name' => 'alpha_num|required|min:2|max:20',
      // 'email' => 'required|unique:users|email',
      // 'password' => 'required|string|min:8',
      'name' => 'alpha_num|min:2|max:20',
      'email' => 'unique:users|email',
      'password' => 'string|min:8',
    ];
  }
  public function messages()
  {
    return [
      'name.required' => 'The name field is required.',
      'name.string' => 'The name field must be a string.',
      'name.max' => 'The name field must not exceed 20 characters.',
      'email.required' => 'The email field is required.',
      'email.email' => 'Please enter a valid email address.',
      'email.unique' => 'The email address is already in use.',
      'password.required' => 'The password field is required.',
      'password.string' => 'The password field must be a string.',
      'password.min' => 'The password must be at least 8 characters long.',
      'password.confirmed' => 'The password confirmation does not match.',
    ];
  }
}
