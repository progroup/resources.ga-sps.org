<div class="container">
    <div class="row">
        <style>

            .floated {
                float: left;
                padding-right: 1em;
            }
            .floated--right {
                float: right;
            }
        </style>
        <!-- <div class="col-md-12 spfgroup clearfix"> -->
        <!--    <h2><?php // echo $page->section_title()->kirbytext() ?></h2> -->
        <!-- </div> -->
        <div class="col-md-12 spfgroup">
            <h3 class="home-title"><?php echo $page->app_title()->kirbytext() ?></h3>
            <?php echo $page->app_description()->kirbytext() ?>
        </div>
        <div class="col-md-12 spfgroup">
            <h3 class="home-title"><?php echo $page->gen_rx_title()->kirbytext() ?></h3>
            <?php echo $page->gen_rx_description()->kirbytext() ?>
        </div>
        <div class="col-md-12 spfgroup">
            <h3 class="home-title"><?php echo $page->suicide_prevention_title()->kirbytext() ?></h3>
            <?php echo $page->suicide_prevention_description()->kirbytext() ?>
        </div>
        <div class="col-md-12 spfgroup">
            <h3 class="home-title"><?php echo $page->seow_title()->kirbytext() ?></h3>
            <?php echo $page->seow_description()->kirbytext() ?>
        </div>
    </div>

</div>


