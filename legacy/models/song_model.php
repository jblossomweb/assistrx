<?php 

include 'my_model.php';

class song_model extends my_model
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
        $sql = $this->db->prepare('select * from songs');

        // expects that sql is a pdo prepared stmt
        $sql->execute();

        // http://php.net/manual/en/pdostatement.fetchall.php
        return $sql->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * TODO: comment this function
     *
     * @author hopeful candadite
     * @since  date
     * @param  [type] $patient_id [description]
     * @param  [type] $song_data [description]
     * @return [type] [description]
     */
    public function save_song_for_patient($patient_id, $song_data)
    {
        $song_sql = $this->db->prepare("
            INSERT INTO songs
            (song_name, song_artist, song_data)
            VALUES (:song_name, :song_artist, :song_data)
        ");

        // expects that sql is a pdo prepared stmt
        $song_sql->execute(array(
            'song_name'   => $song_data['trackName'],
            'song_artist' => $song_data['artistName'],
            'song_data'   => json_encode($song_data)
        ));

        $song_id = $this->db->lastInsertId();

        $patient_sql = $this->db->prepare("
            UPDATE patients
            SET favorite_song_id = :song_id
            WHERE patient_id = :patient_id
        ");

        $patient_sql->execute(array(
            'song_id'    => $song_id,
            'patient_id' => $patient_id
        ));

        // if patient didn't exist, return some type of error
        // 
        // return rows affected or True ? - up to you!
    }
}