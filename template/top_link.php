<?php
$social=array(
    'fa-twitter' => 'http://twitter.com/joyeriavirginia',
    'fa-facebook' => 'http://facebook.com/joyeriavirginia',
    'fa-rss' => Mage::getBaseUrl().'/rss',
);
?>

<ul class="social">
    <?php foreach($social as $class => $link) :
        echo "<li><a target='_blank' href='$link'><i class='fa $class'></i></a></li>";
    endforeach;
    echo "<li><a href='whatsapp://send' data-text='Joyería Virginia:' data-href='http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]'><i class='fa fa-whatsapp'></i></a></li>"; ?>
</ul>

<a href="tel:628 633 568">628 633 568</a>
 | Horario: 9.30 - 13.00 y 17.00 - 20.00 hs.