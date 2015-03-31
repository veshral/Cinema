<?php

foreach($tweets as $tweet) { ?>
    <div class="message">
        <img src="assets/demo/avatars/2.jpg" alt="" class="message-avatar">

        <span class="message-subject"><?php echo $tweet["text"]; ?></span>
        <div class="message-description">
            par <a href="#"></a>
            &nbsp;&nbsp;·&nbsp;&nbsp;
            2h ago
            <a href="<?php echo site_url('welcome/suppressiontweet/'.$tweet["id"]); ?>" class="pull-right removetweet"><i class="fa fa-times"></i>Supprimer</a>
        </div> <!-- / .message-description -->

    </div> <!-- / .message -->
<?php } ?>