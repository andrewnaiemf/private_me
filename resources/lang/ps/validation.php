<?php

return [
    'docx' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .docx o .doc',
    'potm' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .potm',
    'ppsm' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .ppsm',
    'sldm' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .sldm',
    'pptm' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .pptm',
    'ppam' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .ppam',
    'ppt' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .ppt',
    'xltx' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .xltx',
    'xlsx' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .xlsx',
    'xls' => 'El campo :attribute debe ser un archivo de tipo Microsoft Office .xls',
    'office' => 'El campo :attribute debe ser un archivo de tipos Microsoft Office siguientes: docx, potm, ppsm, sldm, pptm, ppam, ppt, xltx, xlsx, xls',

    'pdf' => 'El campo :attribute debe ser un archivo de tipo .pdf',
    'video' => 'El campo :attribute debe ser un archivo de video de los siguientes tipos: vob, avi, wmv, mkv, mk3d, mks, webm, 3gp, qt, mov, mpeg, mpg, mpe, m1v, m2v, mp4, mp4v, mpg4',
    'mp4' => 'El campo :attribute debe ser un archivo de video de tipo mp4, mp4v, mpg4',
    'mpeg' => 'El campo :attribute debe ser un archivo de video de tipo mpeg, mpg, mpe, m1v, m2v',
    'mov' => 'El campo :attribute debe ser un archivo de video de tipo qt, mov',
    '3gp' => 'El campo :attribute debe ser un archivo de video de tipo .3gp',
    'webm' => 'El campo :attribute debe ser un archivo de video de tipo .webm',
    'mkv' => 'El campo :attribute debe ser un archivo de video de tipo .mkv, mk3d, mks',
    'wmv' => 'El campo :attribute debe ser un archivo de video de tipo .wmv',
    'avi' => 'El campo :attribute debe ser un archivo de video de tipo .avi',
    'vob' => 'El campo :attribute debe ser un archivo de video de tipo .vob',
    'audio' => 'El campo :attribute debe ser un archivo de audio de los siguientes tipos: xm, wav, ogg, adp, mp3',
    'mp3' => 'El campo :attribute debe ser un archivo de audio de los siguientes tipos: mpga, mp2, mp2a, mp3, m2a, m3a',
    'xm' => 'El campo :attribute debe ser un archivo de audio de tipo xm',
    'wav' => 'El campo :attribute debe ser un archivo de audio de tipo wav',
    'ogg' => 'El campo :attribute debe ser un archivo de audio de tipo ogg',
    'adp' => 'El campo :attribute debe ser un archivo de audio de tipo adp',

    'accepted' => 'El campo :attribute debe ser aceptado',
    'active_url' => 'El campo :attribute no es una URL válida',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El campo :attribute solo debe contener letras',
    'alpha_dash' => 'El campo :attribute solo debe contener letras, números y guiones',
    'alpha_num' => 'El campo :attribute solo debe contener letras y números',
    'array' => 'El campo :attribute debe ser un arreglo',

 'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El valor de :attribute debe estar entre :min y :max.',
        'file' => 'El tamaño del archivo :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El número de caracteres en :attribute debe estar entre :min y :max.',
        'array' => ':attribute debe contener entre :min y :max elementos.',
    ],
    'boolean' => 'El valor del campo :attribute debe ser verdadero (true) o falso (false).',
    'confirmed' => 'El campo de confirmación no coincide con el campo :attribute.',
    'date' => ':attribute no es una fecha válida.',
    'date_format' => ':attribute no coincide con el formato :format.',
    'different' => ':attribute y :other deben ser diferentes.',
    'digits' => ':attribute debe contener :digits dígitos.',
    'digits_between' => ':attribute debe contener entre :min y :max dígitos.',
    'dimensions' => ':attribute tiene dimensiones de imagen inválidas.',
    'distinct' => 'El valor del campo :attribute está duplicado.',
    'email' => ':attribute debe ser una dirección de correo electrónico válida.',
    'exists' => 'El valor seleccionado para :attribute es inválido.',
    'file' => ':attribute debe ser un archivo.',
    'filled' => 'El campo :attribute es obligatorio.',
    'image' => ':attribute debe ser una imagen.',
    'in' => ':attribute seleccionado es inválido.',
    'in_array' => ':attribute no existe en :other.',
    'integer' => ':attribute debe ser un número entero.',
    'ip' => ':attribute debe ser una dirección IP válida.',
    'ipv4' => ':attribute debe ser una dirección IPv4 válida.',
    'ipv6' => ':attribute debe ser una dirección IPv6 válida.',
    'json' => ':attribute debe ser una cadena JSON válida.',
    'max' => [
        'numeric' => 'El valor de :attribute no debe ser mayor a :max.',
        'file' => 'El tamaño del archivo :attribute no debe ser mayor a :max kilobytes.',
        'string' => 'El texto en :attribute no debe exceder :max caracteres.',
        'array' => ':attribute no debe contener más de :max elementos.',
    ],

    'mimes' => 'El archivo :attribute debe ser del tipo: :values.',
    'mimetypes' => 'El archivo :attribute debe ser del tipo: :values.',
    'min' => [
        'numeric' => 'El valor de :attribute debe ser igual o mayor a :min.',
        'file' => 'El tamaño del archivo :attribute debe ser de al menos :min kilobytes.',
        'string' => 'La longitud del texto en :attribute debe ser de al menos :min caracteres.',
        'array' => ':attribute debe contener al menos :min elemento(s).',
    ],
    'not_in' => ':attribute es inválido.',
    'numeric' => ':attribute debe ser un número.',
    'present' => ':attribute debe estar presente.',
    'regex' => 'El formato de :attribute es inválido.',
    'required' => ':attribute es obligatorio.',
    'required_if' => ':attribute es obligatorio cuando :other es igual a :value.',
    'required_unless' => ':attribute es obligatorio a menos que :other sea igual a :values.',
    'required_with' => ':attribute es obligatorio cuando :values está presente.',
    'required_with_all' => ':attribute es obligatorio cuando :values están presentes.',
    'required_without' => ':attribute es obligatorio cuando :values no está presente.',
    'required_without_all' => ':attribute es obligatorio cuando ninguno de :values está presente.',
    'same' => ':attribute y :other deben ser iguales.',
    'size' => [
        'numeric' => 'El valor de :attribute debe ser igual a :size.',
        'file' => 'El tamaño del archivo :attribute debe ser de :size kilobytes.',
        'string' => 'El texto en :attribute debe contener :size caracteres.',
        'array' => ':attribute debe contener :size elemento(s).',
    ],
    'string' => ':attribute debe ser una cadena de caracteres.',
    'timezone' => ':attribute debe ser una zona horaria válida.',
    'unique' => ':attribute ya ha sido tomado.',
    'uploaded' => 'La carga de :attribute ha fallado.',
    'url' => 'El formato de la URL :attribute es inválido.',
    'lt' => [
        'numeric' => ':attribute debe ser menor que :value.',
        'file' => ':attribute debe ser menor que :value kilobytes.',
        'string' => ':attribute debe contener menos de :value caracteres.',
        'array' => ':attribute debe contener menos de :value elemento(s).',
    ],
    'lte' => [
        'numeric' => ':attribute debe ser menor o igual a :value.',
        'file' => ':attribute debe ser menor o igual a :value kilobytes.',
        'string' => ':attribute debe contener menos o igual a :value caracteres.',
        'array' => ':attribute no debe contener más de :value elemento(s).',
    ],
    'gt' => [
        'numeric' => ':attribute debe ser mayor que :value.',
        'file' => ':attribute debe ser mayor que :value kilobytes.',
        'string' => ':attribute debe contener más de :value caracteres.',
        'array' => ':attribute debe contener más de :value elemento(s).',
    ],
    'gte' => [
        'numeric' => ':attribute debe ser mayor o igual a :value.',
        'file' => ':attribute debe ser mayor o igual a :value kilobytes.',
        'string' => ':attribute debe contener al menos :value caracteres.',
        'array' => ':attribute debe contener al menos :value elemento(s).',
    ],
/*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
*/
'custom' => [
    'attribute-name' => [
        'rule-name' => 'mensaje-personalizado',
    ],
],

/*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
*/

'attributes' => [
    'name' => 'Nombre',
    'username' => 'Nombre de usuario',
    'email' => 'Dirección de correo electrónico',
    'first_name' => 'Nombre',
    'last_name' => 'Apellido',
    'password' => 'Contraseña',
    'password_confirmation' => 'Confirmación de contraseña',
    'city' => 'Ciudad',
    'country' => 'País',
    'address' => 'Dirección',
    'phone' => 'Teléfono',
    'mobile' => 'Móvil',
    'age' => 'Edad',
    'sex' => 'Género',
    'gender' => 'Género',
    'day' => 'Día',
    'month' => 'Mes',
    'year' => 'Año',
    'hour' => 'Hora',
    'minute' => 'Minuto',
    'second' => 'Segundo',
    'title' => 'Título',
    'content' => 'Contenido',
    'description' => 'Descripción',
    'excerpt' => 'Extracto',
    'date' => 'Fecha',
    'time' => 'Hora',
    'available' => 'Disponible',
    'size' => 'Tamaño',
],
];
