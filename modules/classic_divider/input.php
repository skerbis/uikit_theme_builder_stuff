<?php
use FriendsOfRedaxo\MForm;
$mform = new MForm();
$mform->addSelectField(1, array('uk-padding-small'=>'klein','uk-padding'=>'mittel','uk-padding-large'=>'groß','hr'=>' Trennline','uk-divider-icon'=>'Trennlinie mit Icon'), array('label'=>'Neuer Abschnitt', 'class'=>'selectpicker'));
echo $mform->show();