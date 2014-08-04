<?php 

class my_model
{
    /**
     * This function makes a database handle for PDO
     * by reading a php ini file
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     */
    public function __construct()
    {
        // grab the DB config settings from a ini file
        // http://php.net/manual/en/function.parse-ini-file.php
        $settings = parse_ini_file('config/database.php', TRUE);

        // establish connection to DB
        $this->db = new PDO(
            'mysql:host='.$settings['DB']['host'].';dbname='.$settings['DB']['database'],
            $settings['DB']['user'],
            $settings['DB']['pass']
        );

        // should you handle connection errors?
    }


    /**
     * automagick function,
     * called on destroy of the instance
     * reset the db handle for garbage collection
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     */
    public function __destruct()
    {
        $this->db = null;
    }

}