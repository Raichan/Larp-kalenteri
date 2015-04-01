<?php

require_once (__DIR__ . "/controller.php");

class cEvent {

    private $id;
    private $eventName;
    private $eventType;
    private $startDate;
    private $endDate;
    private $dateTextField;
    private $startSignupTime;
    private $endSignupTime;
    private $locationDropDown;
    private $locationTextField;
    private $iconUrl;
    private $genre;
    private $cost;
    private $ageLimit;
    private $beginnerFriendly;
    private $storyDescription;
    private $infoDescription;
    private $organizerName;
    private $organizerEmail;
    private $link1;
    private $link2;
    private $status;
    private $password;

    /* Contructor */

    public function __construct($id, $eventName, $eventType, $startDate, $endDate, $dateTextField, $startSignupTime
    , $endSignupTime, $locationDropDown, $locationTextField, $iconUrl, $genre, $cost, $ageLimit, $beginnerFriendly
    , $storyDescription, $infoDescription, $organizerName, $organizerEmail, $link1, $link2, $status, $password) {
        $this->id = $id;
        $this->eventName = $eventName;
        $this->eventType = $eventType;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->dateTextField = $dateTextField;
        $this->startSignupTime = $startSignupTime;
        $this->endSignupTime = $endSignupTime;
        $this->locationDropDown = $locationDropDown;
        $this->locationTextField = $locationTextField;
        $this->iconUrl = $iconUrl;
        $this->genre = $genre;
        $this->cost = $cost;
        $this->ageLimit = $ageLimit;
        $this->beginnerFriendly = $beginnerFriendly;
        $this->storyDescription = $storyDescription;
        $this->infoDescription = $infoDescription;
        $this->organizerName = $organizerName;
        $this->organizerEmail = $organizerEmail;
        $this->link1 = $link1;
        $this->link2 = $link2;
        $this->status = $status;
        $this->password = $password;
    }

    /* Function, which returns a string of genres. */

    public function getGenres() {
        $ret = str_replace(',', ', ', $this->genre);
        return $ret;
    }

    /* Function, which returns a string cost - 'Free', '10 EUR', '10 - 20 EUR'. */

    public function getCost() {
        $c = $this->cost;
        if (strpos($c, '-') !== false) {
            $ret = str_replace('-', ' - ', $c);
            $ret .= " EUR";
            return $ret;
        } else if (strpos($c, '?') !== false) {
            $ret = "Free";
            return $ret;
        } else {
            $ret = $c . " EUR";
            return $ret;
        }
    }

    /* Function, which returns string of beginner friendly value - 'Yes' or 'No'. */

    public function getBeginnerFriendly() {
        if ($this->beginnerFriendly == true) {
            return "Yes";
        } else {
            return "No";
        }
    }

    /* Function, which returns event's ID. */

    public function getEventId() {
        return $this->id;
    }

    /* Function, which returns event's name. */

    public function getEventName() {
        return $this->eventName;
    }

    /* Function, which returns event's password. */

    public function getEventPassword() {
        return $this->password;
    }

    /* Function, which returns event's organizer email. */

    public function getOrganizerEmail() {
        return $this->organizerEmail;
    }

    /* Function, which returns event's type according to values in eventForm.php. */

    public function getEventType() {
        switch ($this->eventType) {
            case 2: return "Larps";
            case 3: return "Conventions and meetups";
            case 4: return "Workshops";
            case 5: return "Others";
            default: return null;
        }
    }

    /* Function, which returns event's location according to values in eventForm.php. */

    public function getEventLocationDropDown() {
        switch ($this->locationDropDown) {
            case 2: return "Southern Finland";
            case 3: return "Western Finland";
            case 4: return "Eastern Finland";
            case 5: return "Northern Finland";
            case 6: return "Abroad";
            default: return null;
        }
    }

    /* Function, which returns event's name with length of 10 characters. */

