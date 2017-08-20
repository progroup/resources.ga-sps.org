<? snippet('header') ?>
<? snippet('banner') ?>
<div class="container">
  <div class="row">
    <div class="col-md-9 col-md-push-3">
      <div class="page-header">
        <h1><?= $page->title()->html() ?></h1>
      </div>
      <?= $page->text()->kirbytext() ?>
    </div>
    <div class="col-md-3 col-md-pull-9">
      <aside class="sidebar">
        <h5>Top Help Topics</h5>
        <ul class="nav list-unstyled">
          <li><a href="#">Alcohol and Substance Abuse Prevention (ASAP)</a></li>
          <li><a href="#">Prescription Drug Abuse Prevention (GENRx)</a></li>
          <li><a href="#">Suicide Prevention</a></li>
          <li><a href="#">DBHDD/OBHP</a></li>
          <li><a href="#">Red Ribbon Week</a></li>
          <li><a href="#">Contracts</a></li>
          <li><a href="#">Continuing Education</a></li>
	    </ul>

	    <h5>Most Popular FAQs</h5>
	    <ul class="nav list-unstyled">
          <li><a href="#">What Does GASPS Do?</a></li>
          <li><a href="#">How are GASPS initiatives funded?</a></li>
          <li><a href="#">What is substance abuse prevention?</a></li>
          <li><a href="#">What is the Strategic Prevention Framework?</a></li>
          <li><a href="#">How do I apply for GASPS funding?</a></li>
          <li><a href="#">What is workforce development?</a></li>
        </ul>
      </aside>	
    </div>
  </div>
</div>
<? snippet('footer') ?>
