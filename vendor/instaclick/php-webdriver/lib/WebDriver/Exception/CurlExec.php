<?php
/**
 * Copyright 2004-2017 Facebook. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Justin Bishop <jubishop@gmail.com>
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 * @author Gaetano Giunta <giunta.gaetano@gmail.com>
 */

namespace WebDriver\Exception;

use WebDriver\Exception as BaseException;

/**
 * WebDriver\Exception\CurlExec class
 *
 * @package WebDriver
 */
final class CurlExec extends BaseException
{
    /**
     * @var array
     */
    private $curlInfo = array();

    /**
     * Get curl info
     *
     * @return array
     */
    public function getCurlInfo()
    {
        return $this->curlInfo;
    }

    /**
     * Set curl info
     *
     * @param array $curlInfo
     */
    public function setCurlInfo($curlInfo)
    {
        $this->curlInfo = $curlInfo;
    }
}