    public function getShortEventName() {
        if (strlen($this->eventName) <= 20) {
            return $this->eventName;
        } else {
            return substr($this->eventName, 0, 10) . "...";
        }
    }

    public function getEventInHTMLform() {
        $ret = "";
        /* Event name. */
        if ($this->eventName != '') {
            $ret .= "<table width='100%'><tr><td><h2>";
            $ret .= $this->eventName;
            $ret .= "</h2>";
        }
        /* Event icon. */
        if ($this->iconUrl != '') {
            $ret .= "</td><td align='right'><img src='$this->iconUrl' width=100 heigth=100></td></tr></table>";
        } else {
            $ret .= "</td><td align='right'><img src='./../images/noimage.png' width=100 heigth=100></tr></table>";
        }
//        $ret = "";
//        /* Event icon. */
//        if ($this->iconUrl != '') {
//            $ret .= "<img src='$this->iconUrl' width=100 heigth=100 style='float: right;'>";
//        }
//        /* Event name. */
//        if ($this->eventName != '') {
//            $ret .= "<h2>";
//            $ret .= $this->eventName;
//            $ret .= "</h2>";
//        }
        /* Event type. */
        if ($this->eventType != '') {
            $ret .= "<h4><b>Event type:</b> ";
            $ret .= $this->getEventType();
            $ret .= "</h4>";
        }
        /* Genre. */
        if ($this->genre != '') {
            $ret .= "<h5><b>Genre:</b> ";
            $ret .= $this->getGenres();
            $ret .= "</h5>";
        }
        /* Place. */
        if ($this->locationDropDown != '' && $this->locationTextField != '') {
            $ret .= "<h5><b>Location:</b> ";
            $ret .= $this->getEventLocationDropDown() . ", " . $this->locationTextField;
            $ret .= "</h5>";
        }
        /* Organizer */
        if ($this->organizerEmail != '') {
            $ret .= "<h5><b>Organizer:</b><br>";
            if ($this->organizerName != '') {
                $ret .= $this->organizerName . "<br>";
            }
            $ret .= "<a href='mailto: $this->organizerEmail '>$this->organizerEmail</a>";
            $ret .= "</h5>";
        }
        /* Signup time. */
        if ($this->startSignupTime != '' && $this->endSignupTime != '') {
            $ret .= "<h5><b>Signup time:</b> ";
            $ret .= getDateFromTimestamp($this->startSignupTime) . " - " . getDateFromTimestamp($this->endSignupTime);
            $ret .= "</h5>";
        }
        /* If start end end dates are filled and dateTextField is blank. */
        if ($this->startDate != '' && $this->endDate != '' && $this->dateTextField == '') {
            $ret .= "<h5><b>Date:</b> ";
            $ret .= getDateFromTimestamp($this->startDate) . " - " . getDateFromTimestamp($this->endDate);
            $ret .= "</h5>";
        } else if ($this->startDate == '' && $this->endDate == '' && $this->dateTextField != '') {
            $ret .= "<h5>";
            $ret .= getDateFromTimestamp($this->dateTextField);
            $ret .= "</h5>";
        }
        /* Cost. */
        if ($this->cost != '') {
            $ret .= "<h5><b>Cost:</b> ";
            $ret .= $this->getCost();
            $ret .= "</h5>";
        }
        /* Age limit. */
        if ($this->ageLimit != '') {
            $ret .= "<h5><b>Age limit:</b> ";
            $ret .= $this->ageLimit;
            $ret .= "</h5>";
        }
        /* Age limit. */
        if ($this->beginnerFriendly != '') {
            $ret .= "<h5><b>Beginner friendly:</b> ";
            $ret .= $this->getBeginnerFriendly();
            $ret .= "</h5>";
        }
        /* Story description */
        if ($this->storyDescription != '') {
            $ret .= "<h5><b>Story description:</b> ";
            $ret .= $this->storyDescription;
            $ret .= "</h5>";
        }
        /* Info description */
        if ($this->infoDescription != '') {
            $ret .= "<h5><b>Info description:</b> ";
            $ret .= $this->infoDescription;
            $ret .= "</h5>";
        }
        /* Links */
        if ($this->link1 != '') {
            $ret .= "<h5><b>Links:</b><br>";
            $ret .= "<a href='$this->link1' target='_blank'>" . substr($this->link1, 0, 50) . '...' . "</a><br>";
            if ($this->link2 != '') {
                $ret .= "<a href='$this->link2' target='_blank'>" . substr($this->link2, 0, 50) . '...' . "</a><br>";
            }
            $ret .= "</h5>";
        }
        return $ret;
    }

