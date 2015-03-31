<?php if(!empty($discussions)){ ?>
    <?php foreach($discussions as $discussion){ ?>
        <h3><?php echo $discussion->userfrom ?></h3>
        <?php echo $discussion->content ?>
        <span class="badge badge-danger pull-right"> <?php echo ago($discussion->date_created) ?></span>

    <?php } ?>
<?php } else { ?>
    <div class="alert alert-danger">Pas encore de message avec <?php echo $user->username ?></div>
<?php } ?>