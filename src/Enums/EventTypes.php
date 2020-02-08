<?php

namespace  App\Enums;

class EventTypes
{
    const MEETING = 0;
    const CALL =  1;


    const TYPES = [
        self::MEETING => 'Meeting',
        self::CALL => 'Call'
    ];

    /**
     * @column (type="integer")
     */


}