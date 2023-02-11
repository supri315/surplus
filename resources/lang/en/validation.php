<?php

return [
    'required'                      => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'boolean'              => 'The :attribute field must be true or false.',
    'unique'               => 'The :attribute has already been taken.',
    'array'                => 'The :attribute must be an array.',

    'attributes' => [
        'sortableAndSearchable'         => 'The :value is not orderable or searchable.',
        'sortableAndSearchableExist'    => 'The :value is not exist.',
        'dataNotExist'                  =>  'Data :attr does not exist',
        'dataNotExistWithID'            => 'Data :attr with id :id does not exist.',
    ],


];
