<?php
// lang/en/validation.php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    */

    'required'  => 'The :attribute field is required.',
    'unique'    => 'This :attribute has already been taken.',
    'image'     => 'The :attribute must be an image.',
    'mimes'     => 'The :attribute must be a file of type: :values.',
    'url'       => 'The :attribute must be a valid URL.',
    'boolean'   => 'The :attribute field must be true or false.',
    'date'      => 'The :attribute is not a valid date.',
    'confirmed' => 'The :attribute confirmation does not match.',
    
    'max' => [
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'numeric' => 'The :attribute may not be greater than :max.',
    ],
    'min' => [
        'string'  => 'The :attribute must be at least :min characters.',
        'numeric' => 'The :attribute must be at least :min.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'title'           => 'Title',
        'excerpt'         => 'Excerpt',
        'source_url'      => 'Source URL',
        'password'        => 'Password',
        'email'           => 'Email Address',
        'name'            => 'Name',
        
        'image_url'       => 'Image',
        'logo_url'        => 'Logo',
        'avatar_url'      => 'Avatar',
        'cover_url'       => 'Cover Image',
        'icon_url'        => 'Icon',
        'hero_image_url'  => 'Hero Image',
        'photo'           => 'Photo',
    ],
];
