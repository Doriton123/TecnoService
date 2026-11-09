
<?php

return [
    'accepted' => 'El campo :attribute debe ser aceptado.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El campo :attribute solo puede contener letras.',
    'alpha_num' => 'El campo :attribute solo puede contener letras y números.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'confirmed' => 'La confirmación de :attribute no coincide.',
    'date' => 'El campo :attribute debe contener una fecha válida.',
    'different' => 'Los campos :attribute y :other deben ser diferentes.',
    'digits' => 'El campo :attribute debe contener :digits dígitos.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'exists' => 'El valor seleccionado para :attribute no es válido.',
    'in' => 'El valor seleccionado para :attribute no es válido.',
    'integer' => 'El campo :attribute debe ser un número entero.',
    'numeric' => 'El campo :attribute debe ser numérico.',
    'required' => 'El campo :attribute es obligatorio.',
    'same' => 'El campo :attribute debe coincidir con :other.',
    'string' => 'El campo :attribute debe ser texto.',
    'unique' => 'El valor de :attribute ya se encuentra registrado.',
    'url' => 'El campo :attribute debe ser una dirección URL válida.',

    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
        'numeric' => 'El campo :attribute debe ser como mínimo :min.',
        'array' => 'El campo :attribute debe contener al menos :min elementos.',
        'file' => 'El archivo :attribute debe tener al menos :min kilobytes.',
    ],

    'max' => [
        'string' => 'El campo :attribute no debe superar :max caracteres.',
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'array' => 'El campo :attribute no debe contener más de :max elementos.',
        'file' => 'El archivo :attribute no debe superar :max kilobytes.',
    ],

    'between' => [
        'string' => 'El campo :attribute debe tener entre :min y :max caracteres.',
        'numeric' => 'El campo :attribute debe estar entre :min y :max.',
        'array' => 'El campo :attribute debe contener entre :min y :max elementos.',
        'file' => 'El archivo :attribute debe tener entre :min y :max kilobytes.',
    ],

    'attributes' => [
        'nombre_completo' => 'nombre completo',
        'nit' => 'NIT',
        'telefono' => 'teléfono',
        'direccion' => 'dirección',
        'correo_electronico' => 'correo electrónico',
        'tipo_equipo' => 'tipo de equipo',
        'marca' => 'marca',
        'modelo' => 'modelo',
        'numero_serie' => 'número de serie',
        'cliente_id' => 'cliente',
        'equipo_id' => 'equipo',
        'fecha_recepcion' => 'fecha de recepción',
        'tipo_servicio' => 'tipo de servicio',
        'descripcion_problema' => 'descripción del problema',
        'observaciones' => 'observaciones',
        'estado' => 'estado',
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de contraseña',
        'rol' => 'rol',
        'fecha_inicio' => 'fecha inicial',
        'fecha_fin' => 'fecha final',
    ],

    'custom' => [
        'nit' => [
            'unique' => 'El NIT ingresado ya se encuentra registrado.',
        ],
        'correo_electronico' => [
            'unique' => 'Este correo electrónico ya se encuentra registrado.',
        ],
        'numero_serie' => [
            'unique' => 'Este número de serie ya se encuentra registrado.',
        ],
    ],
];
