<?php

return [
    'actions'       => [
        'add_month'     => 'Añadir mes',
        'add_weekday'   => 'Añadir día de la semana',
        'add_year'      => 'Añadir nombre del año',
    ],
    'create'        => [
        'description'   => 'Crear nuevo calendario',
        'success'       => 'Calendario \':name\' creado.',
        'title'         => 'Nuevo Calendario',
    ],
    'destroy'       => [
        'success'   => 'Calendario \':name\' eliminado.',
    ],
    'edit'          => [
        'success'   => 'Calendario \':name\' actualizado.',
        'title'     => 'Editar calendario :name',
    ],
    'event'         => [
        'destroy'   => 'Evento eliminado del calendario \':name\'',
        'helpers'   => [
            'add'   => 'Añade un evento existente a este calendario.',
            'new'   => 'O crea un nuevo evento simplemente proporcionando un nombre.',
        ],
        'modal'     => [
            'title' => 'Añadir evento al calendario',
        ],
        'success'   => 'Evento \':event\' añadido al calendario.',
    ],
    'fields'        => [
        'comment'           => 'Comentario',
        'current_day'       => 'Día actual',
        'current_month'     => 'Mes actual',
        'current_year'      => 'Año actual',
        'date'              => 'Fecha actual',
        'has_leap_year'     => 'Tiene años bisiestos',
        'is_recurring'      => 'Recurrente',
        'leap_year_amount'  => 'Añadir días',
        'leap_year_month'   => 'Mes',
        'leap_year_offset'  => 'Cada',
        'leap_year_start'   => 'Año bisiesto',
        'months'            => 'Meses',
        'name'              => 'Nombre',
        'parameters'        => 'Parámetros',
        'seasons'           => 'Estaciones',
        'suffix'            => 'Sufijo',
        'type'              => 'Tipo',
        'weekdays'          => 'Días de la semana',
    ],
    'hints'         => [
        'is_recurring'  => 'Si un evento es recurrente, reaparecerá cada año en la misma fecha.',
    ],
    'index'         => [
        'add'           => 'Nuevo Calendario',
        'description'   => 'Administrar calendarios de :name.',
        'header'        => 'Calendarios de :name',
        'title'         => 'Calendarios',
    ],
    'panels'        => [
        'leap_year' => 'Año bisiesto',
        'years'     => 'Años con nombre',
    ],
    'parameters'    => [
        'month' => [
            'length'    => 'Número de días',
            'name'      => 'Nombre del mes',
        ],
        'year'  => [
            'name'      => 'Nombre',
            'number'    => 'Año',
        ],
    ],
    'placeholders'  => [
        'comment'           => 'Cumpleaños, Festival, Solsticio',
        'date'              => 'Fecha actual',
        'leap_year_amount'  => 'Número de días añadidos en un año bisiesto',
        'leap_year_month'   => 'Mes en que se añaden los días',
        'leap_year_offset'  => 'Cada cuántos años es un año bisiesto',
        'leap_year_start'   => 'Primer año que es un año bisiesto',
        'months'            => 'Número de meses en un año',
        'name'              => 'Nombre del calendario',
        'seasons'           => 'Número de estaciones',
        'suffix'            => 'Sufijo de la era actual (AC, BC)',
        'type'              => 'Tipo de calendario',
        'weekdays'          => 'Número de días de la semana',
    ],
    'show'          => [
        'description'   => 'Vista detallada del calendario',
        'tabs'          => [
            'information'   => 'Información',
        ],
        'title'         => 'Calendario :name',
    ],
];
