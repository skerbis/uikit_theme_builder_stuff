<?php
use FriendsOfRedaxo\MForm;
use UikitThemeBuilder\DomainContext;

$id = 1;

// MForm-Instanz für den Block
$mform = MForm::factory()
    ->addTabElement('<i class="fas fa-align-left"></i> Inhalte', MForm::factory()
        ->addTextField("$id.0.header", ['label' => '<i class="fas fa-font"></i> Kopfzeile:'])
        ->addMediaField(1, [
            'label' => '<i class="fas fa-image" aria-hidden="true"></i> Bild oder Video',
            'preview' => '1'
        ])
        ->addTextField("$id.0.imageTitle", ['label' => '<i class="fas fa-info-circle"></i> Bilduntertitel'])
        ->addTextField("$id.0.imageAlt", [
            'label' => '<i class="fas fa-eye"></i> ALT-Text:',
            'uk-tooltip' => 'Bitte beschreiben Sie das Bild. Vermeiden Sie Bezeichnungen wie Foto oder Bild'
        ])
        
        // Auswahlfeld Breite
        ->addSelectField("$id.0.ukWidth", [
            '1-1@m' => '100%',
            '2-3@m' => '66%',
            '1-2@m' => '50%',
            '1-3@m' => '33%',
            '1-4@m' => '25%',
            '1-5@m' => '20%',
            'expand@m' => 'Ausdehnen',
            'auto@m' => 'automatisch'
        ])->setLabel('<i class="fas fa-arrows-alt-h"></i> Breite:')->setAttribute('class', 'selectpicker')->setDefaultValue('auto@m')
        
        // Farben aus Theme
        ->addRadioColorField("$id.0.ukColor", DomainContext::getCardStyleOptions(), [
            'label' => '<i class="fas fa-palette"></i> Karten-Farbe:'
        ])

        // Textfeld für den Inhalt mit Editor
        ->addTextAreaField("$id.0.content", [
            'label' => '<i class="fas fa-align-left"></i> Text:',
            'data-lang' => \Cke5\Utils\Cke5Lang::getUserLang(),
            'data-profile' => 'default',
            'class' => 'cke5-editor'
        ])
        ->addCustomLinkField("$id.0.1", ['label' => '<i class="fas fa-link"></i> Link'])
        ->addTextField("$id.0.LinkText", ['label' => '<i class="fas fa-font"></i> Linktext (optional):'])
    , true)

    ->addTabElement('<i class="fas fa-cog"></i> Einstellungen', MForm::factory()
        ->addRadioImgField("$id.0.layout", [
            'media-top' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 120" width="80" height="96">
                        <rect width="100" height="120" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <rect x="5" y="5" width="90" height="45" fill="#666"/>
                        <line x1="10" y1="60" x2="70" y2="60" stroke="#999" stroke-width="2"/>
                        <line x1="10" y1="68" x2="90" y2="68" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="74" x2="80" y2="74" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="80" x2="85" y2="80" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Medium oben'
            ],
            'media-bottom' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 120" width="80" height="96">
                        <rect width="100" height="120" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <line x1="10" y1="10" x2="70" y2="10" stroke="#999" stroke-width="2"/>
                        <line x1="10" y1="18" x2="90" y2="18" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="24" x2="80" y2="24" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="30" x2="85" y2="30" stroke="#ccc" stroke-width="1.5"/>
                        <rect x="5" y="45" width="90" height="70" fill="#666"/>
                    </svg>
                '),
                'label' => 'Medium unten'
            ],
            'media-left' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <rect x="5" y="5" width="35" height="70" fill="#666"/>
                        <line x1="48" y1="15" x2="95" y2="15" stroke="#999" stroke-width="2"/>
                        <line x1="48" y1="25" x2="110" y2="25" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="48" y1="32" x2="100" y2="32" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="48" y1="39" x2="105" y2="39" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="48" y1="46" x2="95" y2="46" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Medium links'
            ],
            'media-right' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <line x1="10" y1="15" x2="57" y2="15" stroke="#999" stroke-width="2"/>
                        <line x1="10" y1="25" x2="72" y2="25" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="32" x2="62" y2="32" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="39" x2="67" y2="39" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="46" x2="57" y2="46" stroke="#ccc" stroke-width="1.5"/>
                        <rect x="80" y="5" width="35" height="70" fill="#666"/>
                    </svg>
                '),
                'label' => 'Medium rechts'
            ]
        ], [
            'label' => '<i class="fas fa-columns"></i> Layout',
            'default-value' => 'media-top'
        ])
        
        ->addSelectField("$id.0.mediaWidth", [
            '1-3@m' => '33% (Standard)',
            '1-4@m' => '25% (Schmal)',
            '1-2@m' => '50% (Mittel)',
            '2-3@m' => '66% (Breit)'
        ], [
            'label' => '<i class="fas fa-expand-arrows-alt"></i> Medien-Breite (nur bei links/rechts)',
            'class' => 'selectpicker',
            'default-value' => '1-3@m'
        ])
        
        ->addSelectField("$id.0.linkdiv", [
            '' => 'Nein',
            'linkdiv' => 'ja'
        ])->setLabel('<i class="fas fa-toggle-on"></i> Kachel verlinken')->setAttribute('class', 'selectpicker')->setDefaultValue('')

        ->addSelectField("$id.0.imgpadding", [
            '' => 'keine Füllung',
            ' uk-padding-small' => 'klein',
            ' uk-padding' => 'mittel'
        ])->setLabel('<i class="fas fa-expand"></i> Bildfüllung:')->setAttribute('class', 'selectpicker')->setDefaultValue('')
        
        ->addSelectField("$id.0.cardShadow", [
            '' => 'Standard (mit Schatten)',
            ' uk-card-hover' => 'Nur bei Hover',
            ' uk-shadow-remove' => 'Kein Schatten'
        ])->setLabel('<i class="fas fa-square"></i> Schatten:')->setAttribute('class', 'selectpicker')->setDefaultValue('')
    );

