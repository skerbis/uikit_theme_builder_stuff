<?php
use FriendsOfRedaxo\MForm;
echo date('Y-m-d H:i:s');
$mform = new MForm();

$mform->addFieldsetArea('1. Ebene', MForm::factory()
->addTextField(16, array(
    'label' => 'Überschrift'
))                       
->addSelectField(17, array(
    'h1'=>'Überschrift 1 (bitte nur einmal je Seite)',
    'h2'=>'Überschrift 2',
    'h3'=>'Überschrift 3'
    ), array('label'=>'Ebene', 'class'=>'selectpicker'))
->addSelectField(18, array(
    'my_default'=>'Standard',
    'uk-heading-small'=>'Klein',
    'uk-heading-medium'=>'Medium',
    'uk-heading-large'=>'Groß',
    ), array('label'=>'Größe', 'class'=>'selectpicker'))
->addSelectField(19, array(
    ' uk-heading-line uk-text-center'=>'Standard: Mittel-Linie Zentriert',
    ' uk-heading-divider'=>'unterstrichen',
    ' my_default'=>'Einfach'
    ), array('label'=>'Design', 'class'=>'selectpicker'))
                          )


->addFieldsetArea('2. Ebene', MForm::factory()

->addTextField(15, array(
    'label' => 'Sub-Text'
))
->addSelectField(14, array(
    'h2'=>'Überschrift 2',
    'h3'=>'Überschrift 3',
    'h4'=>'Überschrift 4'
    ), array('label'=>'Ebene', 'class'=>'selectpicker'))

->addSelectField(13, array(
    ' uk-text-center'=>'ja: Standard ',
    ' default'=>'nein',
    
    ), array('label'=>'zenrtiert', 'class'=>'selectpicker'))
                       )
    
    
    ->addSelectField("2")
->setLabel('Hintergrund-Farbe:')
->setOptions(array(
    'default uk-padding-remove' => 'Standard',
    'primary uk-light uk-padding-small ' => 'Hauptfarbe',
    'muted uk-padding-small' => 'hell',
    'secondary uk-light uk-padding-small' => 'Sekundärfarbe',
))   
    
    
    ;

echo $mform->show();