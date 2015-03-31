<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>

<script>
    init.push(function () {
        $("#character-limit-input").limiter(20, { label: '#character-limit-input-label' });
        $("#character-limit-textarea").limiter(100, { label: '#character-limit-textarea-label' });

        function ajaxDiscussions() {
            $.ajax({
                url: "<?php echo site_url('welcome/getAjaxContentDiscussions/'.$user->id) ?>",
                success: function(data){
                    $('.panel-body #discussions').html(data);
                    setTimeout(ajaxDiscussions, 5000);
                }
            });
        }

        ajaxDiscussions();

        $('#submitmessage').click(function(){

            var textarea = $('textarea#writemessages');
            //module AJAX POST en Jquery
            $.ajax({
                type: 'POST',
                url: "<?php echo site_url('welcome/sendDiscussion/'.$user->id) ?>",
                data: {content: textarea.val() }
            });
            textarea.val('');
        });

    });
</script>

<div class="page-header">
    <h1><span class="text-light-gray">Discussions avec <?php echo $user->username ?></h1>
</div>
<div class="row">
    <div class="col-md-10">
        <div class="panel-heading">
            <span class="panel-title">Discussions</span>
        </div>
        <div class="panel-body">
            <div id="discussions">
                <?php if(!empty($discussions)){ ?>
                    <?php foreach($discussions as $discussion){ ?>
                        <h3><?php echo $discussion->userfrom ?></h3>
                        <?php echo $discussion->content ?>
                        <span class="badge badge-danger pull-right"> <?php echo ago($discussion->date_created) ?></span>

                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-danger">Pas encore de message avec <?php echo $user->username ?></div>
                <?php } ?>
            </div>
        </div>
        <div class="panel-footer text-right">
            <textarea id="writemessages" placeholder="Ecrivez votre message" id="character-limit-textarea" rows="3" class="form-control"></textarea>
            <div id="character-limit-textarea-label" class="limiter-label">Characters left: <span class="limiter-count">0</span></div>
            <button id="submitmessage" class="btn btn-sm btn-primary pull-right"><i class="fa fa-pencil"></i> Répondez</button>
        </div>
        </form>
    </div>
</div>


<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>