// Wrapper um MBlock-Blöcke zu zeigen
$blocks = MBlock::show($id, $mform->show(), ['max' => 100]);

// Hauptinstanz von MForm zur Verwaltung der Blöcke und Einstellungen
$main = MForm::factory()
    ->addTabElement('<i class="fas fa-th-large"></i> Karten', MForm::factory()->addHtml($blocks), true)
    
    // Card-spezifische Einstellungen
    ->addTabElement('<i class="fas fa-square"></i> Card Einstellungen', MForm::factory()
        ->addSelectField("2.0.gutterWidth", [
            'medium' => 'normal',
            'small' => 'eng',
            'large' => 'weit',
            'collapse' => 'entfernen'
        ])->setLabel('<i class="fas fa-arrows-alt-h"></i> Abstand der Kacheln:')->setAttribute('class', 'selectpicker')
        ->addDescription("Abstände zwischen den 'Cards' verändern")

        ->addSelectField("6.0.style", [
            'uk-card-default' => 'Standard',
            '' => 'Ohne Schatten'
        ])->setLabel('<i class="fas fa-cube"></i> Kachel-Stil')->setAttribute('class', 'selectpicker')

        ->addCheckboxField("2.0.matchHeight", [1 => 'Ja'], ['label' => '<i class="fas fa-arrows-alt-v"></i> Alle gleiche Höhe:'])
    )
    
    // Sektions-Einstellungen
    ->addTabElement('<i class="fas fa-layer-group"></i> Sektion', MForm::factory()
        ->addSelectField("9.0.container", [
            'uk-container' => 'Standard',
            'uk-container uk-container-xsmall' => 'Extra schmal (xsmall)',
            'uk-container uk-container-small' => 'Schmal (small)',
            'uk-container uk-container-large' => 'Weit (large)',
            'uk-container uk-container-xlarge' => 'Extra weit (xlarge)',
            'uk-container uk-container-expand' => 'Maximale Breite (expand)',
            '' => 'Volle Breite (kein Container)'
        ])->setLabel('<i class="fas fa-expand-arrows-alt"></i> Container-Breite')->setAttribute('class', 'selectpicker')->setDefaultValue('uk-container')

        ->addMediaField(1, ['label' => '<i class="fas fa-image"></i> Hintergrundbild'])

        // Farben aus Theme für die Sektion
        ->addRadioColorField("3.0.ukcolor", DomainContext::getBackgroundOptions(), [
            'label' => '<i class="fas fa-palette"></i> Hintergrundfarbe:'
        ])

        ->addSelectField("14.0.padding", [
            '' => 'Sektions-Standard',
            ' uk-padding-remove' => 'Keine Füllung',
            ' uk-padding-small' => 'Klein',
            ' uk-padding' => 'Mittel',
            ' uk-padding-large' => 'Groß',
            ' uk-padding-remove-top' => 'Füllung oben entfernen',
            ' uk-padding-remove-bottom' => 'Füllung unten entfernen'
        ], ['label' => '<i class="fas fa-arrows-alt-v"></i> Abschnittsfüllung', 'class' => 'selectpicker', 'default-value' => ''])

        ->addSelectField("15.0.width", [
            '' => 'Standard',
            'full-width ' => 'Volle Bildschirmbreite'
        ], ['label' => '<i class="fas fa-arrows-alt-h"></i> Abschnittsbreite', 'class' => 'selectpicker'])
    );

echo $main->show();
?>
<style>
/* Fügt ein visuelles Symbol nach dem Soft Hyphen hinzu */
/* Zielt auf die Editing-View des CKEditor ab */
.ck-editor__editable .ck-content *:has([\u00AD]),
.ck-editor__editable *:has([\u00AD]) {
  position: relative;
  background-color: #ffeeee;
  border: 1px dashed #ff0000;
  margin: 0 2px;
}

</style>
