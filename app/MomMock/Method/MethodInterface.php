<?php
/**
 * Copyright (c) 2018 Magenerds
 * All rights reserved
 *
 * This product includes proprietary software developed at Magenerds, Germany
 * For more information see http://www.magenerds.com/
 *
 * To obtain a valid license for using this software please contact us at
 * info@magenerds.com
 */

namespace MomMock\Method;

/**
 * Interface MethodInterface
 * @package MomMock\Method
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
interface MethodInterface
{
    /**
     * Handle the incoming request and its data
     *
     * @param $data
     * @return mixed
     */
    public function handleRequestData($data);
}