    public function getEventHTMLThumbnail() {
        if ($this->iconUrl == '') {
            $url = "./images/noimageCircle.png";
        } else {
            $url = $this->iconUrl;
        }
        $startDate = getDateFromTimestamp($this->startDate);
        $location = $this->locationTextField;
        $text = substr($this->infoDescription, 0, 150) . "...";

        $ret = "";
        $ret .= "
            <div class='col-md-4'>
                <div class='thumbnail'>
                    <img width='100' heigth='100' src='$url' class='img-circle' />
                    <div class='caption'>
                        <h4>
                            $this->eventName
                        </h4>
                        <h5>
                            <b>$startDate</b>, $location
                        </h5>
                        <p>
                            $text
                        </p>
                        <p>
                            <a class='btn btn-primary' href='index.php?eventId=$this->id'>See more</a>
                        </p>
                    </div>
                </div>
            </div>";
        return $ret;
    }
	
    public function getEventTableRow() {
        $ret = "<tr>";
        $ret .= "<td>$this->eventName</td>";
        $ret .= "<td>" . $this->getEventType() . "</td>";
        $ret .= "<td>" . getDateFromTimestamp($this->startDate) . "</td>";
        $ret .= "<td>" . getDateFromTimestamp($this->endDate) . "</td>";
        $ret .= "<td>" . $this->getEventLocationDropDown() . ', ' . $this->locationTextField . "</td>";
        $ret .= "<td>" . $this->getGenres() . '...' . "</td>";
        $ret .= "<td>" . $this->getCost() . "</td>";
        $ret .= "<td>$this->ageLimit</td>";
        $ret .= "<td>" . $this->getBeginnerFriendly() . "</td>";
        $ret .= "<td>";
        /* Include modal code for popup window of an event. */
        $ret .= "
            <div class='modal fade bs-example-modal-lg$this->id' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                            <h4 class='modal-title' id='myModalLabel'>More event's information</h4>
                        </div>
                        <div class='modal-body'>" . $this->getEventInHTMLform() . "</div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>";
        $ret .= "<button class='btn btn-primary btn-sm' data-toggle='modal' data-target='.bs-example-modal-lg$this->id'>More</button>";
        $ret .= "</td>";
        $ret .= "<td width='140px'>";
        /* Button for approve and deny link. */
        
        $ret .= "<script>function submitForm(){document.getElementById('adminmodifyform').submit();}</script><div class='btn-group'><button type='button' class='btn btn-primary btn-sm dropdown-toggle' data-toggle='dropdown'>
        Action <span class='caret'></span></button>
        <ul class='dropdown-menu' role = 'menu'>
        <li><a href='./eventsApproval.php?action=a&eventId=$this->id'>Approve</a></li>
        <li><a href='./eventsApproval.php?action=d&eventId=$this->id'>Deny</a></li>
        <li class='divider'></li>
        <li>
		<form id='adminmodifyform$this->id' name='adminmodifyform$this->id' style='display:inline;' action='modifyEvent.php' method='post'>
			<input type='hidden' name='modifyid' value='" . $this->id . "'/>
		</form>
		<a href='#' onclick='postModifyData(\"adminmodifyform$this->id\");'>Modify and approve</a>
        </li>
        </ul>
        </div>";
        $ret .= "</td>";
        $ret .= "</tr>";
        return $ret;
    }

}
