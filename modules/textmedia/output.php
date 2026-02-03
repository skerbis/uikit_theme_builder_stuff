<?php
/**
 * Text & Medien - Output Template mit MBlock
 * Flexibles Layout für Text und Medien-Kombinationen
 */

use UikitThemeBuilder\ThemeHelper;

// MBlock Daten abrufen
$textMediaBlocks = rex_var::toArray("REX_VALUE[1]");

// Globale Einstellungen
$globalSettings = rex_var::toArray("REX_VALUE[2]");
$settings = $globalSettings[0] ?? [];
$backgroundStyle = $settings['background_style'] ?? '';
$padding = $settings['padding'] ?? 'uk-padding';
$container = $settings['container'] ?? '';
$gap = $settings['gap'] ?? 'uk-margin-medium';

$textColorClass = ThemeHelper::getTextColorForBackground($backgroundStyle);

// Nur ausgeben wenn Blöcke vorhanden
if (!empty($textMediaBlocks) && is_array($textMediaBlocks)):

// Backend Wrapper
echo ThemeHelper::backendWrapper(true);
?>

<div class="<?= !empty($backgroundStyle) ? $backgroundStyle : '' ?> <?= !empty($padding) ? $padding : '' ?> uk-margin-medium">
    <?php if (!empty($container)): ?>
    <div class="<?= $container ?>">
    <?php endif; ?>
        
        <?php foreach ($textMediaBlocks as $index => $block): 
            if (empty($block['content']) && empty($block['REX_MEDIALIST_1'])) continue; // Skip leere Blöcke
            
            // Block-Einstellungen
            $title = $block['title'] ?? '';
            $subtitle = $block['subtitle'] ?? '';
            $titleHandwriting = isset($block['title_handwriting']) && $block['title_handwriting'] === '1';
            $titleSlanted = isset($block['title_slanted']) && $block['title_slanted'] === '1';
            $subtitleHandwriting = isset($block['subtitle_handwriting']) && $block['subtitle_handwriting'] === '1';
            $subtitleSlanted = isset($block['subtitle_slanted']) && $block['subtitle_slanted'] === '1';
            $content = $block['content'] ?? '';
            $mediaList = $block['REX_MEDIALIST_1'] ?? '';
            $mediaCaption = $block['media_caption'] ?? '';
            $badgeText = $block['badge_text'] ?? '';
            $layout = $block['layout'] ?? 'text-left-media-right';
            $textWidth = $block['text_width'] ?? 'uk-width-1-2@m';
            $mediaCenter = isset($block['media_center']) && $block['media_center'] === '1';
            $multiMediaDisplay = $block['multi_media_display'] ?? 'masonry';
            $headingLevel = $block['heading_level'] ?? 'h3';
            $headingStyle = $block['heading_style'] ?? 'uk-heading-medium';
            $subtitleStyle = $block['subtitle_style'] ?? 'uk-text-lead uk-text-large';
            $titleMargin = $block['title_margin'] ?? 'uk-margin-medium';
            $textAlign = $block['text_align'] ?? '';
            $enableLightbox = isset($block['enable_lightbox']) && $block['enable_lightbox'] === '1';
            
            // Slideshow Options
            $slideshowOptions = [
                'autoplay' => isset($block['slideshow_autoplay']) && $block['slideshow_autoplay'] === '1',
                'animation' => $block['slideshow_animation'] ?? 'slide',
                'ratio' => $block['slideshow_ratio'] ?? ''
            ];
            
            // Media-Width berechnen
            $mediaWidthMap = [
                'uk-width-1-2@m' => 'uk-width-1-2@m',
                'uk-width-2-3@m' => 'uk-width-1-3@m',
                'uk-width-1-3@m' => 'uk-width-2-3@m',
                'uk-width-3-4@m' => 'uk-width-1-4@m',
                'uk-width-1-4@m' => 'uk-width-3-4@m'
            ];
            $mediaWidth = $mediaWidthMap[$textWidth] ?? 'uk-width-1-2@m';
            
            // Block-Container mit Abstand
            $blockClass = $index > 0 ? $gap : '';
            ?>
            
            <div class="<?= $blockClass ?>">
                <?php if ($layout === 'text-only'): ?>
                    <!-- Nur Text Layout -->
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="<?= $titleMargin ?> <?= $textAlign ?>">
                            <?php if (!empty($title)): ?>
                                <?php 
                                $titleClasses = [];
                                if (!empty($headingStyle)) $titleClasses[] = $headingStyle;
                                if ($titleHandwriting) $titleClasses[] = 'uk-text-handwriting';
                                if ($titleSlanted) $titleClasses[] = 'uk-text-slanted';
                                $titleClasses[] = $textColorClass;
                                
                                $titleClassString = !empty($titleClasses) ? ' class="' . implode(' ', $titleClasses) . '"' : '';
                                ?>
                                <<?= $headingLevel ?><?= $titleClassString ?>><?= htmlspecialchars($title) ?></<?= $headingLevel ?>>
                            <?php endif; ?>
                            
                            <?php if (!empty($subtitle)): ?>
                                <?php 
                                $subtitleClasses = [];
                                if (!empty($subtitleStyle)) $subtitleClasses[] = $subtitleStyle;
                                if ($subtitleHandwriting) $subtitleClasses[] = 'uk-text-handwriting';
                                if ($subtitleSlanted) $subtitleClasses[] = 'uk-text-slanted';
                                $subtitleClasses[] = $textColorClass === 'uk-light' ? 'uk-light' : 'uk-text-muted';
                                
                                $subtitleClassString = !empty($subtitleClasses) ? ' class="' . implode(' ', $subtitleClasses) . '"' : '';
                                ?>
                                <p<?= $subtitleClassString ?> style="margin-top: -0.5rem !important;">
                                    <?= htmlspecialchars($subtitle) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($content)): ?>
                        <div class="uk-text-default <?= $textColorClass ?>">
                            <?= $content ?>
                        </div>
                    <?php endif; ?>
                    
                <?php elseif ($layout === 'media-only'): ?>
                    <!-- Nur Medien Layout -->
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="<?= $titleMargin ?> <?= !empty($textAlign) ? $textAlign : 'uk-text-center' ?>">
                            <?php if (!empty($title)): ?>
                                <?php 
                                $titleClasses = [];
                                if (!empty($headingStyle)) $titleClasses[] = $headingStyle;
                                if ($titleHandwriting) $titleClasses[] = 'uk-text-handwriting';
                                if ($titleSlanted) $titleClasses[] = 'uk-text-slanted';
                                $titleClasses[] = $textColorClass;
                                
                                $titleClassString = !empty($titleClasses) ? ' class="' . implode(' ', $titleClasses) . '"' : '';
                                ?>
                                <<?= $headingLevel ?><?= $titleClassString ?>><?= htmlspecialchars($title) ?></<?= $headingLevel ?>>
                            <?php endif; ?>
                            
                            <?php if (!empty($subtitle)): ?>
                                <?php 
                                $subtitleClasses = [];
                                if (!empty($subtitleStyle)) $subtitleClasses[] = $subtitleStyle;
                                if ($subtitleHandwriting) $subtitleClasses[] = 'uk-text-handwriting';
                                if ($subtitleSlanted) $subtitleClasses[] = 'uk-text-slanted';
                                $subtitleClasses[] = $textColorClass === 'uk-light' ? 'uk-light' : 'uk-text-muted';
                                
                                $subtitleClassString = !empty($subtitleClasses) ? ' class="' . implode(' ', $subtitleClasses) . '"' : '';
                                ?>
                                <p<?= $subtitleClassString ?> style="margin-top: -0.5rem !important;">
                                    <?= htmlspecialchars($subtitle) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($mediaList)): ?>
                        <?= ThemeHelper::renderMediaContent($mediaList, $multiMediaDisplay, $mediaCaption, $badgeText, $enableLightbox, $textColorClass, $layout, $slideshowOptions) ?>
                    <?php endif; ?>
                    
                <?php elseif ($layout === 'text-top-media-bottom'): ?>
                    <!-- Text oben, Medien unten -->
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="<?= $titleMargin ?> <?= $textAlign ?>">
                            <?php if (!empty($title)): ?>
                                <<?= $headingLevel ?> class="<?= $headingStyle ?> <?= $titleHandwriting ? 'uk-text-handwriting' : '' ?> <?= $titleSlanted ? 'uk-text-slanted' : '' ?> <?= $textColorClass ?>"><?= htmlspecialchars($title) ?></<?= $headingLevel ?>>
                            <?php endif; ?>
                            
                            <?php if (!empty($subtitle)): ?>
                                <p class="<?= $subtitleStyle ?> <?= $subtitleHandwriting ? 'uk-text-handwriting' : '' ?> <?= $subtitleSlanted ? 'uk-text-slanted' : '' ?> <?= $textColorClass === 'uk-light' ? 'uk-light' : 'uk-text-muted' ?>" style="margin-top: -0.5rem !important;">
                                    <?= htmlspecialchars($subtitle) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($content)): ?>
                        <div class="uk-text-default <?= $textColorClass ?> uk-margin-medium-bottom">
                            <?= $content ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($mediaList)): ?>
                        <?= ThemeHelper::renderMediaContent($mediaList, $multiMediaDisplay, $mediaCaption, $badgeText, $enableLightbox, $textColorClass, $layout, $slideshowOptions) ?>
                    <?php endif; ?>

                <?php elseif ($layout === 'text-bottom-media-top'): ?>
                    <!-- Medien oben, Text unten -->
                    <?php if (!empty($mediaList)): ?>
                        <div class="uk-margin-medium-bottom">
                            <?= ThemeHelper::renderMediaContent($mediaList, $multiMediaDisplay, $mediaCaption, $badgeText, $enableLightbox, $textColorClass, $layout, $slideshowOptions) ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="<?= $titleMargin ?> <?= $textAlign ?>">
                            <?php if (!empty($title)): ?>
                                <<?= $headingLevel ?> class="<?= $headingStyle ?> <?= $titleHandwriting ? 'uk-text-handwriting' : '' ?> <?= $titleSlanted ? 'uk-text-slanted' : '' ?> <?= $textColorClass ?>"><?= htmlspecialchars($title) ?></<?= $headingLevel ?>>
                            <?php endif; ?>
                            
                            <?php if (!empty($subtitle)): ?>
                                <p class="<?= $subtitleStyle ?> <?= $subtitleHandwriting ? 'uk-text-handwriting' : '' ?> <?= $subtitleSlanted ? 'uk-text-slanted' : '' ?> <?= $textColorClass === 'uk-light' ? 'uk-light' : 'uk-text-muted' ?>" style="margin-top: -0.5rem !important;">
                                    <?= htmlspecialchars($subtitle) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($content)): ?>
                        <div class="uk-text-default <?= $textColorClass ?>">
                            <?= $content ?>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- Text + Medien Layout -->
                    <?php if (!empty($title) || !empty($subtitle)): ?>
                        <div class="<?= $titleMargin ?> <?= $textAlign ?>">
                            <?php if (!empty($title)): ?>
                                <?php 
                                $titleClasses = [];
                                if (!empty($headingStyle)) $titleClasses[] = $headingStyle;
                                if ($titleHandwriting) $titleClasses[] = 'uk-text-handwriting';
                                if ($titleSlanted) $titleClasses[] = 'uk-text-slanted';
                                $titleClasses[] = $textColorClass;
                                
                                $titleClassString = !empty($titleClasses) ? ' class="' . implode(' ', $titleClasses) . '"' : '';
                                ?>
                                <<?= $headingLevel ?><?= $titleClassString ?>><?= htmlspecialchars($title) ?></<?= $headingLevel ?>>
                            <?php endif; ?>
                            
                            <?php if (!empty($subtitle)): ?>
                                <?php 
                                $subtitleClasses = [];
                                if (!empty($subtitleStyle)) $subtitleClasses[] = $subtitleStyle;
                                if ($subtitleHandwriting) $subtitleClasses[] = 'uk-text-handwriting';
                                if ($subtitleSlanted) $subtitleClasses[] = 'uk-text-slanted';
                                $subtitleClasses[] = $textColorClass === 'uk-light' ? 'uk-light' : 'uk-text-muted';
                                
                                $subtitleClassString = !empty($subtitleClasses) ? ' class="' . implode(' ', $subtitleClasses) . '"' : '';
                                ?>
                                <p<?= $subtitleClassString ?> style="margin-top: -0.5rem !important;">
                                    <?= htmlspecialchars($subtitle) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="uk-grid-medium <?= $mediaCenter ? 'uk-flex-middle' : '' ?>" uk-grid>
                        <?php if ($layout === 'text-left-media-right'): ?>
                            <!-- Text links, Medien rechts -->
                            <?php if (!empty($content)): ?>
                                <div class="<?= $textWidth ?>">
                                    <div class="uk-text-default <?= $textColorClass ?>">
                                        <?= $content ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($mediaList)): ?>
                                <div class="<?= $mediaWidth ?>">
                                    <?= ThemeHelper::renderMediaContent($mediaList, $multiMediaDisplay, $mediaCaption, $badgeText, $enableLightbox, $textColorClass, $layout, $slideshowOptions) ?>
                                </div>
                            <?php endif; ?>
                            
                        <?php else: ?>
                            <!-- Medien links, Text rechts -->
                            <?php if (!empty($mediaList)): ?>
                                <div class="<?= $mediaWidth ?>">
                                    <?= ThemeHelper::renderMediaContent($mediaList, $multiMediaDisplay, $mediaCaption, $badgeText, $enableLightbox, $textColorClass, $layout, $slideshowOptions) ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($content)): ?>
                                <div class="<?= $textWidth ?>">
                                    <div class="uk-text-default <?= $textColorClass ?>">
                                        <?= $content ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            
        <?php endforeach; ?>
        
    <?php if (!empty($container)): ?>
    </div>
    <?php endif; ?>
</div>

<?php 
// Backend Wrapper schließen
echo ThemeHelper::backendWrapper(false);

endif; // Ende: if (!empty($textMediaBlocks))