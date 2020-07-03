<?php
include("includes/includedFiles.php");
?>

<div class="playListsContainer">

    <div class="gridViewContainer">
        <h2>PLAYLISTY</h2>

        <div class="buttonItems">
            <button class="button green" onclick="createPlaylist()">Nowa playlista</button>
        </div>

        <?php
        $username = $userLoggedIn->getUserName();

        $playlistQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner = '$username' LIMIT 5");

        if (mysqli_num_rows($playlistQuery) == 0) {
            echo "<span class='noResults'>Nie masz jeszcze zadnej playlisty</span>";
        }

        while($row = mysqli_fetch_array($playlistQuery)) {

            $playlist = new Playlist($con, $row);

            echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=".$playlist->getId()."\")'>
                        <div class='playlistImage'>
                            <img src='assets/images/icons/playlist.png' alt='Playlista'>
                        </div>

                       <div class='gridViewInfo'>"
                            .$playlist->getName().
                        "</div>
                  </div>";
        }
        ?>


    </div>

</div>
