<?php
use FriendsOfRedaxo\MForm;
use UikitThemeBuilder\DomainContext;

$id = 1;

// MForm für einzelne Text & Medien Blöcke
$mform = MForm::factory()
    // Tab 1: Inhalt
    ->addTabElement('<i class="fas fa-edit"></i> Inhalt', MForm::factory()
        ->addTextAreaField("$id.0.content", [
            'label' => '<i class="fas fa-align-left"></i> Fließtext:',
            'data-lang' => \Cke5\Utils\Cke5Lang::getUserLang(),
            'data-profile' => 'default',
            'class' => 'cke5-editor',
            'placeholder' => 'Hier den Haupttext eingeben...'
        ])
        ->addMedialistField("1", [
            'label' => '<i class="fas fa-photo-video"></i> Medien (Bild/Video/Galerie)',
            'preview' => '1'
        ])
        ->addTextField("$id.0.media_caption", [
            'label' => '<i class="fas fa-closed-captioning"></i> Medien-Untertitel (optional):',
            'placeholder' => 'z.B. "Unser Hotel-Garten im Frühling"'
        ])
        ->addTextField("$id.0.badge_text", [
            'label' => '<i class="fas fa-tag"></i> Schräges Badge (optional):',
            'placeholder' => 'z.B. "Neu" oder "Exklusiv"',
            'help' => 'Erscheint als schräges Badge über der oberen rechten Ecke der Medien'
        ])
        ->addCheckboxField("$id.0.enable_lightbox", ['1' => 'Lightbox für Einzelbilder/Videos aktivieren'], [
            'label' => '<i class="fas fa-expand"></i> Lightbox:',
            'help' => 'Ermöglicht Vergrößerung von Einzelbildern und Vollbild-Video-Wiedergabe',
            'default-value' => '1'
        ])
    , true) // Aktiver Tab
    
    // Tab 2: Überschriften
    ->addTabElement('<i class="fas fa-heading"></i> Überschriften', MForm::factory()
        ->addTextField("$id.0.title", [
            'label' => '<i class="fas fa-heading"></i> Überschrift (optional):',
            'placeholder' => 'z.B. "Unsere Geschichte" oder "Wellness & Entspannung"'
        ])
        ->addTextField("$id.0.subtitle", [
            'label' => '<i class="fas fa-text-height"></i> Untertitel (optional):',
            'placeholder' => 'z.B. "Entspannung & Wellness" oder "Für Ihren perfekten Aufenthalt"'
        ])
        ->addSelectField("$id.0.heading_level", [
            'h2' => 'H2 - Zwischenüberschrift',
            'h3' => 'H3 - Unterüberschrift',
            'h4' => 'H4 - Kleinere Überschrift',
            'h5' => 'H5 - Sehr kleine Überschrift',
            'h6' => 'H6 - Minimale Überschrift'
        ], ['label' => '<i class="fas fa-list-ol"></i> Überschrift-Ebene', 'class' => 'selectpicker', 'default-value' => 'h3'])
        
        ->addSelectField("$id.0.heading_style", [
            'uk-heading-medium' => 'Mittel (Standard)',
            'uk-heading-small' => 'Klein',
            'uk-heading-large' => 'Groß',
            'uk-heading-xlarge' => 'Extra Groß',
            'uk-text-lead' => 'Lead-Text (größerer Fließtext)'
        ], ['label' => '<i class="fas fa-text-height"></i> Überschrift-Größe', 'class' => 'selectpicker', 'default-value' => 'uk-heading-medium'])
        
        ->addSelectField("$id.0.subtitle_style", [
            'uk-text-lead' => 'Lead-Text (größerer Fließtext)',
            'uk-text-default' => 'Standard-Text',
            'uk-text-small' => 'Kleiner Text',
            'uk-text-meta' => 'Meta-Text (sehr klein)',
            'uk-heading-small' => 'Klein-Überschrift',
            'uk-heading-medium' => 'Mittel-Überschrift'
        ], ['label' => '<i class="fas fa-text-width"></i> Untertitel-Größe', 'class' => 'selectpicker', 'default-value' => 'uk-text-lead'])
        
        ->addSelectField("$id.0.title_margin", [
            'uk-margin-medium' => 'Standard-Abstand',
            'uk-margin-large' => 'Großer Abstand',
            'uk-margin' => 'Kleiner Abstand',
            'uk-margin-small' => 'Sehr kleiner Abstand'
        ], ['label' => '<i class="fas fa-arrows-alt-v"></i> Abstand nach Überschrift', 'class' => 'selectpicker', 'default-value' => 'uk-margin-medium', 'help' => 'Abstand zwischen Überschrift und Inhalt'])
        
        ->addSelectField("$id.0.text_align", [
            '' => 'Linksbündig (Standard)',
            'uk-text-center' => 'Zentriert',
            'uk-text-right' => 'Rechtsbündig'
        ], ['label' => '<i class="fas fa-align-center"></i> Text-Ausrichtung', 'class' => 'selectpicker', 'default-value' => '', 'help' => 'Ausrichtung für Überschrift und Untertitel'])
    )
    
    // Tab 3: Layout
    ->addTabElement('<i class="fas fa-layout-alt"></i> Layout', MForm::factory()
        ->addRadioImgField("$id.0.layout", [
            'text-left-media-right' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <line x1="10" y1="15" x2="47" y2="15" stroke="#999" stroke-width="2"/>
                        <line x1="10" y1="25" x2="52" y2="25" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="32" x2="48" y2="32" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="39" x2="50" y2="39" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="46" x2="45" y2="46" stroke="#ccc" stroke-width="1.5"/>
                        <rect x="68" y="5" width="47" height="70" fill="#666"/>
                    </svg>
                '),
                'label' => 'Text links, Medien rechts'
            ],
            'text-right-media-left' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <rect x="5" y="5" width="47" height="70" fill="#666"/>
                        <line x1="68" y1="15" x2="105" y2="15" stroke="#999" stroke-width="2"/>
                        <line x1="68" y1="25" x2="110" y2="25" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="68" y1="32" x2="106" y2="32" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="68" y1="39" x2="108" y2="39" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="68" y1="46" x2="103" y2="46" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Medien links, Text rechts'
            ],
            'text-bottom-media-top' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <rect x="5" y="5" width="110" height="40" fill="#666"/>
                        <line x1="10" y1="52" x2="110" y2="52" stroke="#999" stroke-width="2"/>
                        <line x1="10" y1="60" x2="110" y2="60" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="67" x2="100" y2="67" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Medien oben, Text unten'
            ],
            'text-top-media-bottom' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <line x1="10" y1="15" x2="110" y2="15" stroke="#999" stroke-width="2"/>
                        <line x1="10" y1="23" x2="110" y2="23" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="30" x2="100" y2="30" stroke="#ccc" stroke-width="1.5"/>
                        <rect x="5" y="40" width="110" height="35" fill="#666"/>
                    </svg>
                '),
                'label' => 'Text oben, Medien unten'
            ],
            'text-only' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <line x1="10" y1="15" x2="70" y2="15" stroke="#999" stroke-width="2.5"/>
                        <line x1="10" y1="25" x2="110" y2="25" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="32" x2="105" y2="32" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="39" x2="108" y2="39" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="46" x2="100" y2="46" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="53" x2="110" y2="53" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="10" y1="60" x2="95" y2="60" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Nur Text'
            ],
            'media-only' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 80" width="120" height="80">
                        <rect width="120" height="80" fill="#f8f8f8" stroke="#333" stroke-width="2"/>
                        <rect x="5" y="5" width="110" height="70" fill="#666"/>
                        <circle cx="35" cy="30" r="8" fill="#999"/>
                        <polygon points="50,50 65,35 80,45 90,30 110,60" fill="#555"/>
                    </svg>
                '),
                'label' => 'Nur Medien'
            ]
        ], ['label' => '<i class="fas fa-columns"></i> Layout-Typ'])
        
        ->addRadioImgField("$id.0.text_width", [
            'uk-width-1-2@m' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 40" width="60" height="30">
                        <rect width="80" height="40" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="2" y="2" width="36" height="36" fill="#999"/>
                        <rect x="42" y="2" width="36" height="36" fill="#ccc"/>
                    </svg>
                '),
                'label' => '50/50'
            ],
            'uk-width-2-3@m' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 40" width="60" height="30">
                        <rect width="80" height="40" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="2" y="2" width="50" height="36" fill="#999"/>
                        <rect x="56" y="2" width="22" height="36" fill="#ccc"/>
                    </svg>
                '),
                'label' => '66/33'
            ],
            'uk-width-1-3@m' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 40" width="60" height="30">
                        <rect width="80" height="40" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="2" y="2" width="22" height="36" fill="#999"/>
                        <rect x="28" y="2" width="50" height="36" fill="#ccc"/>
                    </svg>
                '),
                'label' => '33/66'
            ],
            'uk-width-3-4@m' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 40" width="60" height="30">
                        <rect width="80" height="40" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="2" y="2" width="56" height="36" fill="#999"/>
                        <rect x="62" y="2" width="16" height="36" fill="#ccc"/>
                    </svg>
                '),
                'label' => '75/25'
            ],
            'uk-width-1-4@m' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 80 40" width="60" height="30">
                        <rect width="80" height="40" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="2" y="2" width="16" height="36" fill="#999"/>
                        <rect x="22" y="2" width="56" height="36" fill="#ccc"/>
                    </svg>
                '),
                'label' => '25/75'
            ]
        ], ['label' => '<i class="fas fa-arrows-alt-h"></i> Verhältnis Text/Medien'])
        
        ->addRadioImgField("$id.0.media_center", [
            '' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="5" y="5" width="20" height="15" fill="#666"/>
                        <line x1="30" y1="8" x2="52" y2="8" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="30" y1="13" x2="52" y2="13" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="30" y1="18" x2="52" y2="18" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Oben'
            ],
            'uk-flex-middle' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="5" y="17" width="20" height="15" fill="#666"/>
                        <line x1="30" y1="20" x2="52" y2="20" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="30" y1="25" x2="52" y2="25" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="30" y1="30" x2="52" y2="30" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Zentriert'
            ],
            'uk-flex-bottom' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="5" y="29" width="20" height="15" fill="#666"/>
                        <line x1="30" y1="32" x2="52" y2="32" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="30" y1="37" x2="52" y2="37" stroke="#ccc" stroke-width="1.5"/>
                        <line x1="30" y1="42" x2="52" y2="42" stroke="#ccc" stroke-width="1.5"/>
                    </svg>
                '),
                'label' => 'Unten'
            ]
        ], ['label' => '<i class="fas fa-align-center"></i> Medien-Ausrichtung'])
        
        ->addRadioImgField("$id.0.multi_media_display", [
            'masonry' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="3" y="3" width="17" height="20" fill="#666"/>
                        <rect x="22" y="3" width="17" height="14" fill="#888"/>
                        <rect x="41" y="3" width="17" height="22" fill="#777"/>
                        <rect x="3" y="25" width="17" height="22" fill="#777"/>
                        <rect x="22" y="19" width="17" height="28" fill="#666"/>
                        <rect x="41" y="27" width="17" height="20" fill="#888"/>
                    </svg>
                '),
                'label' => 'Masonry'
            ],
            'grid' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="3" y="3" width="17" height="17" fill="#666"/>
                        <rect x="22" y="3" width="17" height="17" fill="#888"/>
                        <rect x="41" y="3" width="17" height="17" fill="#777"/>
                        <rect x="3" y="22" width="17" height="17" fill="#888"/>
                        <rect x="22" y="22" width="17" height="17" fill="#777"/>
                        <rect x="41" y="22" width="17" height="17" fill="#666"/>
                    </svg>
                '),
                'label' => 'Grid'
            ],
            'slideshow' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="5" y="5" width="50" height="30" fill="#666"/>
                        <circle cx="15" cy="41" r="2.5" fill="#999"/>
                        <circle cx="25" cy="41" r="2.5" fill="#ccc"/>
                        <circle cx="35" cy="41" r="2.5" fill="#ccc"/>
                        <circle cx="45" cy="41" r="2.5" fill="#ccc"/>
                    </svg>
                '),
                'label' => 'Standard Slideshow'
            ],
            'slideshow-gallery' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="5" y="5" width="50" height="30" fill="#666"/>
                        <rect x="5" y="38" width="8" height="6" fill="#999"/>
                        <rect x="15" y="38" width="8" height="6" fill="#ccc"/>
                        <rect x="25" y="38" width="8" height="6" fill="#ccc"/>
                        <rect x="35" y="38" width="8" height="6" fill="#ccc"/>
                        <rect x="45" y="38" width="8" height="6" fill="#ccc"/>
                    </svg>
                '),
                'label' => 'Slideshow Gallery (Thumbs unten)'
            ]
        ], ['label' => '<i class="fas fa-images"></i> Mehrere Medien als:'])
        
        ->addElement('html', '<hr><div class="uk-alert uk-alert-primary"><i class="fas fa-info-circle"></i> Slideshow Einstellungen (werden nur bei Slideshow-Varianten angewendet)</div>')
        
        ->addCheckboxField("$id.0.slideshow_autoplay", ['1' => 'Autoplay aktivieren (Wechsel alle 6 Sekunden)'], ['label' => 'Autoplay'])
        ->addSelectField("$id.0.slideshow_animation", [
            'slide' => 'Slide (Schieben)',
            'fade' => 'Fade (Überblenden)',
            'scale' => 'Scale (Zoom)',
            'pull' => 'Pull (Ziehen)',
            'push' => 'Push (Drücken)'
        ], ['label' => 'Animation', 'class' => 'selectpicker', 'default-value' => 'slide'])
        ->addTextField("$id.0.slideshow_ratio", [
            'label' => 'Seitenverhältnis (Ratio)',
            'placeholder' => 'z.B. 16:9, 4:3 oder False',
            'help' => 'Optional. Standard ist meist 16:9 oder angepasst an Inhalt.'
        ])
    );

