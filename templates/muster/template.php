<?php
/**
 * Standard Template mit Template Manager Integration
 * 
 * DOMAIN_SETTINGS:
 * tm_uikit_theme: uikit_theme_select|UIKit Theme|default|Welches UIKit Theme soll verwendet werden?
 * tm_logo: media|Logo|logo.svg|Logo für Header und Footer
 * tm_logo_text: text|Logo Alt-Text|Meine Firma|Alternativer Text für das Logo
 * tm_logo_white: media|Logo Weiß|logo_white.svg|Weißes Logo für dunkle Hintergründe
 * tm_slogan: text|Slogan||Slogan im Footer
 * tm_firma: text|Firmenname|Meine Firma|Firmenname für Copyright
 * tm_navbar_sticky: checkbox|Navbar Sticky|1|Soll die Navigation beim Scrollen fixiert werden?
 * tm_cta_enabled: checkbox|CTA Button anzeigen|1|Soll der Call-to-Action Button angezeigt werden?
 * tm_breadcrumb_enabled: checkbox|Breadcrumb Navigation|1|Soll die Breadcrumb-Navigation angezeigt werden?
 * tm_cta_text: text|CTA Button Text|Kontakt|Text des CTA Buttons
 * tm_cta_link: text|CTA Button Link|#kontakt|Link-Ziel des CTA Buttons
 * tm_cta_icon: text|CTA Button Icon|mail|UIKit Icon-Name (ohne "icon:" Präfix)
 * tm_mobile_nav_icon: text|Mobile Nav Toggle Icon|plus|UIKit Icon für Mobile Navigation Toggle (plus, chevron-down, triangle-down)
 * tm_footer_section1_title: text|Footer Spalte 1 Titel|Unternehmen|Überschrift erste Footer-Spalte
 * tm_footer_section1_links: linklist|Footer Spalte 1 Links||Artikel-Links für erste Footer-Spalte
 * tm_footer_section2_title: text|Footer Spalte 2 Titel|Service|Überschrift zweite Footer-Spalte  
 * tm_footer_section2_links: linklist|Footer Spalte 2 Links||Artikel-Links für zweite Footer-Spalte
 * tm_footer_section3_title: text|Footer Spalte 3 Titel|Kontakt|Überschrift dritte Footer-Spalte
 * tm_footer_section3_text: textarea|Footer Spalte 3 Text||Kontakt-Informationen
 */

use FriendsOfRedaxo\TemplateManager\TemplateManager;
use UikitThemeBuilder\DomainContext;
use FriendsOfRedaxo\NavigationArray\BuildArray;

setlocale(LC_TIME, 'de_DE.UTF8');
$ctype1 = 'REX_ARTICLE[ctype=1]';

if (array_key_exists('Modal', apache_request_headers()) && apache_request_headers()['Modal'] == "on") {
    echo rex_extension::registerPoint(new rex_extension_point('OUTPUT_FILTER', $ctype1 . '<script>UIkit.scroll().scrollTo("#ajax-dialog");</script>'));
    die();
}

// Navigation-Funktion für Desktop - UIKit Navbar kompatibel
if (!function_exists('buildNavigation')) {
    function buildNavigation($categories, $level = 0)
    {
        $output = [];
        
        foreach ($categories as $cat) {
            $liClass = '';
            $subnavi = '';
            
            // Parent-Klasse für Dropdown-Menüs
            if (!empty($cat['children'])) {
                $liClass = 'uk-parent';
                
                // Dropdown-Menü erstellen
                $subnavi .= '<div class="uk-navbar-dropdown">';
                $subnavi .= '<ul class="uk-nav uk-navbar-dropdown-nav">';
                $subnavi .= buildNavigation($cat['children'], $level + 1);
                $subnavi .= '</ul>';
                $subnavi .= '</div>';
            }
            
            // Aktiver Punkt
            if ($cat['current']) {
                $liClass .= ($liClass ? ' ' : '') . 'uk-active';
            }
            
            // Link erstellen
            $link = '<a href="' . $cat['url'] . '">' . htmlspecialchars($cat['catName']) . '</a>';
            
            // Li-Element zusammenbauen
            $li = '<li' . ($liClass ? ' class="' . $liClass . '"' : '') . '>';
            $li .= $link . $subnavi;
            $li .= '</li>';
            
            $output[] = $li;
        }
        
        return implode("\n", $output);
    }
}

