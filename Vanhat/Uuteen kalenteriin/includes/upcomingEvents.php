<h3>
    <?php echo $upcoming; ?>
</h3>
<div class="row">

    <?php
    include (__DIR__ . "./../includes/data.php");
    /* Get events as an array. */
    $newEvents = getUpcomingEvents();
    /* Go through array and write each event as a thumbnail. */
    foreach ($newEvents as $event) {
        echo $event->getEventHTMLThumbnail();
    }
    ?>

</div>