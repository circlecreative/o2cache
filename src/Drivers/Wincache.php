<?php
/**
 * O2Cache
 *
 * An open source PHP Cache Management for PHP 5.4 or newer
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015, PT. Lingkar Kreasi (Circle Creative).
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package        O2System
 * @author         Steeven Andrian Salim
 * @copyright      Copyright (c) 2005 - 2014, PT. Lingkar Kreasi (Circle Creative).
 * @license        http://circle-creative.com/products/o2cache/license.html
 * @license        http://opensource.org/licenses/MIT   MIT License
 * @link           http://circle-creative.com/products/o2cache.html
 * @filesource
 */
// ------------------------------------------------------------------------

namespace O2System\Cache\Drivers;

// ------------------------------------------------------------------------

use O2System\Glob\Drivers;
use O2System\Cache\Exception;

/**
 * Wincache Caching Class
 *
 * @package        o2cache
 * @subpackage     Drivers
 * @category       Driver
 * @author         Mike Murkovic
 * @link
 */
class Wincache extends Drivers
{
    /**
     * Driver Name
     *
     * @access    public
     * @var       string
     */
    public $driver = 'Wincache';

    // ------------------------------------------------------------------------

    /**
     * Initialize Cache Driver
     *
     * @access    public
     * @return    bool
     */
    public function initialize()
    {
        return $this->is_supported();
    }

    // ------------------------------------------------------------------------

    /**
     * Get
     *
     * Look for a value in the cache. If it exists, return the data,
     * if not, return FALSE
     *
     * @param    string $id Cache Ide
     *
     * @return    mixed    Value that is stored/FALSE on failure
     */
    public function get( $id )
    {
        $success = FALSE;
        $data = wincache_ucache_get( $id, $success );

        // Success returned by reference from wincache_ucache_get()
        return ( $success ) ? $data : FALSE;
    }

    // ------------------------------------------------------------------------

    /**
     * Cache Save
     *
     * @param    string $id   Cache ID
     * @param    mixed  $data Data to store
     * @param    int    $ttl  Time to live (in seconds)
     * @param    bool   $raw  Whether to store the raw value (unused)
     *
     * @return    bool    true on success/false on failure
     */
    public function save( $id, $data, $ttl = 60, $raw = FALSE )
    {
        return wincache_ucache_set( $id, $data, $ttl );
    }

    // ------------------------------------------------------------------------

    /**
     * Delete from Cache
     *
     * @param    mixed    unique identifier of the item in the cache
     *
     * @return    bool    true on success/false on failure
     */
    public function delete( $id )
    {
        return wincache_ucache_delete( $id );
    }

    // ------------------------------------------------------------------------

    /**
     * Increment a raw value
     *
     * @param    string $id     Cache ID
     * @param    int    $offset Step/value to add
     *
     * @return    mixed    New value on success or FALSE on failure
     */
    public function increment( $id, $offset = 1 )
    {
        $success = FALSE;
        $value = wincache_ucache_inc( $id, $offset, $success );

        return ( $success === TRUE ) ? $value : FALSE;
    }

    // ------------------------------------------------------------------------

    /**
     * Decrement a raw value
     *
     * @param    string $id     Cache ID
     * @param    int    $offset Step/value to reduce by
     *
     * @return    mixed    New value on success or FALSE on failure
     */
    public function decrement( $id, $offset = 1 )
    {
        $success = FALSE;
        $value = wincache_ucache_dec( $id, $offset, $success );

        return ( $success === TRUE ) ? $value : FALSE;
    }

    // ------------------------------------------------------------------------

    /**
     * Clean the cache
     *
     * @return    bool    false on failure/true on success
     */
    public function clean()
    {
        return wincache_ucache_clear();
    }

    // ------------------------------------------------------------------------

    /**
     * Cache Info
     *
     * @return    mixed    array on success, false on failure
     */
    public function info()
    {
        return wincache_ucache_info( TRUE );
    }

    // ------------------------------------------------------------------------

    /**
     * Get Cache Metadata
     *
     * @param    mixed    key to get cache metadata on
     *
     * @return    mixed    array on success/false on failure
     */
    public function get_metadata( $id )
    {
        if( $stored = wincache_ucache_info( FALSE, $id ) )
        {
            $age = $stored[ 'ucache_entries' ][ 1 ][ 'age_seconds' ];
            $ttl = $stored[ 'ucache_entries' ][ 1 ][ 'ttl_seconds' ];
            $hitcount = $stored[ 'ucache_entries' ][ 1 ][ 'hitcount' ];

            return array(
                'expire'   => $ttl - $age,
                'hitcount' => $hitcount,
                'age'      => $age,
                'ttl'      => $ttl
            );
        }

        return FALSE;
    }

    // ------------------------------------------------------------------------

    /**
     * is_supported()
     *
     * Check to see if WinCache is available on this system, bail if it isn't.
     *
     * @return  bool
     * @throws  Exception
     */
    public function is_supported()
    {
        if( ! extension_loaded( 'wincache' ) OR ! ini_get( 'wincache.ucenabled' ) )
        {
            throw new Exception('The Wincache PHP extension must be loaded to use Wincache Cache.', 103);
        }

        return TRUE;
    }
}