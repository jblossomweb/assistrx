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
	var patient = form_data['patient'];
    //$.post('/legacy/ajax_controller.php?method=save_song_for_patient', {
    $.post('/admin/ajax/patients/song', {
        data : {
            patient_id : patient.id,
            song_data : song
        }
    }, function(r) {
        console.log(r);
        var data = $.parseJSON(r);
        console.log(data);
        LoadAjaxContent('/admin/ajax/patients/song?id='+patient.id);
    });
};


$(":input.search-itunes").keyup(function (e) {
    var term = $(this).val();
    // from legacy songs.php
    $.ajax({
        url : 'https://itunes.apple.com/search',
        jsonpCallback : 'jsonCallback',
        async: true,
        contentType: "application/json",
        dataType: 'jsonp',
        data : {
            country : 'US',
            term : term,
            entity : 'song'
        },
        success: function(data) {
        	$("div.search-itunes-results .list").html('');
            var songs = data.results;
            for(var s in songs) {
                var song = songs[s];
                //console.log(song);
                var song_element = $('<li class="song">'+song.artistName+' - '+song.trackName+'</li>');
                song_element.click(save_song_function_maker(song));
                $("div.search-itunes-results .list").append(song_element);
            }

        }
    });

    
});