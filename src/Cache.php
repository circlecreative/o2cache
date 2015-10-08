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

namespace O2System
{
    use O2System\Cache\Exception;

    /**
     * Caching Class
     *
     * @package        o2cache
     * @category       Bootstrap
     * @author         Circle Creative Developer Team
     * @link
     */
    class Cache
    {
        /**
         * Valid Drivers List
         *
         * @access  protected
         * @type    array
         */
        protected $_valid_drivers = array(
            'files',
            'apc',
            'memcached',
            'redis',
            'wincache'
        );

        /**
         * Cache Storage Driver
         *
         * @access  protected
         * @type    object
         */
        protected $_storage;

        // ------------------------------------------------------------------------

        /**
         * Setup Cache Driver
         *
         * @param array $config
         *
         * @return  mixed
         * @throws  Exception
         */
        public function setup( array $config = array())
        {
            if( empty( $config[ 'driver' ] ) )
            {
                throw new Exception( 'You have not selected storage cache driver.', 102 );
            }

            if( ! in_array( $config[ 'driver' ], $this->_valid_drivers ) )
            {
                throw new Exception( 'Unsupported storage cache driver.', 103 );
            }

            if( file_exists( __DIR__ . '/Drivers/' . ucfirst( $config[ 'driver' ] . '.php' ) ) )
            {
                // Create DB Connection
                $class_name = '\O2System\Cache\Drivers\\' . ucfirst( $config[ 'driver' ] );
                $this->_storage = new $class_name( $config );

                if($this->_storage->initialize())
                {
                    return $this->_storage;
                }
            }

            return FALSE;
        }
    }
}

namespace O2System\Cache
{
    use O2System\Gears\Tracer;

    class Exception extends \Exception
    {
        /**
         * Class Constructor
         *
         * @param null       $message
         * @param int        $code
         * @param \Exception $previous
         */
        public function __construct( $message = NULL, $code = 0, \Exception $previous = NULL )
        {
            parent::__construct( $message, $code, $previous );
            set_exception_handler( '\O2System\Cache\Exception::exception_handler' );
        }

        // ------------------------------------------------------------------------

        /**
         * Exception Handler
         *
         * @param $exception
         */
        public static function exception_handler( $exception )
        {
            $tracer = new Tracer( (array)$exception->getTrace() );

            if( PHP_SAPI === 'cli' )
            {
                $template = __DIR__ . '/Views/cli_exception.php';
            }
            else
            {
                $template = __DIR__ . '/Views/html_exception.php';
            }

            if( ob_get_level() > 1 )
            {
                ob_end_flush();
            }

            header( 'HTTP/1.1 500 Internal Server Error', TRUE, 500 );

            ob_start();
            include( $template );
            $buffer = ob_get_contents();
            ob_end_clean();
            echo $buffer;

            exit( 1 );
        }
    }
}