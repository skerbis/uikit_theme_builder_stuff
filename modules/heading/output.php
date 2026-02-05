<?php
use UikitThemeBuilder\DomainContext;

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
$titleMargin = $data['title_margin'] ?? 'uk-margin-medium';
$textAlign = $data['text_align'] ?? '';
$backgroundStyle = $data['background_style'] ?? '';
$padding = $data['padding'] ?? '';
$container = $data['container'] ?? '';

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
if ($titleMargin) {
    $headingClasses[] = $titleMargin;
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
