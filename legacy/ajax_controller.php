<?php

/**
 * All ajax traffic comes through here.
 */
class ajax_controller
{
    /**
     * this is a stdClass object which will be transformed
     * to JSON for ALL Responses
     * 
     * @var stdClass Object
     */
    protected $response;


    /**
     * when ajax traffic hits, instantiate this class
     * passing in the name of the method to run
     * this is a pseudo controller
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     * @param  string $method the name of the class method to run
     */
    public function __construct($method = NULL)
    {
        // find post data
        $data = $_POST['data'];

        $this->response = new stdClass();

        // handle errors if method not set or not exists
        try
        {
            $result = $this->{$method}($data);

            $this->success($result);
        }
        catch(Exception $e)
        {
            // if there was an exception respond with a failure
            $this->failure($e->getMessage());
        }
    }


    /**
     * calls the required models for assigning a song to a patient
     * if patient_id and song_data are not given
     * this function will throw exception
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     * @throws  If required post param not set
     * @param  array $data *must be* $_POST['data']
     * @return string JSON string of response object 
     */
    public function save_song_for_patient($data)
    {
        $this->expects(array('patient_id', 'song_data'), $data);

        // instead of doing $data['patient_id'] extract will put $patient_id into 
        // the current symbol table
        extract($data);

        require 'models/song_model.php';

        $song_model = new song_model();

        $result = $song_model->save_song_for_patient($patient_id, $song_data);

        $this->success($result);
    }


    /**
     * this helper function allows other ajax methods
     * to know whether they have been passed all required post params
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     * @param  array $expected the keys required to be passed
     * @param  array $data the post data
     * @throws exception If a required key is not found in the data
     * @return void
     */
    protected function expects($expected, $data)
    {
        foreach($expected as $variable_name)
        {
            if(!array_key_exists($variable_name, $data))
            {
                throw new Exception("Error - you must pass {$variable_name} in \$_POST['data']");
            }
        }
    }


    /**
     * will die exporting the json string of
     * $this->response
     *
     * sets success to true
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     * @param  array $data 
     * @return void
     */
    protected function success($data)
    {
        // use the global response object
        // this way, other methods can add to it if needed
        $this->response->success = TRUE;
        $this->response->message = $data;

        die(json_encode($this->response));
    }


    /**
     * same as self::success yet sets success to false
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     * @param  array $data 
     * @return void
     */
    protected function failure($data)
    {
        // use the global response object
        // this way, other methods can add to it if needed
        $this->response->success = FALSE;
        $this->response->message = $data;

        die(json_encode($this->response));
    }

}

/**
 * This is the key to the ignition
 * start a new instance of the ajax controller, and call the method specified
 * @var ajax_controller
 */
$ajax = new ajax_controller( $_GET['method'] );

