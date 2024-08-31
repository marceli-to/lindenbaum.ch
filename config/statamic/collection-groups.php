<?php

/**
 * This is where you can define your collection groups.
 * It should have this structure:
 * [
 *     'Group 1 label' => [
 *         'collection_handle_1',
 *         'collection_handle_2',
 *     ],
 *     'Group 2 label' => [
 *         'collection_handle_3',
 *         'Custom Label' => 'collection_handle_4',
 *     ]
 * ]
 */
return [

  'Anmeldungen' => [
    'Events' => 'requests_events',
    'Allgemein' => 'requests_general',
    'Wohnen' => 'requests_general',
    'Wäscherei' => 'requests_general',
    'Raumvermietung' => 'requests_rooms',
    'Chinderhuus' => 'requests_nursery',
    'Genossenschaft' => 'requests_cooperative',
  ],
  //   'Wäscherei' => 'requests_general',
  //   'Raumvermietung' => 'requests_catering',
  //   'Chinderhuus' => 'requests_chinderhuus',
  // ]
];