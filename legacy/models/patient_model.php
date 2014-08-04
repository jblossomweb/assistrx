<?php 

include 'my_model.php';

class patient_model extends my_model
{
    public function __construct()
    {
        // constructing the parent gives us 
        // access to the db through $this->db
        // which is a native php mysqli interface
        parent::__construct();
    }

    public function list_all()
    {
        $sql = $this->db->prepare('select * from patients');

        // expects that sql is a pdo prepared stmt
        $sql->execute();

        // http://php.net/manual/en/pdostatement.fetchall.php
        return $sql->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Gets a Patient's data joined with their favorite song
     *
     * @author Daniel Walker <daniel.walker@assistrx.com>
     * @since  5/15/13
     * @param  int $patient_id 
     * @return stdClass the joined sql records
     */
    public function get_by_id($patient_id = NULL)
    {
        $sql = $this->db->prepare("
            SELECT *
            FROM patients
            LEFT JOIN songs
                ON patients.favorite_song_id = songs.song_id
            WHERE  patient_id = ?
        ");

        // execute with the patiend id (goes where the ? is in the query above)
        $sql->execute(array($patient_id));

        return $sql->fetchObject();
    }
}
