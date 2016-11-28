<?php #if(!isset($_GET['qz'])){return;} ?>

<?php
$home_url=Mage::getBaseUrl();
?>

<div id="home_slider">
    <?php echo $this->getLayout()->createBlock("cms/block")->setBlockId("home_slider")->toHtml(); ?>
</div>

<div id="category_tabs">
    <?php echo $this->getLayout()->createBlock("cms/block")->setBlockId("category_tabs")->toHtml(); ?>
</div><!--<p>{{block type="core/template" template="page/home.phtml"}}</p>-->

<div id="home_blocks">
    <?php echo $this->getLayout()->createBlock("cms/block")->setBlockId("home_blocks")->toHtml(); ?>
</div>


<div id="cat_slider" class="tab_container <?php echo Mage::app()->getStore()->getCode() ?>">
    <ul class="bxslider">
        <li>
            <h2><a href="<?php echo $home_url ?>/regalos-de-bebe" rel="follow">
                    <img title="Joyeria Online regalos de bebe" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_regalos_de_bebe.png" alt="Regalos de bebe" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/medallas-de-oro" rel="follow">
                    <img title="Joyeria online medallas de oro" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_medallas.png" alt="Medallas joyeria virginia" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/brillantes-de-senora" rel="follow">
                    <img title="Joyeria Online brillantes de se&ntilde;ora" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_brillantes.png" alt="Brillantes de Se&ntilde;ora" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/joyeria-personalizada" rel="follow">
                    <img title="Joyeria Online joyeria personalizada" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_joyeria_personalizada.png" alt="Joyer&iacute;a Personalizada" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/relojes-cyma" rel="follow">
                    <img title="Joyeria Online relojes cyma" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_relojes.png" alt="Relojes Cyma" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/abalorios-de-plata" rel="follow">
                    <img title="Joyeria Online abalorios de plata" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_abalorios.png" alt="Abalorios de Plata" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/nueve-kilates" rel="follow">
                    <img title="Joyeria Online nueve kilates" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_nueve_kilates.png" alt="Nueve Kilates" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/cadenas-de-oro" rel="follow">
                    <img title="Joyeria Online cadenas finas y gruesas" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_cadenas.png" alt="Cadenas Finas y gruesas" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/joyas-de-futbol/" rel="follow">
                    <img title="Joyeria Online futbol oro" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_futbol_oro.png" alt="Joyeria Futbol oro" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/joyas-de-futbol/" rel="follow">
                    <img title="Joyeria Online futbol plata" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_futbol_plata.png" alt="Joyeria Futbol Plata" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/joyeria/piercing/" rel="follow">
                    <img title="Joyeria Online piercing" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_piercing.png" alt="Piercing" /></a></h2>
        </li>
        <li>
            <h2><a href="<?php echo $home_url ?>/cruces-de-oro" rel="follow">
                    <img title="Joyeria Online cruces de bautismo" src="<?php echo $home_url ?>/skin/frontend/default/joyeria_virginia/images/imagenes/categoria_cruces.png" alt="Cruces de Bautismo" /></a></h2>
        </li>
    </ul>
</div>

<style>
    .cuadro-categorias{display: none}
</style>

