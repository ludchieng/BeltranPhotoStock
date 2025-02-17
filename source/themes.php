<?php $htmlTitle = "Thèmes — BeltranPhotoStock"; ?>
<?php $htmlSpecificCSS = ""; ?>


<?php ob_start(); ?>
<?php //-- BODY ---------------------------------------------- ?>

<?php require('./_header.php'); ?>
<section id="header-offset"></section>

<?php
$searchTitle = "Thèmes";
require('./_search.php');
?>

<main>
  <div class="container main-content">
    <br/>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=5">
          <img src="./public/assets/img-themes-sport.jpg">
          <div class="img-caption">Sport</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=15">
          <img src="./public/assets/img-themes-voyage.jpg">
          <div class="img-caption">Voyage</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=9">
          <img src="./public/assets/img-themes-urbain.jpg">
          <div class="img-caption">Urbain</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=10">
          <img src="./public/assets/img-themes-paysage.jpg">
          <div class="img-caption">Paysage</div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=13">
          <img src="./public/assets/img-themes-nourriture.jpg">
          <div class="img-caption">Nourriture</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=12">
          <img src="./public/assets/img-themes-lifestyle.jpg">
          <div class="img-caption">Lifestyle</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=11">
          <img src="./public/assets/img-themes-industrie.jpg">
          <div class="img-caption">Industrie</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=8">
          <img src="./public/assets/img-themes-musique.jpg">
          <div class="img-caption">Musique</div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=1">
          <img src="./public/assets/img-themes-science.jpg">
          <div class="img-caption">Science</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=2">
          <img src="./public/assets/img-themes-technologie.jpg">
          <div class="img-caption">Technologie</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=3">
          <img src="./public/assets/img-themes-architecture.jpg">
          <div class="img-caption">Architecture</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=6">
          <img src="./public/assets/img-themes-culture.jpg">
          <div class="img-caption">Culture</div>
        </a>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=7">
          <img src="./public/assets/img-themes-nature.jpg">
          <div class="img-caption">Nature</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=4">
          <img src="./public/assets/img-themes-abstrait.jpg">
          <div class="img-caption">Abstrait</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=14">
          <img src="./public/assets/img-themes-art.jpg">
          <div class="img-caption">Art</div>
        </a>
      </div>
      <div class="col-xs-6 col-md-3">
        <a href="./results.php?id_theme=16">
          <img src="./public/assets/img-themes-animaux.jpg">
          <div class="img-caption">Animaux</div>
        </a>
      </div>
    </div>
  </div>
</main>

<?php require('./_footer.php'); ?>

<?php //-- END BODY ------------------------------------------ ?>
<?php $htmlBody = ob_get_clean(); ?>


<?php	require('./_template.php'); ?>
