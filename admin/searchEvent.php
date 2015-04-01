<?php
/* THIS PAGE IS PROTECTED */
require ("protectedPage.php");
?>

<!DOCTYPE html>
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>
    <?php include(__DIR__ . "/../dat/connectDB.php"); ?>

    <body>

        <?php
        include (__DIR__ . "/../dat/controller.php");
        include (__DIR__ . "/../includes/data.php");
        $activePage = 2;
        ?>

        <div class="container">

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <!-- HEADER -->
                    <?php include(__DIR__ . "/includes/header.php"); ?>

                    <!-- NAVIGATION -->
                    <?php include(__DIR__ . "/includes/navigation.php"); ?>

                </div>
            </div>

            <div class="row clearfix">
                <div class="col-md-12 column">
                    <script>
                            $(function() {
                            $("#datestart").datepicker({dateFormat: "dd/mm/yy", altField: "#datestart_unix", altFormat: "@", firstDay: 1});
                        $("#dateend").datepicker({dateFormat: "dd/mm/yy", altField: "#dateend_unix", altFormat: "@", firstDay: 1});
                        });

                            function checkboxes(selectall) {
                            var genrelist = document.getElementsByClassName('genrelist');
                                for (var i = 0; i < genrelist.length; i++) {
                            genrelist[i].checked = selectall.checked;
                        }
                        }
                    </script>

                    <h3>Search for events</h3>
                    <!-- SEARCH EVENT -->
                    <div class="searchform_container">
                        <form class="form-horizontal" role="form" id="searcheventform" method="post" action="searchResults.php">

                            <div class="form-group"><label class="col-sm-2 control-label" for="freetext">Free word search </label>
                                <div class="col-sm-10">
                                    <input id="freetext" name="freetext" type="text" maxlength="1000" value=""/></div></div>

                            <!-- Fix this so it's possible to search for example for both larps and workshops -->
                            <div class="form-group"><label class="col-sm-2 control-label" for="eventtype">Event type</label> 
                                <div class="col-sm-10">
                                    <select id="eventtype" name="eventtype"> 
                                        <option value="1" selected="selected">All events</option>
                                        <option value="2">Larps</option>
                                        <option value="3">Conventions and meetups</option>
                                        <option value="4">Workshops</option>
                                        <option value="5">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="datestart">Events between dates </label>
                                <div class="col-sm-10">
                                    <input type="text" id="datestart" name="datestart" onfocus="checkRadioButton('date_datepicker');" value="<?php echo $datestart; ?>"/>
                                    <input type="hidden" id="datestart_unix" value=""/> - <input type="text" id="dateend" name="dateend" value="<?php echo $dateend; ?>"/>
                                    <input type="hidden" id="dateend_unix" value=""/>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="location">Location </label>
                                <div class="col-sm-10">
                                    <select id="location" name="location">
                                        <option value="1" selected="selected">Any</option>
                                        <option value="2">Southern Finland</option>
                                        <option value="3">Western Finland</option>
                                        <option value="4">Eastern Finland</option>
                                        <option value="5">Northern Finland</option>
                                        <option value="6">Abroad</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="genrelist">Genre</label>
                                <div class="col-sm-10">
                                    <input id="genre_all" name="genre_all" type="checkbox" value="all" onchange="checkboxes(this);"/>
                                    <label for="genre_all">Check all</label>
                                    <input id="genre_fantasy" class="genrelist" name="genre[1]" type="checkbox" value="fantasy"/>
                                    <label for="genre_fantasy">Fantasy</label>
                                    <input id="genre_scifi" class="genrelist" name="genre[2]" type="checkbox" value="sci-fi"/>
                                    <label for="genre_scifi">Sci-fi</label>
                                    <input id="genre_cyberpunk" class="genrelist" name="genre[3]" type="checkbox" value="cyberpunk"/>
                                    <label for="genre_cyberpunk">Cyberpunk</label>
                                    <input id="genre_steampunk" class="genrelist" name="genre[4]" type="checkbox" value="steampunk"/>
                                    <label for="genre_steampunk">Steampunk</label>
                                    <input id="genre_postapo" class="genrelist" name="genre[5]" type="checkbox" value="post-apocalyptic"/>
                                    <label for="genre_postapo">Post-apocalyptic</label>
                                    <input id="genre_historical" class="genrelist" name="genre[6]" type="checkbox" value="historical"/>
                                    <label for="genre_historical">Historical</label>
                                    <input id="genre_thriller" class="genrelist" name="genre[7]" type="checkbox" value="thriller"/>
                                    <label for="genre_thriller">Thriller</label>
                                    <input id="genre_horror" class="genrelist" name="genre[8]" type="checkbox" value="horror"/>
                                    <label for="genre_horror">Horror</label>
                                    <input id="genre_reality" class="genrelist" name="genre[9]" type="checkbox" value="reality"/>
                                    <label for="genre_reality">Reality</label>
                                    <input id="genre_city" class="genrelist" name="genre[10]" type="checkbox" value="city larp"/>
                                    <label for="genre_city">City larp</label>
                                    <input id="genre_newweird" class="genrelist" name="genre[11]" type="checkbox" value="new weird"/>
                                    <label for="genre_newweird">New weird</label>
                                    <input id="genre_action" class="genrelist" name="genre[12]" type="checkbox" value="action"/>
                                    <label for="genre_action">Action</label>
                                    <input id="genre_drama" class="genrelist" name="genre[13]" type="checkbox" value="drama"/>
                                    <label for="genre_drama">Drama</label>
                                    <input id="genre_humor" class="genrelist" name="genre[14]" type="checkbox" value="humor"/>
                                    <label for="genre_humor">Humor</label>
                                </div>
                            </div>
							
							<!--
                            <div class="form-group"><label class="col-sm-2 control-label" for="cost">Maximum cost</label>
                                <div class="col-sm-10">
                                    <input id="cost" name="cost" type="text" maxlength="100" value="<?php echo $cost; ?>"/>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="agelimit">Age limit</label>
                                <div class="col-sm-10">
                                    <input id="agelimit" name="agelimit" type="text" maxlength="100" value="<?php echo $agelimit; ?>"/>
                                </div>
                            </div>-->

                            <div class="form-group"><div class="col-sm-offset-2 col-sm-10">
                                    <input id="signupopen" name="signupopen" type="checkbox" value="1"/>
                                    <label for="signupopen">Events with signup open only</label>
                                </div>
                            </div>

                            <div class="form-group"><div class="col-sm-offset-2 col-sm-10">
                                    <input id="beginnerfriendly" name="beginnerfriendly" type="checkbox" value="1"/>
                                    <label for="beginnerfriendly">Beginner-friendly events only</label>
                                </div>
                            </div>

                            <div class="form-group"><div class="col-sm-offset-2 col-sm-10">
                                    <input id="pastevents" name="pastevents" type="checkbox" value="1"/>
                                    <label for="pastevents">Include past events</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input class="btn btn-default" id="searchbtn" type="submit" name="search" value="Search"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> 
            </div>

            <div class="row clearfix">
                <div class="col-md-12 column">

                    <!-- FOOTER -->
                    <?php include(__DIR__ . "/includes/footer.php"); ?>

                </div>
            </div>

        </div>

    </body>
</html>
