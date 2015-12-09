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
	/**
	 * Caching Class
	 *
	 * @package        o2cache
	 * @category       Bootstrap
	 * @author         O2System Developer Team
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
	
		public function __construct( array $config = array() )
		{
			if( ! empty( $config ) )
			{
				if( isset( $config[ 'storage' ] ) AND isset( $config[ 'failover' ] ) )
				{
					if( $this->setup( $config[ 'storage' ] ) === FALSE )
					{
						$this->setup( $config[ 'failover' ] );
					}
				}
				elseif( isset( $config[ 'driver' ] ) )
				{
					return $this->setup( $config );
				}
			}
		}
	
		/**
		 * Setup Cache Driver
		 *
		 * @param array $config
		 *
		 * @return  mixed
		 * @throws  Exception
		 */
		public function setup( array $config = array() )
		{
			if( empty( $config[ 'driver' ] ) )
			{
				throw new Cache\Exception( 'You have not selected storage cache driver.' );
			}
	
			if( ! in_array( $config[ 'driver' ], $this->_valid_drivers ) )
			{
				throw new Cache\Exception( 'Unsupported storage cache driver.' );
			}
	
			if( file_exists( __DIR__ . '/Drivers/' . ucfirst( $config[ 'driver' ] . '.php' ) ) )
			{
				// Create DB Connection
				$class_name = '\O2System\Cache\Drivers\\' . ucfirst( $config[ 'driver' ] );
				$this->_storage = new $class_name( $config );
	
				if( $this->_storage->initialize() )
				{
					return $this->_storage;
				}
			}
	
			return FALSE;
		}
	
		public function __call($method, $args = array())
		{
			if(method_exists($this->_storage, $method))
			{
				return call_user_func_array(array($this->_storage, $method), $args);
			}
		}
	}
}

namespace O2System\Cache
{
	use O2System\Glob\Exception\Interfaces as ExceptionInterface;

	class Exception extends ExceptionInterface
	{
		public function __construct( $message = NULL, $code = 0 )
		{
			parent::__construct( $message, $code );

			// Register Custom Exception View Path
			$this->register_view_paths( __DIR__ . '/Views/');
		}
	}
}