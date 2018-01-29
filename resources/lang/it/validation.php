<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted'              => ':attribute deve essere accettato.',
    'active_url'            => ':attribute non è un URL valido.',
    'after'                 => ':attribute deve essere una data successiva al :date.',
    'after_or_equal'        => ':attribute deve essere una data successiva o uguale al :date.',
    'alpha'                 => ':attribute può contenere solo lettere.',
    'alpha_dash'            => ':attribute può contenere solo lettere, numeri e trattini.',
    'alpha_num'             => ':attribute può contenere solo lettere e numeri.',
    'array'                 => ':attribute deve essere un array.',
    'before'                => ':attribute deve essere una data precedente al :date.',
    'before_or_equal'       => ':attribute deve essere una data precedente o uguale al :date.',
    'between'               => [
        'array'     => ':attribute deve avere tra :min - :max elementi.',
        'file'      => ':attribute deve trovarsi tra :min - :max kilobytes.',
        'numeric'   => ':attribute deve trovarsi tra :min - :max.',
        'string'    => ':attribute deve trovarsi tra :min - :max caratteri.',
    ],
    'boolean'               => 'Il campo :attribute deve essere vero o falso.',
    'confirmed'             => 'Il campo di conferma per :attribute non coincide.',
    'date'                  => ':attribute non è una data valida.',
    'date_format'           => ':attribute non coincide con il formato :format.',
    'different'             => ':attribute e :other devono essere differenti.',
    'digits'                => ':attribute deve essere di :digits cifre.',
    'digits_between'        => ':attribute deve essere tra :min e :max cifre.',
    'dimensions'            => 'Le dimensioni dell\'immagine di :attribute non sono valide.',
    'distinct'              => ':attribute contiene un valore duplicato.',
    'email'                 => ':attribute non è valido.',
    'exists'                => ':attribute selezionato non è valido.',
    'file'                  => ':attribute deve essere un file.',
    'filled'                => 'Il campo :attribute deve contenere un valore.',
    'image'                 => ':attribute deve essere un\'immagine.',
    'in'                    => ':attribute selezionato non è valido.',
    'in_array'              => 'Il valore del campo :attribute non esiste in :other.',
    'integer'               => ':attribute deve essere un numero intero.',
    'ip'                    => ':attribute deve essere un indirizzo IP valido.',
    'ipv4'                  => ':attribute deve essere un indirizzo IPv4 valido.',
    'ipv6'                  => ':attribute deve essere un indirizzo IPv6 valido.',
    'json'                  => ':attribute deve essere una stringa JSON valida.',
    'max'                   => [
        'array'     => ':attribute non può avere più di :max elementi.',
        'file'      => ':attribute non può essere superiore a :max kilobytes.',
        'numeric'   => ':attribute non può essere superiore a :max.',
        'string'    => ':attribute non può contenere più di :max caratteri.',
    ],
    'mimes'                 => ':attribute deve essere del tipo: :values.',
    'mimetypes'             => ':attribute deve essere del tipo: :values.',
    'min'                   => [
        'array'     => ':attribute deve avere almeno :min elementi.',
        'file'      => ':attribute deve essere almeno di :min kilobytes.',
        'numeric'   => ':attribute deve essere almeno :min.',
        'string'    => ':attribute deve contenere almeno :min caratteri.',
    ],
    'not_in'                => 'Il valore selezionato per :attribute non è valido.',
    'numeric'               => ':attribute deve essere un numero.',
    'present'               => 'Il campo :attribute deve essere presente.',
    'regex'                 => 'Il formato del campo :attribute non è valido.',
    'required'              => 'Il campo :attribute è richiesto.',
    'required_if'           => 'Il campo :attribute è richiesto quando :other è :value.',
    'required_unless'       => 'Il campo :attribute è richiesto a meno che :other sia in :values.',
    'required_with'         => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all'     => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_without'      => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all'  => 'Il campo :attribute è richiesto quando nessuno di :values è presente.',
    'same'                  => ':attribute e :other devono coincidere.',
    'size'                  => [
        'array'     => ':attribute deve contenere :size elementi.',
        'file'      => ':attribute deve essere :size kilobytes.',
        'numeric'   => ':attribute deve essere :size.',
        'string'    => ':attribute deve contenere :size caratteri.',
    ],
    'string'                => ':attribute deve essere una stringa.',
    'timezone'              => ':attribute deve essere una zona valida.',
    'unique'                => ':attribute è stato già utilizzato.',
    'uploaded'              => ':attribute non è stato caricato.',
    'url'                   => 'Il formato del campo :attribute non è valido.',
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
    'custom'    => [
        'attribute-name'    => [
            'rule-name' => 'custom-message',
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
    'attributes'    => [
        'address'               => 'indirizzo',
        'age'                   => 'età',
        'available'             => 'disponibile',
        'city'                  => 'città',
        'content'               => 'contenuto',
        'country'               => 'paese',
        'date'                  => 'data',
        'day'                   => 'giorno',
        'description'           => 'descrizione',
        'excerpt'               => 'estratto',
        'first_name'            => 'nome',
        'gender'                => 'genere',
        'hour'                  => 'ora',
        'last_name'             => 'cognome',
        'minute'                => 'minuto',
        'mobile'                => 'cellulare',
        'month'                 => 'mese',
        'name'                  => 'nome',
        'password_confirmation' => 'conferma password',
        'phone'                 => 'telefono',
        'second'                => 'secondo',
        'sex'                   => 'sesso',
        'size'                  => 'dimensione',
        'time'                  => 'ora',
        'title'                 => 'titolo',
        'username'              => 'nome utente',
        'year'                  => 'anno',
    ],
];