// Funktion zum Generieren von Link-Listen aus komma-getrennten Artikel-IDs
if (!function_exists('generateFooterSection')) {
    function generateFooterSection($linkString) {
        if (empty($linkString)) {
            return '';
        }
        
        $output = '';
        $linkIds = array_map('trim', explode(',', $linkString));
        
        foreach ($linkIds as $linkId) {
            if (empty($linkId) || !is_numeric($linkId)) {
                continue;
            }
            
            $article = rex_article::get($linkId);
            if ($article && $article->isOnline()) {
                $articleName = $article->getValue('name');
                $output .= '<li><a href="' . rex_getUrl($linkId) . '">' . htmlspecialchars($articleName) . '</a></li>';
            }
        }
        
        return $output;
    }
}

// Mobile Navigation-Funktion - UIKit Nav mit separatem Toggle-Button
if (!function_exists('buildMobileNavigation')) {
    function buildMobileNavigation($categories, $level = 0, $toggleIcon = 'plus')
    {
        $output = [];
        
        foreach ($categories as $cat) {
            $liClass = 'level-' . $level;
            $subnavi = '';
            $toggleBtn = '';
            $isOpen = '';
            
            // Parent-Klasse mit Sub-Navigation
            if (!empty($cat['children'])) {
                $liClass .= ' uk-parent';
                
                // Wenn aktiv, uk-open hinzufügen
                if ($cat['current']) {
                    $isOpen = ' uk-open';
                }
                
                // Toggle-Button mit Icon
                $toggleBtn = '<a href="#" tabindex="0" class="nav-toggle-btn"><span uk-icon="icon: ' . htmlspecialchars($toggleIcon) . '; ratio: 1"></span></a>';
                
                // Sub-Navigation erstellen
                $subnavi .= '<ul class="uk-nav-sub">';
                $subnavi .= buildMobileNavigation($cat['children'], $level + 1, $toggleIcon);
                $subnavi .= '</ul>';
            }
            
            // Aktiver Punkt
            if ($cat['current']) {
                $liClass .= ' uk-active';
            }
            
            // Link erstellen - immer mit URL
            $catname = htmlspecialchars($cat['catName']);
            if ($cat['current']) {
                $catname = '<strong>' . $catname . '</strong>';
            }
            $link = '<a href="' . $cat['url'] . '">' . $catname . '</a>';
            
            // Li-Element zusammenbauen: Toggle-Button DANN Link (barrierefreie DOM-Reihenfolge, visuell rechts durch float)
            $li = '<li class="' . $liClass . '"' . $isOpen . '>';
            $li .= $toggleBtn . $link . $subnavi;
            $li .= '</li>';
            
            $output[] = $li;
        }
        
        return implode("\n", $output);
    }
}

// Navigation generieren
$nav_start = rex_yrewrite::getDomainByArticleId(rex_article::getCurrentId(), rex_clang::getCurrentId())->getMountId();

// Navigation Array erstellen
$navData = [];
BuildArray::create()
    ->setStart($nav_start)
    ->setDepth(10)
    ->walk(function($item) use (&$navData) {
        $navData[] = $item;
    });

// Desktop Navigation (bestehendes buildNavigation nutzen)
$navigation = buildNavigation($navData);

// Mobile Navigation mit Toggle-Button (Icon aus Template Manager, default: plus)
$mobileToggleIcon = TemplateManager::get('tm_mobile_nav_icon', 'plus');
$mobileNavigation = buildMobileNavigation($navData, 0, $mobileToggleIcon);

