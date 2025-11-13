<?php
use FriendsOfRedaxo\VidStack\Video;

$rexInputVars = rex_var::toArray("REX_VALUE[1]");
$rexSettingVarsArray = rex_var::toArray("REX_VALUE[2]");
$rexSettingVars = !empty($rexSettingVarsArray) ? $rexSettingVarsArray[0] : [];
$rexColorVarsArray = rex_var::toArray("REX_VALUE[3]");
$rexColorVars = !empty($rexColorVarsArray) ? $rexColorVarsArray[0] : [];
$container_width_array = rex_var::toArray("REX_VALUE[9]");
$container_width = !empty($container_width_array) ? $container_width_array[0] : ['container' => 'uk-container'];
$style_array = rex_var::toArray("REX_VALUE[6]");
$style = !empty($style_array) ? $style_array[0] : ['style' => ''];

$bgimage ='';
if ('REX_MEDIA[1]'!='') {
    $bgimage = 'style="background-image: url(/media/REX_MEDIA[1])" ';
}
?>
<section <?php if (isset($bgimage)) echo $bgimage; ?> data-uk-parallax="bgy: -200" class="REX_VALUE[15]uk-section uk-background-cover uk-preserve-color uk-background-<?php echo $rexColorVars['ukcolor'] ?? ''?> REX_VALUE[14]">
<?php echo '<div class="'.$container_width['container'].' ">'; ?>

<?php
$ukGutterWidth = 'data-uk-grid-' . ($rexSettingVars['gutterWidth'] ?? 'medium');
$ukMatchHeight = isset($rexSettingVars['matchHeight']) ? ' uk-grid-match' : '';

$output = array();
$output[] = '<div uk-height-match=".uk-card-wrapper" data-uk-scrollspy="target: > div; cls:uk-animation-fade; delay: 500" class="' . $ukGutterWidth . $ukMatchHeight . ' uk-child-width-expand@m uk-flex-center" data-uk-grid>';
    
