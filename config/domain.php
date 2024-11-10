<?php

return [

    /**
     * Time in DAY which show how long landing page can be active.
     */
    'landing_expiration' => 7,

    /**
     * Length of spins list in history manager.
     */
    'history_length'     => 3,

    /**
     * Enum: database, redis
     */
    'history_manager' => 'redis',
];
