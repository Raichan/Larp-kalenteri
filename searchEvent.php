<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>

    <!-- HEAD -->
    <?php include(__DIR__ . "/includes/head.php"); ?>

    <body>

        <?php
        require (__DIR__ . "/dat/controller.php");
        include (__DIR__ . "/includes/data.php");
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

                        /*function checkboxes(selectall) {
                            var genrelist = document.getElementsByClassName('genrelist');
                            for (var i = 0; i < genrelist.length; i++) {
                                genrelist[i].checked = selectall.checked;
                            }
                        }*/
                    </script>

                    <h2><?php echo $title_search; ?></h2>
                    <!-- SEARCH EVENT -->
					<div class="alert alert-warning" role="alert">
						<?php echo $search_disclaimer; ?>
					</div>
                    <div class="searchform_container">
                        <form class="form-horizontal" role="form" id="searcheventform" method="post" action="searchResults.php">

                            <div class="form-group"><label class="col-sm-2 control-label" for="freetext"><?php echo $label_freesearch; ?></label>
                                <div class="col-sm-10">
                                    <input id="freetext" name="freetext" type="text" maxlength="1000" value=""/></div></div>

                            <!-- Fix this so it's possible to search for example for both larps and workshops -->
                            <div class="form-group"><label class="col-sm-2 control-label" for="eventtype"><?php echo $label_type; ?></label> 
                                <div class="col-sm-10">
                                    <select id="eventtype" name="eventtype"> 
                                        <option value="1" selected="selected"><?php echo $type_allevents; ?></option>
                                        <option value="2"><?php echo $type_larps; ?></option>
                                        <option value="3"><?php echo $type_cons; ?></option>
                                        <option value="4"><?php echo $type_workshops; ?></option>
                                        <option value="5"><?php echo $type_other; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="datestart"><?php echo $label_date; ?></label>
                                <div class="col-sm-10">
                                    <input type="text" id="datestart" name="datestart" onfocus="checkRadioButton('date_datepicker');" value="<?php echo $datestart; ?>"/>
                                    <input type="hidden" id="datestart_unix" value=""/> - <input type="text" id="dateend" name="dateend" value="<?php echo $dateend; ?>"/>
                                    <input type="hidden" id="dateend_unix" value=""/>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="location"><?php echo $label_location; ?></label>
                                <div class="col-sm-10">
                                    <select id="location" name="location">
                                        <option value="1" selected="selected"><?php echo $location_any; ?></option>
                                        <option value="2"><?php echo $location_south; ?></option>
                                        <option value="3"><?php echo $location_southwest; ?></option>
                                        <option value="4"><?php echo $location_west; ?></option>
                                        <option value="5"><?php echo $location_east; ?></option>
                                        <option value="6"><?php echo $location_north; ?></option>
										<option value="7"><?php echo $location_lapland; ?></option>
										<option value="8"><?php echo $location_abroad; ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="genrelist"><?php echo $label_genre; ?></label>
                                <div class="col-sm-10">
                                    <!--<input id="genre_all" name="genre_all" type="checkbox" value="all" onchange="checkboxes(this);"/>
                                    <label for="genre_all"><?php //echo $genre_all; ?></label>-->
                                    <input id="genre_fantasy" class="genrelist" name="genre[1]" type="checkbox" value="fantasy"/>
                                    <label for="genre_fantasy"><?php echo $genre_fantasy; ?></label>
                                    <input id="genre_scifi" class="genrelist" name="genre[2]" type="checkbox" value="sci-fi"/>
                                    <label for="genre_scifi"><?php echo $genre_scifi; ?></label>
                                    <input id="genre_cyberpunk" class="genrelist" name="genre[3]" type="checkbox" value="cyberpunk"/>
                                    <label for="genre_cyberpunk"><?php echo $genre_cyberpunk; ?></label>
                                    <input id="genre_steampunk" class="genrelist" name="genre[4]" type="checkbox" value="steampunk"/>
                                    <label for="genre_steampunk"><?php echo $genre_steampunk; ?></label>
									<br>
                                    <input id="genre_postapo" class="genrelist" name="genre[5]" type="checkbox" value="post-apocalyptic"/>
                                    <label for="genre_postapo"><?php echo $genre_postapo; ?></label>
                                    <input id="genre_historical" class="genrelist" name="genre[6]" type="checkbox" value="historical"/>
                                    <label for="genre_historical"><?php echo $genre_historical; ?></label>
                                    <input id="genre_thriller" class="genrelist" name="genre[7]" type="checkbox" value="thriller"/>
                                    <label for="genre_thriller"><?php echo $genre_thriller; ?></label>
                                    <input id="genre_horror" class="genrelist" name="genre[8]" type="checkbox" value="horror"/>
                                    <label for="genre_horror"><?php echo $genre_horror; ?></label>
                                    <input id="genre_reality" class="genrelist" name="genre[9]" type="checkbox" value="reality"/>
                                    <label for="genre_reality"><?php echo $genre_reality; ?></label>
									<br>
                                    <input id="genre_city" class="genrelist" name="genre[10]" type="checkbox" value="city larp"/>
                                    <label for="genre_city"><?php echo $genre_city; ?></label>
                                    <input id="genre_newweird" class="genrelist" name="genre[11]" type="checkbox" value="new weird"/>
                                    <label for="genre_newweird"><?php echo $genre_newweird; ?></label>
                                    <input id="genre_action" class="genrelist" name="genre[12]" type="checkbox" value="action"/>
                                    <label for="genre_action"><?php echo $genre_action; ?></label>
                                    <input id="genre_drama" class="genrelist" name="genre[13]" type="checkbox" value="drama"/>
                                    <label for="genre_drama"><?php echo $genre_drama; ?></label>
                                    <input id="genre_humor" class="genrelist" name="genre[14]" type="checkbox" value="humor"/>
                                    <label for="genre_humor"><?php echo $genre_humor; ?></label>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="cost"><?php echo $label_maxcost; ?></label>
                                <div class="col-sm-10">
                                    <input type="number" id="cost" name="cost" type="text" maxlength="100" value="<?php echo $cost; ?>"/>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label" for="agelimit"><?php echo $label_agelimit; ?></label>
                                <div class="col-sm-10">
                                    <input type="number" id="agelimit" name="agelimit" type="text" maxlength="100" value="<?php echo $agelimit; ?>"/>
                                </div>
                            </div>

                            <div class="form-group"><div class="col-sm-offset-2 col-sm-10">
                                    <input id="signupopen" name="signupopen" type="checkbox" value="1"/>
                                    <label for="signupopen"><?php echo $label_signupopen; ?></label>
                                </div>
                            </div>

                            <div class="form-group"><div class="col-sm-offset-2 col-sm-10">
                                    <input id="beginnerfriendly" name="beginnerfriendly" type="checkbox" value="1"/>
                                    <label for="beginnerfriendly"><?php echo $label_beginnerfriendly; ?></label>
                                </div>
                            </div>

                            <div class="form-group"><div class="col-sm-offset-2 col-sm-10">
                                    <input id="pastevents" name="pastevents" type="checkbox" value="1"/>
                                    <label for="pastevents"><?php echo $label_pastevents; ?></label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <input class="btn btn-default" id="searchbtn" type="submit" name="search" value="<?php echo $button_search; ?>"/>
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
