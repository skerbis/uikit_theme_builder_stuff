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
        ->addSelectField("$id.0.layout", [
            'text-left-media-right' => 'Text links, Medien rechts',
            'text-right-media-left' => 'Medien links, Text rechts',
            'text-only' => 'Nur Text (ohne Medien)',
            'media-only' => 'Nur Medien (ohne Text)'
        ], ['label' => '<i class="fas fa-columns"></i> Layout-Typ', 'class' => 'selectpicker', 'default-value' => 'text-left-media-right'])
        
        ->addSelectField("$id.0.text_width", [
            'uk-width-1-2@m' => '50/50 - Ausgeglichen',
            'uk-width-2-3@m' => '66/33 - Text größer',
            'uk-width-1-3@m' => '33/66 - Medien größer',
            'uk-width-3-4@m' => '75/25 - Text dominant',
            'uk-width-1-4@m' => '25/75 - Medien dominant'
        ], ['label' => '<i class="fas fa-arrows-alt-h"></i> Verhältnis Text/Medien', 'class' => 'selectpicker', 'default-value' => 'uk-width-1-2@m'])
        
        ->addSelectField("$id.0.media_center", [
            '' => 'Oben ausgerichtet',
            'uk-flex-middle' => 'Vertikal zentriert',
            'uk-flex-bottom' => 'Unten ausgerichtet'
        ], ['label' => '<i class="fas fa-align-center"></i> Medien-Ausrichtung', 'class' => 'selectpicker', 'default-value' => ''])
        
        ->addSelectField("$id.0.multi_media_display", [
            'masonry' => 'Masonry (flexible Höhe)',
            'grid' => 'Grid (quadratische Kacheln)',
            'slideshow' => 'Slideshow (Diashow)'
        ], ['label' => '<i class="fas fa-images"></i> Mehrere Medien als:', 'class' => 'selectpicker', 'default-value' => 'masonry', 'help' => 'Wie sollen mehrere Bilder/Videos dargestellt werden?'])
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
        
        ->addSelectField("2.0.padding", [
            'uk-padding-large' => 'Groß',
            'uk-padding' => 'Mittel',
            'uk-padding-small' => 'Klein',
            '' => 'Kein Padding'
        ], ['label' => '<i class="fas fa-expand"></i> Sektion-Abstand', 'class' => 'selectpicker', 'default-value' => 'uk-padding'])
        
        ->addSelectField("2.0.container", [
            '' => 'Keine Container (volle Breite)',
            'uk-container' => 'Standard Container (1200px max)',
            'uk-container uk-container-large' => 'Large Container (1600px max)'
        ], ['label' => '<i class="fas fa-arrows-alt-h"></i> Container-Breite', 'class' => 'selectpicker'])
        
        ->addSelectField("2.0.gap", [
            'uk-margin-large' => 'Groß (zwischen Blöcken)',
            'uk-margin-medium' => 'Mittel (zwischen Blöcken)',
            'uk-margin' => 'Klein (zwischen Blöcken)',
            '' => 'Minimal (zwischen Blöcken)'
        ], ['label' => '<i class="fas fa-arrows-alt-v"></i> Abstand zwischen Blöcken', 'class' => 'selectpicker', 'default-value' => 'uk-margin-medium'])
    );

echo $main->show();
