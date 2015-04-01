<?php
require_once './../dat/controller.php';
require_once './../dat/cEvent.php';

switch ($error) {
    case 0: {
            $message = "<div class='alert alert-success'>";
            $message .= "Event was <b>approved</b> successfully.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 1: {
            $message = "<div class='alert alert-success'>";
            $message .= "Event was <b>denied</b> successfully.";
            $message .= "</div>";
            echo $message;
            break;
        }
    case 2: {
            $message = "<div class='alert alert-danger'>";
            $message .= "An error has occured. Please try again later.";
            $message .= "</div>";
            echo $message;
            break;
        }
    default: {
            $message = "";
            break;
        }
}
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>
                Event name
            </th>
            <th>
                Event type
            </th>
            <th>
                Start date
            </th>
            <th>
                End date
            </th>
            <th>
                Location
            </th>
            <th>
                Genre
            </th>
            <th>
                Cost
            </th>
            <th>
                Age limit
            </th>
            <th>
                Beginners
            </th>
            <th>
                More info
            </th>
            <th>
                Action
            </th>
        </tr>
    </thead>
    <tbody>

        <?php
        /* Get list of events id for approval, depending on status. */
        $listOfEvents = getListOfEventsForApproval();
        /* For each id get new cEvent object with the data. */
        $events = null;
        if ($listOfEvents != null) {
            foreach ($listOfEvents as $event) {
                $a = getCeventObject($event);
                if ($a != null) {
                    $events[] = $a;
                }
            }
        }
        /* For each cEvent object generate a table row. */
        if ($events != null) {
            foreach ($events as $event) {
                echo $event->getEventTableRow();
            }
        } else {
            $error = null;
            $message = "<div class='alert alert-info'>";
            $message .= "There are no events for approval.";
            $message .= "</div>";
            echo $message;
        }
        ?>

    </tbody>
</table>