// MBlock erstellen
$blocks = MBlock::show($id, $mform->show(), [
    'max' => 10,
    'min' => 1
]);

// Haupt-MForm mit globalen Einstellungen
$main = MForm::factory()
    ->addTabElement('<i class="fas fa-magic"></i> Text & Medien Blöcke', MForm::factory()
        ->addHtml($blocks)
    , true)
    
    ->addTabElement('<i class="fas fa-cogs"></i> Globale Einstellungen', MForm::factory()
        ->addRadioColorField("2.0.background_style", DomainContext::getBackgroundOptions(), [
            'label' => '<i class="fas fa-palette"></i> Sektion-Hintergrund'
        ])
        
        ->addRadioImgField("2.0.padding", [
            'uk-padding-large' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="11" y="8" width="38" height="9" fill="#ddd" rx="1"/>
                        <rect x="3" y="28" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="11" y="33" width="38" height="9" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Groß'
            ],
            'uk-padding' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="8" y="7" width="44" height="11" fill="#ddd" rx="1"/>
                        <rect x="3" y="28" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="8" y="32" width="44" height="11" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Mittel'
            ],
            'uk-padding-small' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="6" y="6" width="48" height="13" fill="#ddd" rx="1"/>
                        <rect x="3" y="28" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="6" y="31" width="48" height="13" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Klein'
            ],
            '' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8"/>
                        <rect x="3" y="3" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="4" y="4" width="52" height="17" fill="#ddd" rx="1"/>
                        <rect x="3" y="28" width="54" height="19" fill="#fff" stroke="#999" stroke-width="1" rx="2"/>
                        <rect x="4" y="29" width="52" height="17" fill="#ddd" rx="1"/>
                    </svg>
                '),
                'label' => 'Kein Padding'
            ]
        ], ['label' => '<i class="fas fa-expand"></i> Sektion-Abstand'])
        
        ->addRadioImgField("2.0.container", [
            '' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="2" y="10" width="56" height="30" fill="#666"/>
                    </svg>
                '),
                'label' => 'Volle Breite'
            ],
            'uk-container uk-container-large' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="6" y="10" width="48" height="30" fill="#666"/>
                    </svg>
                '),
                'label' => 'Large (1600px)'
            ],
            'uk-container' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 50" width="50" height="42">
                        <rect width="60" height="50" fill="#f8f8f8" stroke="#333" stroke-width="1.5"/>
                        <rect x="10" y="10" width="40" height="30" fill="#666"/>
                    </svg>
                '),
                'label' => 'Standard (1200px)'
            ]
        ], ['label' => '<i class="fas fa-arrows-alt-h"></i> Container-Breite'])
        
        ->addRadioImgField("2.0.gap", [
            'uk-margin-large' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 60" width="58" height="50">
                        <rect width="70" height="60" fill="#f8f8f8"/>
                        <!-- Block 1: Bild links, Text rechts -->
                        <rect x="3" y="2" width="64" height="12" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <rect x="5" y="4" width="8" height="8" fill="#999"/>
                        <line x1="15" y1="6" x2="32" y2="6" stroke="#666" stroke-width="0.8"/>
                        <line x1="15" y1="9" x2="28" y2="9" stroke="#ccc" stroke-width="0.6"/>
                        <!-- Block 2: Bild rechts, Text links -->
                        <rect x="3" y="24" width="64" height="12" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="27" x2="22" y2="27" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="30" x2="18" y2="30" stroke="#ccc" stroke-width="0.6"/>
                        <rect x="54" y="26" width="8" height="8" fill="#999"/>
                        <!-- Block 3: Nur Text -->
                        <rect x="3" y="46" width="64" height="12" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="49" x2="35" y2="49" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="52" x2="60" y2="52" stroke="#ccc" stroke-width="0.6"/>
                        <line x1="5" y1="55" x2="45" y2="55" stroke="#ccc" stroke-width="0.6"/>
                    </svg>
                '),
                'label' => 'Groß'
            ],
            'uk-margin-medium' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 60" width="58" height="50">
                        <rect width="70" height="60" fill="#f8f8f8"/>
                        <!-- Block 1: Bild links, Text rechts -->
                        <rect x="3" y="2" width="64" height="14" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <rect x="5" y="4" width="9" height="10" fill="#999"/>
                        <line x1="16" y1="6" x2="33" y2="6" stroke="#666" stroke-width="0.8"/>
                        <line x1="16" y1="9" x2="29" y2="9" stroke="#ccc" stroke-width="0.6"/>
                        <!-- Block 2: Bild rechts, Text links -->
                        <rect x="3" y="23" width="64" height="14" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="26" x2="22" y2="26" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="29" x2="18" y2="29" stroke="#ccc" stroke-width="0.6"/>
                        <rect x="53" y="25" width="9" height="10" fill="#999"/>
                        <!-- Block 3: Nur Text -->
                        <rect x="3" y="44" width="64" height="14" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="47" x2="35" y2="47" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="50" x2="60" y2="50" stroke="#ccc" stroke-width="0.6"/>
                        <line x1="5" y1="53" x2="45" y2="53" stroke="#ccc" stroke-width="0.6"/>
                    </svg>
                '),
                'label' => 'Mittel'
            ],
            'uk-margin' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 60" width="58" height="50">
                        <rect width="70" height="60" fill="#f8f8f8"/>
                        <!-- Block 1: Bild links, Text rechts -->
                        <rect x="3" y="2" width="64" height="16" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <rect x="5" y="4" width="10" height="12" fill="#999"/>
                        <line x1="17" y1="7" x2="34" y2="7" stroke="#666" stroke-width="0.8"/>
                        <line x1="17" y1="10" x2="30" y2="10" stroke="#ccc" stroke-width="0.6"/>
                        <!-- Block 2: Bild rechts, Text links -->
                        <rect x="3" y="21" width="64" height="16" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="25" x2="22" y2="25" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="28" x2="18" y2="28" stroke="#ccc" stroke-width="0.6"/>
                        <rect x="52" y="23" width="10" height="12" fill="#999"/>
                        <!-- Block 3: Nur Text -->
                        <rect x="3" y="40" width="64" height="16" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="44" x2="35" y2="44" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="47" x2="60" y2="47" stroke="#ccc" stroke-width="0.6"/>
                        <line x1="5" y1="50" x2="45" y2="50" stroke="#ccc" stroke-width="0.6"/>
                    </svg>
                '),
                'label' => 'Klein'
            ],
            '' => [
                'img' => "data:image/svg+xml;base64," . base64_encode('
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 60" width="58" height="50">
                        <rect width="70" height="60" fill="#f8f8f8"/>
                        <!-- Block 1: Bild links, Text rechts -->
                        <rect x="3" y="2" width="64" height="17" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <rect x="5" y="4" width="10" height="13" fill="#999"/>
                        <line x1="17" y1="7" x2="34" y2="7" stroke="#666" stroke-width="0.8"/>
                        <line x1="17" y1="10" x2="30" y2="10" stroke="#ccc" stroke-width="0.6"/>
                        <line x1="17" y1="13" x2="32" y2="13" stroke="#ccc" stroke-width="0.6"/>
                        <!-- Block 2: Bild rechts, Text links -->
                        <rect x="3" y="20" width="64" height="17" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="24" x2="22" y2="24" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="27" x2="18" y2="27" stroke="#ccc" stroke-width="0.6"/>
                        <line x1="5" y1="30" x2="20" y2="30" stroke="#ccc" stroke-width="0.6"/>
                        <rect x="52" y="22" width="10" height="13" fill="#999"/>
                        <!-- Block 3: Nur Text -->
                        <rect x="3" y="38" width="64" height="17" fill="#fff" stroke="#ccc" stroke-width="1" rx="2"/>
                        <line x1="5" y1="42" x2="35" y2="42" stroke="#666" stroke-width="0.8"/>
                        <line x1="5" y1="45" x2="60" y2="45" stroke="#ccc" stroke-width="0.6"/>
                        <line x1="5" y1="48" x2="45" y2="48" stroke="#ccc" stroke-width="0.6"/>
                        <line x1="5" y1="51" x2="55" y2="51" stroke="#ccc" stroke-width="0.6"/>
                    </svg>
                '),
                'label' => 'Minimal'
            ]
        ], ['label' => '<i class="fas fa-arrows-alt-v"></i> Abstand zwischen Blöcken'])
    );

echo $main->show();