// Template Manager Settings laden
$logoMedia = TemplateManager::get('tm_logo', 'logo.svg');
$logoAltText = TemplateManager::get('tm_logo_text', 'Meine Firma');
$slogan = TemplateManager::get('tm_slogan', '');
$firma = TemplateManager::get('tm_firma', 'Meine Firma');
$navbarSticky = TemplateManager::get('tm_navbar_sticky', '1');

// CTA Button Einstellungen
$ctaEnabled = TemplateManager::get('tm_cta_enabled', '1');
$ctaText = TemplateManager::get('tm_cta_text', 'Kontakt');
$ctaLink = TemplateManager::get('tm_cta_link', '#kontakt');
$ctaIcon = TemplateManager::get('tm_cta_icon', 'mail');

// Breadcrumb Einstellung
$breadcrumbEnabled = TemplateManager::get('tm_breadcrumb_enabled', '1');

// UIKit Theme aus Settings
$uikitTheme = TemplateManager::get('tm_uikit_theme', 'default');

// Navigation Array erstellen
$nav_start = rex_yrewrite::getDomainByArticleId(rex_article::getCurrentId(), rex_clang::getCurrentId())->getMountId();

$navigationArray = BuildArray::create()
    ->setStart($nav_start)
    ->setDepth(2)
    ->setIgnore(true)
    ->generate();

$navigation = buildNavigation($navigationArray);
$mobileNavigation = buildMobileNavigation($navigationArray);

// Footer-Settings aus Template Manager laden
$section1Title = TemplateManager::get('tm_footer_section1_title', 'Unternehmen');
$section1Links = generateFooterSection(TemplateManager::get('tm_footer_section1_links', ''));

$section2Title = TemplateManager::get('tm_footer_section2_title', 'Service');
$section2Links = generateFooterSection(TemplateManager::get('tm_footer_section2_links', ''));

$section3Title = TemplateManager::get('tm_footer_section3_title', 'Kontakt');
$section3Text = TemplateManager::get('tm_footer_section3_content', '');

