<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Icon Sets
    |--------------------------------------------------------------------------
    |
    | Définissez ici vos jeux d’icônes.
    |
    */

    'sets' => [

        'default' => [
            // Chemin (relatif à la racine du projet) vers vos SVG
            'path'   => 'resources/svg',            // Nom du disk Laravel (ou null pour le local)
            'disk'       => null,
            // Préfixe pour vos composants : <x-icon-foo />
            'prefix'     => 'icon',
            // Icône de secours si foo.svg est introuvable
            'fallback'   => '',
            // Classes Tailwind appliquées par défaut
            'class'      => '',
            // Attributs HTML appliqués par défaut
            'attributes' => [],
        ],

        // vous pouvez ajouter d’autres sets ici…

    ],

    /*
    |--------------------------------------------------------------------------
    | Global Default Classes & Attributes
    |--------------------------------------------------------------------------
    */

    // classes appliquées à tous les <x-icon-*>
    'class'      => '',
    // attributs appliqués à tous les <x-icon-*>
    'attributes' => [],

    /*
    |--------------------------------------------------------------------------
    | Global Fallback Icon
    |--------------------------------------------------------------------------
    */

    'fallback' => '',

];
