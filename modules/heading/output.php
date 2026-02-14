<?php
use UikitThemeBuilder\DomainContext;
use UikitThemeBuilder\ThemeHelper;

// Hole Daten als Array (MForm speichert als Array)
$dataArray = rex_var::toArray("REX_VALUE[1]");
$data = $dataArray[0] ?? [];

if (empty($data) || !is_array($data)) {
    return;
}

// Hole Werte aus dem Array
$headingText = $data['heading_text'] ?? '';
$subtitle = $data['subtitle'] ?? '';
$headingLevel = $data['heading_level'] ?? 'h2';
$headingStyle = $data['heading_style'] ?? 'uk-heading-medium';
$subtitleStyle = $data['subtitle_style'] ?? 'uk-text-lead';
$titleMargin = $data['title_margin'] ?? 'uk-margin-medium-bottom';
// Migration: alte allgemeine Margins auf richtungsspezifische Bottom-Margins umschreiben
$marginMap = [
    'uk-margin-medium' => 'uk-margin-medium-bottom',
    'uk-margin-large' => 'uk-margin-large-bottom',
    'uk-margin' => 'uk-margin-bottom',
    'uk-margin-small' => 'uk-margin-small-bottom',
];
if (isset($marginMap[$titleMargin])) {
    $titleMargin = $marginMap[$titleMargin];
}
$textAlign = $data['text_align'] ?? '';
$backgroundStyle = $data['background_style'] ?? '';
$padding = $data['padding'] ?? '';
$container = $data['container'] ?? '';

// Textfarbe basierend auf Hintergrund
$textColorClass = ThemeHelper::getTextColorForBackground($backgroundStyle);

// Wenn kein Text, dann nichts ausgeben
if (empty(trim($headingText))) {
    return;
}

// Setze Property wenn H1 verwendet wird
if ($headingLevel === 'h1') {
    rex::setProperty('h1_used', true);
}

// Section und Container
$sectionClasses = [];
if ($backgroundStyle) {
    $sectionClasses[] = $backgroundStyle;
}
if ($padding) {
    $sectionClasses[] = $padding;
}
if ($textColorClass) {
    $sectionClasses[] = $textColorClass;
}
if ($titleMargin) {
    $sectionClasses[] = $titleMargin;
}

$sectionClassStr = !empty($sectionClasses) ? ' class="' . implode(' ', $sectionClasses) . '"' : '';
$containerClassStr = $container ? ' class="' . $container . '"' : '';

// Heading Klassen
$headingClasses = [];
if ($headingStyle) {
    $headingClasses[] = $headingStyle;
}
if ($textAlign) {
    $headingClasses[] = $textAlign;
}

$headingClassStr = !empty($headingClasses) ? ' class="' . implode(' ', $headingClasses) . '"' : '';

// Subtitle Klassen
$subtitleClasses = [];
if ($subtitleStyle) {
    $subtitleClasses[] = $subtitleStyle;
}
if ($textAlign) {
    $subtitleClasses[] = $textAlign;
}

$subtitleClassStr = !empty($subtitleClasses) ? ' class="' . implode(' ', $subtitleClasses) . '"' : '';

?>
<section<?= $sectionClassStr ?>>
    <?php if ($container): ?>
    <div<?= $containerClassStr ?>>
    <?php endif; ?>
        
        <<?= $headingLevel ?><?= $headingClassStr ?>><?= nl2br(htmlspecialchars($headingText)) ?></<?= $headingLevel ?>>
        
        <?php if ($subtitle): ?>
        <div<?= $subtitleClassStr ?>><?= nl2br(htmlspecialchars($subtitle)) ?></div>
        <?php endif; ?>
    
    <?php if ($container): ?>
    </div>
    <?php endif; ?>
</section>