// Breadcrumb-Funktion mit navigation_array
if (!function_exists('buildBreadcrumb')) {
    function buildBreadcrumb() {
        // Nicht auf Startseite anzeigen
        if (rex_article::getCurrentId() == rex_article::getSiteStartArticleId()) {
            return '';
        }
        
        $navarray = BuildArray::create()->setDepth(10);
        $breadcrumbItems = [];
        
        $navarray->walk(function ($item, $level) use (&$breadcrumbItems) {
            if ($item['active']) {
                // Aktueller Artikel wird als aktiv markiert aber nicht verlinkt
                if (rex_article::getCurrentId() == $item['catId']) {
                    $breadcrumbItems[] = '<li class="uk-disabled"><span>' . htmlspecialchars($item['catName']) . '</span></li>';
                } else {
                    $breadcrumbItems[] = '<li><a href="' . $item['url'] . '">' . htmlspecialchars($item['catName']) . '</a></li>';
                }
            }
        });
        
        if (empty($breadcrumbItems)) {
            return '';
        }
        
        $output = '<nav aria-label="Breadcrumb" class="uk-margin-medium-bottom">';
        $output .= '<ul class="uk-breadcrumb">';
        $output .= '<li><a href="/" title="Startseite"><span uk-icon="home"></span></a></li>';
        $output .= implode("\n", $breadcrumbItems);
        $output .= '</ul>';
        $output .= '</nav>';
        
        return $output;
    }
}
?>
<!DOCTYPE html>
<html lang="<?= rex_clang::getCurrent()->getCode() ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php
        $seo = new rex_yrewrite_seo();
        echo $seo->getTags();
    ?>
    
    <!-- UIKit Theme Builder - CSS und Fonts -->
    <?php 
    // Theme aus DomainContext oder Template Manager
    $themeContext = DomainContext::getContext();
    $themeName = $themeContext['theme'] ?? $uikitTheme;
    echo UikitThemeBuilder\TemplateHelper::includeAllStyles($themeContext['theme']);
    ?>
    
    <!-- Vidstack Video Player -->
    <?php
        echo '<link rel="stylesheet" href="' . rex_url::addonAssets('vidstack', 'vidstack.css') . '">';
        echo '<link rel="stylesheet" href="' . rex_url::addonAssets('vidstack', 'vidstack_helper.css') . '">';
    ?>
    
    <!-- Accessibility -->
    <?php echo \FriendsOfRedaxo\Sa11y\Sa11y::get()?>
    
    <style>
        /* Focus visible for better keyboard navigation */
        *:focus-visible {
            outline: 2px solid var(--global-primary-background, #1e87f0);
            outline-offset: 2px;
        }
    </style>

   </head>
<body>

<!-- Skip to main content link for keyboard users -->
<a href="#main-content" class="uk-position-top-left uk-position-fixed uk-position-z-index uk-transition-slide-top-small" style="transform: translateY(-100%);" onfocus="this.style.transform='translateY(0)'" onblur="this.style.transform='translateY(-100%)'" tabindex="0">
    <span class="uk-button uk-button-primary">Zum Hauptinhalt springen</span>
</a>

<!-- Header mit Navigation -->
<header role="banner">
    <!-- Navbar mit optionalem Sticky -->
    <?php if ($navbarSticky == '1'): ?>
    <div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
    <?php endif; ?>
        <nav class="uk-navbar-container" uk-navbar aria-label="Hauptnavigation">
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo uk-padding-remove-right uk-margin-left" href="/" aria-label="Zur Startseite">
                    <img src="<?= rex_url::media($logoMedia) ?>" 
                         alt="<?= htmlspecialchars($logoAltText) ?>" 
                         class="uk-responsive-height" 
                         height="40" />
                </a>
            </div>
            
            <!-- Desktop Navigation Center -->
            <div class="uk-navbar-center uk-visible@m">
                <ul class="uk-navbar-nav">
                    <?= $navigation ?>
                </ul>
            </div>

            <div class="uk-navbar-right">
                <!-- Desktop CTA Button -->
                <?php if ($ctaEnabled == '1'): ?>
                <div class="uk-navbar-item uk-visible@m">
                    <a href="<?= htmlspecialchars($ctaLink) ?>" class="uk-button uk-button-primary uk-button-small">
                        <?php if (!empty($ctaIcon)): ?>
                        <span uk-icon="<?= htmlspecialchars($ctaIcon) ?>" aria-hidden="true"></span>
                        <?php endif; ?>
                        <?= htmlspecialchars($ctaText) ?>
                    </a>
                </div>
                <?php endif; ?>
                
                <!-- Mobile Menu Toggle -->
                <a class="uk-navbar-toggle uk-hidden@m uk-margin-right" 
                   uk-toggle="target: #mobile-nav"
                   uk-navbar-toggle-icon
                   aria-label="Mobile Navigation öffnen"
                   aria-expanded="false"
                   aria-controls="mobile-nav">
                </a>
            </div>
        </nav>
    <?php if ($navbarSticky == '1'): ?>
    </div>
    <?php endif; ?>
</header>

<!-- Mobile Navigation Offcanvas -->
<div id="mobile-nav" 
     uk-offcanvas="mode: slide; overlay: true; flip: true;"
     aria-labelledby="mobile-nav-title">
    <div class="uk-offcanvas-bar" role="dialog" aria-modal="true">
        
        <!-- Close Button -->
        <button class="uk-offcanvas-close" 
                type="button" 
                uk-close
                aria-label="Mobile Navigation schließen"></button>
        
        <!-- Mobile Logo -->
        <div class="uk-text-center uk-margin-medium-top">
            <img src="<?= rex_url::media($logoMedia) ?>" 
                 alt="<?= htmlspecialchars($logoAltText) ?>" 
                 class="uk-responsive-height"
                 height="50" />
        </div>
        
        <!-- Mobile Navigation Menu -->
        <nav aria-label="Mobile Navigation">
            <h2 id="mobile-nav-title" class="uk-hidden-visually">Mobile Navigation</h2>
            <ul class="uk-nav-default" data-uk-nav="toggle:>.nav-toggle-btn">
                <?= $mobileNavigation ?>
            </ul>
        </nav>
        
        <!-- Mobile CTA Button -->
        <?php if ($ctaEnabled == '1'): ?>
        <div class="uk-margin-large-top uk-text-center">
            <a href="<?= htmlspecialchars($ctaLink) ?>" class="uk-button uk-button-primary uk-width-1-1">
                <?php if (!empty($ctaIcon)): ?>
                <span uk-icon="<?= htmlspecialchars($ctaIcon) ?>" aria-hidden="true"></span>
                <?php endif; ?>
                <?= htmlspecialchars($ctaText) ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Main Content -->
<main id="main-content" role="main" tabindex="-1">
    <article>
        <?php if ($breadcrumbEnabled == '1'): ?>
        <div class="uk-container uk-container-large uk-margin-top">
            <?= buildBreadcrumb() ?>
        </div>
        <?php endif; ?>
        
        <div class="uk-section uk-margin-remove uk-padding-remove" uk-height-viewport="expand: true">
            <?php echo $ctype1?>
        </div>
    </article>
</main>

<footer class="uk-footer uk-section uk-margin-large-top" role="contentinfo">
    <div class="uk-container uk-container-large">
        <nav class="uk-grid-medium uk-child-width-1-3@m uk-grid" uk-grid="" aria-label="Footer Navigation">
            
            <?php if (!empty($section1Title) || !empty($section1Links)): ?>
            <section class="uk-first-column">
                <?php if (!empty($section1Title)): ?>
                    <h2 class="uk-h4"><?= htmlspecialchars($section1Title) ?></h2>
                <?php endif; ?>
                
                <?php if (!empty($section1Links)): ?>
                    <ul class="uk-list">
                        <?= $section1Links ?>
                    </ul>
                <?php endif; ?>
            </section>
            <?php endif; ?>
            
            <?php if (!empty($section2Title) || !empty($section2Links)): ?>
            <section>
                <?php if (!empty($section2Title)): ?>
                    <h2 class="uk-h4"><?= htmlspecialchars($section2Title) ?></h2>
                <?php endif; ?>
                
                <?php if (!empty($section2Links)): ?>
                    <ul class="uk-list">
                        <?= $section2Links ?>
                    </ul>
                <?php endif; ?>
            </section>
            <?php endif; ?>
            
            <?php if (!empty($section3Title) || !empty($section3Text)): ?>
            <section>
                <?php if (!empty($section3Title)): ?>
                    <h2 class="uk-h4"><?= htmlspecialchars($section3Title) ?></h2>
                <?php endif; ?>
                
                <?php if (!empty($section3Text)): ?>
                    <address class="uk-text-small uk-not-italic">
                        <?= $section3Text ?>
                    </address>
                <?php endif; ?>
            </section>
            <?php endif; ?>
            
        </nav>
        
        <hr class="uk-margin-medium">
        
        <div class="uk-text-center">
            <?php if (!empty($slogan)): ?>
                <p class="uk-margin-small">
                    <?= htmlspecialchars($slogan) ?>
                </p>
            <?php endif; ?>
            
            <!-- Footer Logo (wiederverwendet aus Header) -->
            <div class="uk-margin-medium">
                <img src="<?= rex_url::media($logoMedia) ?>" 
                     alt="<?= htmlspecialchars($logoAltText) ?>" 
                     class="uk-responsive-height uk-opacity-medium"
                     height="60" />
            </div>
            
            <p class="uk-text-small uk-text-muted">
                © <?= date('Y') ?> <?= htmlspecialchars($firma) ?> - Alle Rechte vorbehalten
            </p>
        </div>
        
    </div>
</footer>

<!-- UIKit Theme Builder - JavaScript -->
<?= UikitThemeBuilder\TemplateHelper::includeAllJS() ?>

</body>
</html>
