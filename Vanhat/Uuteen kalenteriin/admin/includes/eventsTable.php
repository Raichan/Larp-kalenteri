<?php
require_once './../dat/controller.php';
require_once './../dat/cEvent.php';

switch ($error) {
    case 0: {
            $message = "<div class='alert alert-success'>";
            $message .= $event_approved;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 1: {
            $message = "<div class='alert alert-success'>";
            $message .= $event_denied;
            $message .= "</div>";
            echo $message;
            break;
        }
    case 2: {
            $message = "<div class='alert alert-danger'>";
            $message .= $event_error;
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
                <?php echo $event_name; ?>
            </th>
            <th>
                <?php echo $event_type; ?>
            </th>
            <th>
                <?php echo $event_start; ?>
            </th>
            <th>
                <?php echo $event_end; ?>
            </th>
            <th>
                <?php echo $event_location; ?>
            </th>
            <th>
                <?php echo $event_genre; ?>
            </th>
            <th>
                <?php echo $event_cost; ?>
            </th>
            <th>
                <?php echo $event_agelimit; ?>
            </th>
            <th>
                <?php echo $event_beginners; ?>
            </th>
            <th>
                <?php echo $event_more; ?>
            </th>
            <th>
                <?php echo $event_action; ?>
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
            $message .= $event_none;
            $message .= "</div>";
            echo $message;
        }
        ?>

    </tbody>
</table>
