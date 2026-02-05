<?php
use FriendsOfRedaxo\MForm;
use UikitThemeBuilder\DomainContext;

$id = 1;

// Prüfe ob bereits eine H1 auf dieser Seite existiert (via rex_property)
$hasH1 = rex::getProperty('h1_used', false);

// Heading Level Optionen (H1 nur wenn noch nicht vorhanden)
$headingOptions = [
    'h2' => 'H2 - Zwischenüberschrift',
    'h3' => 'H3 - Unterüberschrift',
    'h4' => 'H4 - Kleinere Überschrift',
    'h5' => 'H5 - Sehr kleine Überschrift',
    'h6' => 'H6 - Minimale Überschrift'
];

if (!$hasH1) {
    $headingOptions = ['h1' => 'H1 - Hauptüberschrift'] + $headingOptions;
}

// MForm für Überschrift
$mform = MForm::factory()
    // Tab 1: Inhalt
    ->addTabElement('<i class="fas fa-heading"></i> Überschrift', MForm::factory()
        ->addElement('html', $hasH1 ? '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> <strong>Hinweis:</strong> H1 ist bereits auf dieser Seite verwendet und steht daher nicht zur Auswahl.</div>' : '')
        
        ->addSelectField("$id.0.heading_level", $headingOptions, [
            'label' => '<i class="fas fa-list-ol"></i> Überschrift-Ebene',
            'class' => 'selectpicker',
            'default-value' => $hasH1 ? 'h2' : 'h1'
        ])
        
        ->addTextAreaField("$id.0.heading_text", [
            'label' => '<i class="fas fa-heading"></i> Überschrift',
            'class' => 'form-control',
            'rows' => 2
        ])
        
        ->addTextField("$id.0.subtitle", [
            'label' => '<i class="fas fa-text-height"></i> Untertitel (optional)',
            'placeholder' => 'z.B. "Entspannung & Wellness" oder "Für Ihren perfekten Aufenthalt"'
        ])
    , true) // Aktiver Tab
    
    // Tab 2: Styling
    ->addTabElement('<i class="fas fa-palette"></i> Styling', MForm::factory()
        ->addSelectField("$id.0.heading_style", [
            'uk-heading-medium' => 'Mittel (Standard)',
            'uk-heading-small' => 'Klein',
            'uk-heading-large' => 'Groß',
            'uk-heading-xlarge' => 'Extra Groß',
            'uk-text-lead' => 'Lead-Text (größerer Fließtext)'
        ], [
            'label' => '<i class="fas fa-text-height"></i> Überschrift-Größe',
            'class' => 'selectpicker',
            'default-value' => 'uk-heading-medium'
        ])
        
        ->addSelectField("$id.0.subtitle_style", [
            'uk-text-lead' => 'Lead-Text (größerer Fließtext)',
            'uk-text-default' => 'Standard-Text',
            'uk-text-small' => 'Kleiner Text',
            'uk-text-meta' => 'Meta-Text (sehr klein)',
            'uk-heading-small' => 'Klein-Überschrift',
            'uk-heading-medium' => 'Mittel-Überschrift'
        ], [
            'label' => '<i class="fas fa-text-width"></i> Untertitel-Größe',
            'class' => 'selectpicker',
            'default-value' => 'uk-text-lead'
        ])
        
        ->addSelectField("$id.0.title_margin", [
            'uk-margin-medium' => 'Standard-Abstand',
            'uk-margin-large' => 'Großer Abstand',
            'uk-margin' => 'Kleiner Abstand',
            'uk-margin-small' => 'Sehr kleiner Abstand'
        ], [
            'label' => '<i class="fas fa-arrows-alt-v"></i> Abstand nach Überschrift',
            'class' => 'selectpicker',
            'default-value' => 'uk-margin-medium',
            'help' => 'Abstand zwischen Überschrift und folgendem Inhalt'
        ])
        
        ->addSelectField("$id.0.text_align", [
            '' => 'Linksbündig (Standard)',
            'uk-text-center' => 'Zentriert',
            'uk-text-right' => 'Rechtsbündig'
        ], [
            'label' => '<i class="fas fa-align-center"></i> Text-Ausrichtung',
            'class' => 'selectpicker',
            'default-value' => ''
        ])
    )
    
    // Tab 3: Sektion
    ->addTabElement('<i class="fas fa-cogs"></i> Sektion', MForm::factory()
        ->addRadioColorField("$id.0.background_style", DomainContext::getBackgroundOptions(), [
            'label' => '<i class="fas fa-palette"></i> Sektion-Hintergrund'
        ])
        
        ->addRadioImgField("$id.0.padding", [
            'uk-padding-large' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="44" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="11" y="11" width="38" height="28" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Groß'
            ],
            'uk-padding' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="44" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="8" y="8" width="44" height="34" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Mittel'
            ],
            'uk-padding-small' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="44" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="6" y="6" width="48" height="38" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Klein'
            ],
            '' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="44" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="4" y="4" width="52" height="42" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Kein Padding'
            ]
        ], ['label' => '<i class="fas fa-expand"></i> Sektion-Abstand'])
        
        ->addRadioImgField("$id.0.container", [
            '' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="2" y="20" width="56" height="10" fill="#666"/>
                    </svg>
                '),
                'label' => 'Volle Breite'
            ],
            'uk-container uk-container-large' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="6" y="20" width="48" height="10" fill="#666"/>
                    </svg>
                '),
                'label' => 'Large (1600px)'
            ],
            'uk-container' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="10" y="20" width="40" height="10" fill="#666"/>
                    </svg>
                '),
                'label' => 'Standard (1200px)'
            ]
        ], ['label' => '<i class="fas fa-arrows-alt-h"></i> Container-Breite'])
    );

echo $mform->show();