foreach ($rexInputVars as $rexVar) {
    $linkpre = $linksuf = ''; 

    // Debug (nur im Backend)
    if (rex::isBackend()) {
        // dump($rexVar); // Zum Debuggen aktivieren
    }

    // Layout
    $layout = $rexVar['layout'] ?? 'media-top';

    // Card-Farbe - Wert kommt bereits mit uk-card- Präfix
    $ukColor = $rexVar['ukColor'] ?? 'uk-card-default';
    
    // Breite
    if(isset($rexVar['ukWidth']) && $rexVar['ukWidth']=='1-1@m') {                 
        $ukWidth = 'uk-width-' . $rexVar['ukWidth'];
    } elseif (isset($rexVar['ukWidth'])) {
        $ukWidth = 'uk-width-1-2@s uk-width-' . $rexVar['ukWidth']; 
    } else {
        $ukWidth = 'uk-width-1-2@s uk-width-auto@m';
    }
    
    $uklinkdiv = isset($rexVar['linkdiv']) ? ' '.$rexVar['linkdiv'] : '';
    $imgpadding = $rexVar['imgpadding'] ?? '';
    $cardShadow = $rexVar['cardShadow'] ?? '';
    
    $header = $rexVar['header'] ?? '';
    $image_title = $rexVar['imageTitle'] ?? '';
    $content = $rexVar['content'] ?? ''; 
    $image = $rexVar['REX_MEDIA_1'] ?? '';
    $imageAlt = $rexVar['imageAlt'] ?? '';
    
    $managertype_effect = '';    
    $media_type = rex_media::get($image);
    if ($media_type && $media_type->getType() != 'image/svg+xml') {
        $managertype_effect = 'card/';
    }
    
    $link = $rexVar[1] ?? '';
    $LinkText = !empty($rexVar['LinkText']) ? $rexVar['LinkText'] : 'Weitere Informationen';
        
    if ($link!='') { 
        if (is_numeric($link)) {
            $link = rex_getUrl($link);
        }
    
        if ($rexVar['linkdiv'] ?? false) {
            $linkpre = '<a class="linkdiv uk-link-reset" href="'.$link.'" title="Alle Infos anzeigen">';
            $linksuf = '</a>';
        }
    }

    // Card start
    $output[] = '<div class="' . $ukWidth . '">';
    $output[] = $linkpre .'<div class="uk-card uk-preserve-color '.$style['style'].' ' . $ukColor . $uklinkdiv . $cardShadow .'">';
    
    // Card-wrapper mit Grid für links/rechts Layout
    if ($layout == 'media-left' || $layout == 'media-right') {
        $output[] = '<div class="uk-card-wrapper uk-grid-small uk-child-width-expand" uk-grid>';
    } else {
        $output[] = '<div class="uk-card-wrapper">';
    }
    
    // Render basierend auf Layout
    if ($layout == 'media-top') {
        // Medium oben
        if ($image!='') {  
            if(Video::isMedia($image)) {   
                $video = new Video($image, $image_title);
                $video->setPoster('/index.php?rex_media_type=videop&rex_media_file=' . $image, $image_title);
                $video->setAttributes(['playsinline' => true, 'class' => 'uk-width-1-1']);
                
                $output[] = '<div class="uk-card-media-top'.$imgpadding.'">';
                $output[] = $video->generate();
                $output[] = '</div>';
            } else {
                $output[] = '<div class="uk-card-media-top'.$imgpadding.'"><img loading="lazy" src="/media/'.$managertype_effect . $image . '" title="' . htmlspecialchars($image_title) . '" alt="' . htmlspecialchars($imageAlt) . '" class="uk-width-1-1"></div>';
            }    
        }
        
        // Header
        if ($header!='') {
            $output[] = '<div class="uk-card-header uk-padding-small">';
            $output[] = '<h3 class="uk-card-title">' . htmlspecialchars($header) . '</h3>';
            $output[] = '</div>';
        }
        
        // Content
        if ($content) {
            $output[] = '<div class="uk-card-body uk-padding-small">';    
            $output[] = $content;
            $output[] = '</div>';
        }
        
    } elseif ($layout == 'media-bottom') {
        // Header
        if ($header!='') {
            $output[] = '<div class="uk-card-header uk-padding-small">';
            $output[] = '<h3 class="uk-card-title">' . htmlspecialchars($header) . '</h3>';
            $output[] = '</div>';
        }
        
        // Content
        if ($content) {
            $output[] = '<div class="uk-card-body uk-padding-small">';    
            $output[] = $content;
            $output[] = '</div>';
        }
        
        // Medium unten
        if ($image!='') {  
            if(Video::isMedia($image)) {   
                $video = new Video($image, $image_title);
                $video->setPoster('/index.php?rex_media_type=videop&rex_media_file=' . $image, $image_title);
                $video->setAttributes(['playsinline' => true, 'class' => 'uk-width-1-1']);
                
                $output[] = '<div class="uk-card-media-bottom'.$imgpadding.'">';
                $output[] = $video->generate();
                $output[] = '</div>';
            } else {
                $output[] = '<div class="uk-card-media-bottom'.$imgpadding.'"><img loading="lazy" src="/media/'.$managertype_effect . $image . '" title="' . htmlspecialchars($image_title) . '" alt="' . htmlspecialchars($imageAlt) . '" class="uk-width-1-1"></div>';
            }    
        }
        
    } elseif ($layout == 'media-left' || $layout == 'media-right') {
        // Grid-Layout für links/rechts
        $mediaWidth = $rexVar['mediaWidth'] ?? '1-3@m';
        
        // Medium links
        if ($layout == 'media-left' && $image!='') {
            $output[] = '<div class="uk-card-media-left uk-width-' . $mediaWidth . '">';
            if(Video::isMedia($image)) {   
                $video = new Video($image, $image_title);
                $video->setPoster('/index.php?rex_media_type=videop&rex_media_file=' . $image, $image_title);
                $video->setAttributes(['playsinline' => true, 'class' => 'uk-width-1-1']);
                $output[] = $video->generate();
            } else {
                $output[] = '<img loading="lazy" src="/media/'.$managertype_effect . $image . '" title="' . htmlspecialchars($image_title) . '" alt="' . htmlspecialchars($imageAlt) . '" class="uk-width-1-1">';
            }
            $output[] = '</div>';
        }
        
        // Content - expandiert automatisch
        $output[] = '<div class="uk-width-expand">';
        if ($header!='') {
            $output[] = '<div class="uk-card-header uk-padding-small">';
            $output[] = '<h3 class="uk-card-title">' . htmlspecialchars($header) . '</h3>';
            $output[] = '</div>';
        }
        if ($content) {
            $output[] = '<div class="uk-card-body uk-padding-small">';    
            $output[] = $content;
            $output[] = '</div>';
        }
        $output[] = '</div>';
        
        // Medium rechts
        if ($layout == 'media-right' && $image!='') {
            $output[] = '<div class="uk-card-media-right uk-width-' . $mediaWidth . '">';
            if(Video::isMedia($image)) {   
                $video = new Video($image, $image_title);
                $video->setPoster('/index.php?rex_media_type=videop&rex_media_file=' . $image, $image_title);
                $video->setAttributes(['playsinline' => true, 'class' => 'uk-width-1-1']);
                $output[] = $video->generate();
            } else {
                $output[] = '<img loading="lazy" src="/media/'.$managertype_effect . $image . '" title="' . htmlspecialchars($image_title) . '" alt="' . htmlspecialchars($imageAlt) . '" class="uk-width-1-1">';
            }
            $output[] = '</div>';
        }
    }
    
    $output[] = '</div>'; // close card-wrapper
    
    // Footer mit Link
    if($link) {    
        $ariaLabel = '';
        if ($header && $LinkText == 'Weitere Informationen') {
            $ariaLabel = ' aria-label="Weitere Informationen zu ' . htmlspecialchars($header) . '"';
        }
        $output[] = '<div class="uk-card-footer">';
        $output[] = '<a' . $ariaLabel . ' class="uk-preserve-color uk-button uk-button-text" href="' . $link . '">' . htmlspecialchars($LinkText) . ' <i data-uk-icon="icon: chevron-right; ratio: 1"></i></a>';
        $output[] = '</div>';
    }    
   
    $output[] = '</div>'; // close card
    $output[] = '</div>'; // close width
    $output[] = $linksuf; 
}

$output[] = '</div>';

echo join("\n", $output);
?>
<?php echo '</div>'; ?>
</section>
