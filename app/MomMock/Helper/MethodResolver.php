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

namespace MomMock\Helper;

use MomMock\Method\MethodInterface;

/**
 * Class MethodResolver
 * @package MomMock\Helper
 * @author  Florian Sydekum <f.sydekum@techdivision.com>
 */
class MethodResolver
{
    /**
     * Holds the namespace for method service classes
     */
    const METHOD_NAMESPACE = 'MomMock\\Method';

    /**
     * Holds valid method names which can be handled by this mock
     */
    const VALID_METHODS = [
        'magento.service_bus.remote.register',
        'magento.sales.order_management.create'
    ];

    /**
     * Parses a given method and returns its service class
     *
     * @param string $method
     * @return MethodInterface
     */
    public function getServiceClassForMethod(string $method)
    {
        $classParts = explode('.', $method);

        // throw away the first key 'magento'
        array_shift($classParts);

        $className = self::METHOD_NAMESPACE;

        foreach ($classParts as $part) {
            $className .= '\\' . str_replace(' ', '', ucwords(str_replace('_', ' ', $part)));
        }

        if (!class_exists($className)) {
            throw new \Exception('Method service class could not be found: ' . $className);
        }

        return new $className();
    }

    /**
     * Returns an array of valid method names which can be handled by this mock
     *
     * @return []
     */
    public function getValidMethods()
    {
        return self::VALID_METHODS;
    }
}