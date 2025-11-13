<?php
/**
 * YForm Content Builder - Vereinfachte Moduleingabe (ohne AJAX)
 * 
 * Diese Version funktioniert ohne AJAX und kann für Tests verwendet werden.
 */

// Error Reporting aktivieren für Debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Prüfe ob die Klasse existiert
    if (!class_exists('KLXM\\YformContentBuilder\\ModuleHelper')) {
        echo '<div class="alert alert-danger">ModuleHelper Klasse nicht gefunden! Bitte prüfe die boot.php.</div>';
        return;
    }
    
    // Content Builder Formular ausgeben
    echo KLXM\YformContentBuilder\ModuleHelper::form('REX_VALUE[1]');
    
} catch (Exception $e) {
    echo '<div class="alert alert-danger">';
    echo '<strong>Fehler:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>';
    echo '<strong>Datei:</strong> ' . htmlspecialchars($e->getFile()) . '<br>';
    echo '<strong>Zeile:</strong> ' . $e->getLine() . '<br>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</div>';
} catch (Error $e) {
    echo '<div class="alert alert-danger">';
    echo '<strong>Fatal Error:</strong> ' . htmlspecialchars($e->getMessage()) . '<br>';
    echo '<strong>Datei:</strong> ' . htmlspecialchars($e->getFile()) . '<br>';
    echo '<strong>Zeile:</strong> ' . $e->getLine() . '<br>';
    echo '</div>';
}