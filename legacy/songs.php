<?php


include 'models/patient_model.php';

$patient_model = new patient_model();

// what should you do if there is no patient_id set??
// something... hopefully.
$patient_id = $_GET['patient_id'];

$patient = $patient_model->get_by_id($patient_id);

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ARX Test - Song Selection Page</title>
    <meta name="description" content="assistrx programming test">
    <meta name="author" content="assistrx-dw">
    <link rel="stylesheet" href="public/normalize.css">
    <link rel="stylesheet" href="public/styles.css?v=1.0">
</head>
<body>

    <nav>
        <a href="patients.php">All Patients</a> &bull;
        <a href="report.php">Report</a>
    </nav>



    <h1>Song Selection</h1>

    <?php if($patient->favorite_song_id): ?>
        <h2><?php echo $patient->patient_name; ?> has a Song:</h2>

        <?php $song = json_decode($patient->song_data); ?>
        <dl class="favorite-song">
            
            <dt>Song:</dt>
            <dd><?php echo $song->trackName; ?> on <?php echo $song->collectionName; ?></dd>

            <dt>Artist:</dt>
            <dd><?php echo $song->artistName; ?></dd>

            <dt>Album Cover</dt>
            <dd><img src="<?php echo $song->artworkUrl60; ?>" title="Album Cover" /></dd>
        </dl>
        <h2>Assign a Different song to <?php echo $patient->patient_name; ?>:</h2>
    <?php else: ?>
        <h2>Assign a Song to <?php echo $patient->patient_name; ?>:</h2>
    <?php endif; ?>

    <p>
        <label for="song_search">Search for a Song</label>
        <input type="text" name="song_search" placeholder="any song on iTunes" />
        <input type="button" name="song_search_submit" value="search" />
    </p>

    <ul id="song-result-wrapper"></ul>

    <!-- scripts at the bottom! -->
    <script src="public/jquery-1.9.1.min.js"></script>

    <!-- this script file is for global js -->
    <script src="public/script.js"></script>

    <script type="text/javascript">
        var term_input = $('input[name=song_search]');
        var result_wrapper = $('#song-result-wrapper');

        // this will return a closure (function) to be executed later, which keeps 
        // track of the song variable for the save_song() function
        var save_song_function_maker = function(song) {
            return function() {
                save_song(song);
            }
        };

        // this is the actual function which gets called when the user
        // selects a song and it needs to save in the DB
        var save_song = function(song) {
            $.post('ajax_controller.php?method=save_song_for_patient', {
                data : {
                    patient_id : '<?php echo $patient->patient_id; ?>',
                    song_data : song
                }
            }, function(r) {
                console.log(r);

                // now display the song so the user can see it
                // don't keep the alert here - make it user friendly
                alert('You chose '+song.trackName +' - which was saved');
                result_wrapper.html(Number(48879).toString(16));

            });
        };

        $('input[name=song_search_submit]').click(function(e) {
            e.preventDefault();
            var term = term_input.val();

            // clear the current results
            result_wrapper.html('');

            // DOC for iTunes Search API:
            // http://www.apple.com/itunes/affiliates/resources/documentation/itunes-store-web-service-search-api.html#overview
            
            $.ajax({
                url : 'https://itunes.apple.com/search',
                jsonpCallback : 'jsonCallback',
                async: false,
                contentType: "application/json",
                dataType: 'jsonp',
                data : {
                    country : 'US',
                    term : term,
                    entity : 'song',
                    limit : 25
                },
                success: function(data) {

                    var songs = data.results;

                    for(var s in songs) {

                        var song = songs[s];

                        // generate the html element for the song
                        var song_element = $('<li>'+song.trackName+'</li>');

                        // define the click handler in case user chooses this song
                        // on this line, save_song_function_maker is called right away
                        // and save_song_function_maker returns a function which is what
                        // click() will execute - thus, saving this very song
                        // (we are currently traversing songs)
                        song_element.click(save_song_function_maker(song));

                        result_wrapper.append(song_element);
                    }

                }
            });

        });
    </script>
</body>
</html>
