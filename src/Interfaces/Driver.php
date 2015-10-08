<?php

namespace O2System\Cache\Interfaces;

abstract class Driver
{
    /**
     * Driver Name
     *
     * @access    public
     * @var       string
     */
	public $driver;

    /**
     * Driver Resource Handler
     *
     * @access    public
     * @var       object
     */
	protected $_handle;

    /**
     * Driver Class Constructor
     *
     * @param    array $config
     *
     * @access   public
     */
	public function __construct($config = array())
	{
		foreach($config as $key => $value)
		{
			$this->{$key} = $value;
		}
	}

    // ------------------------------------------------------------------------

    /**
     * Initialize Cache Driver
     *
     * @access  public
     * @return  bool
     * @throws  Exception
     */
    abstract public function initialize();

    // ------------------------------------------------------------------------

    /**
     * Get
     *
     * Look for a value in the cache. If it exists, return the data
     * if not, return FALSE
     *
     * @param    string $id
     *
     * @return    mixed    value matching $id or FALSE on failure
     */
    abstract public function get( $id );
    
    // ------------------------------------------------------------------------

    /**
     * Cache Save
     *
     * @param    string $id   Cache ID
     * @param    mixed  $data Data to store
     * @param    bool   $raw  Whether to store the raw value
     * @param    int    $ttl  Cache TTL (in seconds)
     *
     * @return    bool    TRUE on success, FALSE on failure
     */
    abstract public function save( $id, $data, $raw = FALSE, $ttl = NULL );

    // ------------------------------------------------------------------------

    /**
     * Delete from Cache
     *
     * @param    string $id Cache ID
     *
     * @return    bool    TRUE on success, FALSE on failure
     */
    abstract public function delete( $id );

    // ------------------------------------------------------------------------

    /**
     * Increment a raw value
     *
     * @param    string $id     Cache ID
     * @param    int    $offset Step/value to add
     *
     * @return    mixed    New value on success or FALSE on failure
     */
    abstract public function increment( $id, $offset = 1 );

    // ------------------------------------------------------------------------

    /**
     * Decrement a raw value
     *
     * @param    string $id     Cache ID
     * @param    int    $offset Step/value to reduce by
     *
     * @return    mixed    New value on success or FALSE on failure
     */
    abstract public function decrement( $id, $offset = 1 );

    // ------------------------------------------------------------------------

    /**
     * Clean the cache
     *
     * @return    bool    TRUE on success, FALSE on failure
     */
    abstract public function clean();

    // ------------------------------------------------------------------------

    /**
     * Cache Info
     *
     * @param    string $type = 'user'    user/filehits
     *
     * @return    mixed    array containing cache info on success OR FALSE on failure
     */
    abstract public function info( $type = 'user' );

    // ------------------------------------------------------------------------

    /**
     * Get Cache Metadata
     *
     * @param    string $id key to get cache metadata on
     *
     * @return    mixed    cache item metadata
     */
    abstract public function get_metadata( $id );

    // ------------------------------------------------------------------------

    /**
     * is_supported()
     *
     * Check to see if the driver is supported.
     *
     * @return  bool
     * @throws  Exception
     */
    abstract public function is_supported();
}