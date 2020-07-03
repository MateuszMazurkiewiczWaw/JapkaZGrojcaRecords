<?php
$songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>

    $(document).ready(function () {
        var newPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        //zapobieganie podkreslania ikonek na playbackBar
        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function (e) {
            e.preventDefault();
        });

        //pasek postepu sciezki
        $(".playbackBar .progressBar").mousedown(function () {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function (e) {
            if(mouseDown == true) {
                //ustaw czas piosenki, zaleznie od pozycji myszki
                timeFromOffset(e, this);
            }
        });

        $(".playbackBar .progressBar").mouseup(function (e) {
            timeFromOffset(e, this);
        });

        //pasek glosnosci
        $(".volumeBar .progressBar").mousedown(function () {
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function (e) {
            if(mouseDown == true) {

                var percentage = e.offsetX / $(this).width();

                if(percentage >= 0 && percentage <= 1){
                    audioElement.audio.volume = percentage;
                }
            }
        });

        $(".volumeBar .progressBar").mouseup(function (e) {
            var percentage = e.offsetX / $(this).width();

            if(percentage >= 0 && percentage <= 1){
                audioElement.audio.volume = percentage;
            }
        });

        $(document).mouseup(function () {
            mouseDown = false;
        });

    });
    
    function timeFromOffset(mouse, progressBar) {
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }
    
    function prevSong() {
        if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
            audioElement.setTime(0);
        }
        else {
            currentIndex--;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }
    
    function nextSong() {

        if(repeat == true) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if(currentIndex == currentPlaylist.length - 1){
            currentIndex = 0;
        }
        else {
            currentIndex++;
        }

        var trackToPlay =shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }
    
    function setRepeat() {
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png"
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
    }

    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png"
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
    }

    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png"
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

        if(shuffle == true) {
            //Losowa playlista
            //https://stackoverflow.com/questions/6274339/how-can-i-shuffle-an-array
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
        else {
            //Powroc do zwyklej playlisty
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }

    }

    //https://stackoverflow.com/questions/6274339/how-can-i-shuffle-an-array
    function shuffleArray(array) {
        var j, x, i;
        for (i = array.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            x = array[i];
            array[i] = array[j];
            array[j] = x;
        }
        return array;
    }

    function setTrack(trackId, newPlaylist, play) {
        //audioElement.setTrack("assets/music/DanceAtTheMoonlight.mp3");
        if(newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }

        if(shuffle == true) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        }
        else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        pauseSong();

        //prosty AJAX CALL
        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId}, function (data) {

            var track = JSON.parse(data);
            //console.log(track);
            //jQuery object
            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function (data) {
                var artist = JSON.parse(data);

                $(".trackInfo .artistName span").text(artist.name);
                $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id +"')");
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function (data) {
                var album = JSON.parse(data);

                $(".content .albumLink img").attr("src", album.artworkPath);
                $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id +"')");
                $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id +"')");
            });

            audioElement.setTrack(track);

            if (play == true) {
                playSong();
            }
        });
    }

    function playSong() {

        if(audioElement.audio.currentTime == 0){
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id});
        }

        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    function pauseSong() {
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    }

</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                       <span class="albumLink">
                           <img src="data:image/jpeg;base64,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" class="albumArtwork" role="link" tabindex="0">
                       </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span role="link" tabindex="0"></span>
                    </span>

                    <span class="artistName">
                        <span role="link" tabindex="0"></span>
                    </span>
                </div>
            </div>
        </div>

        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <!-- Odtwarzanie losowe -->
                    <button class="controlButton shuffle" title="Odtwarzaj losowo" onclick="setShuffle()">
                        <img src="assets/images/icons/shuffle.png" alt="Odtwarzaj losowo">
                    </button>
                    <!-- Poprzedni utwor -->
                    <button class="controlButton previous" title="Poprzedni utwor" onclick="prevSong()">
                        <img src="assets/images/icons/previous.png" alt="Poprzedni utwor">
                    </button>
                    <!-- Odtworz utwor -->
                    <button class="controlButton play" title="Odtworz utwor" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="Odtworz utwor">
                    </button>
                    <!-- Pauza -->
                    <button class="controlButton pause" title="Wstrzymaj" style="display: none" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="Wstrzymaj">
                    </button>
                    <!-- Nastepny utwor -->
                    <button class="controlButton next" title="Nastepny utwor" onclick="nextSong()">
                        <img src="assets/images/icons/next.png" alt="Nastepny utwor">
                    </button>
                    <!-- Powtorz utwor -->
                    <button class="controlButton repeat" title="Powtorz utwor" onclick="setRepeat()">
                        <img src="assets/images/icons/repeat.png" alt="Powtorz utwor">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>

                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>

                    <span class="progressTime remaining">0.00</span>
                </div>

            </div>
        </div>

        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Przycisk glosnosci" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="Przycisk glosnosci">
                </button>

                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

