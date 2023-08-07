<?php

return [
    /*
        |--------------------------------------------------------------------------
        | Validation Language Lines
        |--------------------------------------------------------------------------
        |
        | The following language lines contain the default error messages used by
        | the validator class. Some of these rules have multiple versions such
        | as the size rules. Feel free to tweak each of these messages.
        |
    */

    'docx' => 'Le champ :attribute doit être un fichier de type Microsoft Office .docx ou .doc',
    'potm' => 'Le champ :attribute doit être un fichier de type Microsoft Office .potm',
    'ppsm' => 'Le champ :attribute doit être un fichier de type Microsoft Office .ppsm',
    'sldm' => 'Le champ :attribute doit être un fichier de type Microsoft Office .sldm',
    'pptm' => 'Le champ :attribute doit être un fichier de type Microsoft Office .pptm',
    'ppam' => 'Le champ :attribute doit être un fichier de type Microsoft Office .ppam',
    'ppt' => 'Le champ :attribute doit être un fichier de type Microsoft Office .ppt',
    'xltx' => 'Le champ :attribute doit être un fichier de type Microsoft Office .xltx',
    'xlsx' => 'Le champ :attribute doit être un fichier de type Microsoft Office .xlsx',
    'xls' => 'Le champ :attribute doit être un fichier de type Microsoft Office .xls',
    'office' => 'Le champ :attribute doit être un fichier de types Microsoft Office suivants : docx, potm, ppsm, sldm, pptm, ppam, ppt, xltx, xlsx, xls',

    'pdf' => 'Le champ :attribute doit être un fichier de type .pdf',
    'video' => 'Le champ :attribute doit être un fichier vidéo des types suivants : vob, avi, wmv, mkv, mk3d, mks, webm, 3gp, qt, mov, mpeg, mpg, mpe, m1v, m2v, mp4, mp4v, mpg4',
    'mp4' => 'Le champ :attribute doit être un fichier vidéo de type mp4, mp4v, mpg4',
    'mpeg' => 'Le champ :attribute doit être un fichier vidéo de type mpeg, mpg, mpe, m1v, m2v',
    'mov' => 'Le champ :attribute doit être un fichier vidéo de type qt, mov',
    '3gp' => 'Le champ :attribute doit être un fichier vidéo de type .3gp',
    'webm' => 'Le champ :attribute doit être un fichier vidéo de type .webm',
    'mkv' => 'Le champ :attribute doit être un fichier vidéo de type .mkv, mk3d, mks',
    'wmv' => 'Le champ :attribute doit être un fichier vidéo de type .wmv',
    'avi' => 'Le champ :attribute doit être un fichier vidéo de type .avi',
    'vob' => 'Le champ :attribute doit être un fichier vidéo de type .vob',
    'audio' => 'Le champ :attribute doit être un fichier audio des types suivants : xm, wav, ogg, adp, mp3',
    'mp3' => 'Le champ :attribute doit être un fichier audio des types suivants : mpga, mp2, mp2a, mp3, m2a, m3a',
    'xm' => 'Le champ :attribute doit être un fichier audio de type xm',
    'wav' => 'Le champ :attribute doit être un fichier audio de type wav',
    'ogg' => 'Le champ :attribute doit être un fichier audio de type ogg',
    'adp' => 'Le champ :attribute doit être un fichier audio de type adp',

    'accepted' => 'Le champ :attribute doit être accepté',
    'active_url' => 'Le champ :attribute n\'est pas une URL valide',
    'after' => 'Le champ :attribute doit être une date postérieure au :date.',
    'after_or_equal' => 'Le champ :attribute doit être une date postérieure ou égale au :date.',
    'alpha' => 'Le champ :attribute ne doit contenir que des lettres',
    'alpha_dash' => 'Le champ :attribute ne doit contenir que des lettres, des chiffres et des tirets',
    'alpha_num' => 'Le champ :attribute ne doit contenir que des lettres et des chiffres',
    'array' => 'Le champ :attribute doit être un tableau',
    'before' => 'Le champ :attribute doit être une date antérieure au :date.',
    'before_or_equal' => 'Le champ :attribute doit être une date antérieure ou égale au :date.',
    'between' => [
        'numeric' => 'La valeur de :attribute doit être comprise entre :min et :max.',
        'file' => 'La taille du fichier :attribute doit être comprise entre :min et :max kilo-octets.',
        'string' => 'Le nombre de caractères du texte :attribute doit être compris entre :min et :max.',
        'array' => ':attribute doit contenir un nombre d\'éléments compris entre :min et :max.',
    ],
    'boolean' => 'La valeur de :attribute doit être soit vrai (true) soit faux (false).',
    'confirmed' => 'Le champ de confirmation ne correspond pas au champ :attribute.',
    'date' => ':attribute n\'est pas une date valide.',
    'date_format' => ':attribute ne correspond pas au format :format.',
    'different' => ':attribute et :other doivent être différents.',
    'digits' => ':attribute doit contenir :digits chiffres.',
    'digits_between' => ':attribute doit contenir un nombre de chiffres compris entre :min et :max.',
    'dimensions' => ':attribute a des dimensions d\'image invalides.',
    'distinct' => 'La valeur de :attribute est en double.',
    'email' => ':attribute doit être une adresse e-mail valide.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'file' => ':attribute doit être un fichier.',
    'filled' => ':attribute est obligatoire.',
    'image' => ':attribute doit être une image.',
    'in' => ':attribute sélectionné est invalide.',
    'in_array' => ':attribute n\'existe pas dans :other.',
    'integer' => ':attribute doit être un nombre entier.',
    'ip' => ':attribute doit être une adresse IP valide.',
    'ipv4' => ':attribute doit être une adresse IPv4 valide.',
    'ipv6' => ':attribute doit être une adresse IPv6 valide.',
    'json' => ':attribute doit être une chaîne JSON valide.',
    'max' => [
        'numeric' => 'La valeur de :attribute ne doit pas être supérieure à :max.',
        'file' => 'La taille du fichier :attribute ne doit pas dépasser :max kilo-octets.',
        'string' => 'Le texte :attribute ne doit pas dépasser :max caractères.',
        'array' => ':attribute ne doit pas contenir plus de :max éléments.',
    ],
    'mimes' => 'Le fichier :attribute doit être de type : :values.',
'mimetypes' => 'Le fichier :attribute doit être de type : :values.',
'min' => [
    'numeric' => 'La valeur de :attribute doit être égale ou supérieure à :min.',
    'file' => 'La taille du fichier :attribute doit être d\'au moins :min kilo-octets.',
    'string' => 'La longueur du texte :attribute doit être d\'au moins :min caractères.',
    'array' => ':attribute doit contenir au moins :min élément(s).',
],
'not_in' => ':attribute est invalide.',
'numeric' => ':attribute doit être un nombre.',
'present' => ':attribute doit être présent.',
'regex' => 'Le format de :attribute est invalide.',
'required' => ':attribute est obligatoire.',
'required_if' => ':attribute est obligatoire lorsque :other est égal à :value.',
'required_unless' => ':attribute est obligatoire sauf si :other est égal à :values.',
'required_with' => ':attribute est obligatoire lorsque :values est présent.',
'required_with_all' => ':attribute est obligatoire lorsque :values sont présents.',
'required_without' => ':attribute est obligatoire lorsque :values n\'est pas présent.',
'required_without_all' => ':attribute est obligatoire lorsque aucun de :values n\'est présent.',
'same' => ':attribute et :other doivent être identiques.',
'size' => [
    'numeric' => 'La valeur de :attribute doit être égale à :size.',
    'file' => 'La taille du fichier :attribute doit être de :size kilo-octets.',
    'string' => 'Le texte :attribute doit contenir :size caractères.',
    'array' => ':attribute doit contenir :size élément(s).',
],
'string' => ':attribute doit être une chaîne de caractères.',
'timezone' => ':attribute doit être un fuseau horaire valide.',
'unique' => ':attribute est déjà pris.',
'uploaded' => 'Le téléchargement de :attribute a échoué.',
'url' => 'Le format de l\'URL :attribute est invalide.',
'lt' => [
    'numeric' => ':attribute doit être inférieur à :value.',
    'file' => ':attribute doit être inférieur à :value kilo-octets.',
    'string' => ':attribute doit contenir moins de :value caractères.',
    'array' => ':attribute doit contenir moins de :value éléments.',
],
'lte' => [
    'numeric' => ':attribute doit être inférieur ou égal à :value.',
    'file' => ':attribute doit être inférieur ou égal à :value kilo-octets.',
    'string' => ':attribute doit contenir moins ou autant de :value caractères.',
    'array' => ':attribute ne doit pas contenir plus de :value élément(s).',
],
'gt' => [
    'numeric' => ':attribute doit être supérieur à :value.',
    'file' => ':attribute doit être supérieur à :value kilo-octets.',
    'string' => ':attribute doit contenir plus de :value caractères.',
    'array' => ':attribute doit contenir plus de :value élément(s).',
],
'gte' => [
    'numeric' => ':attribute doit être supérieur ou égal à :value.',
    'file' => ':attribute doit être supérieur ou égal à :value kilo-octets.',
    'string' => ':attribute doit contenir au moins :value caractères.',
    'array' => ':attribute doit contenir au moins :value élément(s).',
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
        'rule-name' => 'message-personnalisé',
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
    'name' => 'Nom',
    'username' => 'Nom d\'utilisateur',
    'email' => 'Adresse e-mail',
    'first_name' => 'Prénom',
    'last_name' => 'Nom de famille',
    'password' => 'Mot de passe',
    'password_confirmation' => 'Confirmation du mot de passe',
    'city' => 'Ville',
    'country' => 'Pays',
    'address' => 'Adresse',
    'phone' => 'Téléphone',
    'mobile' => 'Mobile',
    'age' => 'Âge',
    'sex' => 'Sexe',
    'gender' => 'Genre',
    'day' => 'Jour',
    'month' => 'Mois',
    'year' => 'Année',
    'hour' => 'Heure',
    'minute' => 'Minute',
    'second' => 'Seconde',
    'title' => 'Titre',
    'content' => 'Contenu',
    'description' => 'Description',
    'excerpt' => 'Extrait',
    'date' => 'Date',
    'time' => 'Heure',
    'available' => 'Disponible',
    'size' => 'Taille',
],
];
