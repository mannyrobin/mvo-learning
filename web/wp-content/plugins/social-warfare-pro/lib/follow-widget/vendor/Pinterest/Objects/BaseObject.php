<?php

/*
 * This file is part of the Pinterest PHP library.
 *
 * (c) Hans Ott <hansott@hotmail.be>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 *
 * Source: https://github.com/hansott/pinterest-php
 */

namespace Pinterest\Objects;

/**
 * The base object.
 *
 * @author Hans Ott <hansott@hotmail.be>
 */
interface BaseObject
{
    /**
     * Get the required fields for the object.
     *
     * @return array
     */
    public static function fields();
}