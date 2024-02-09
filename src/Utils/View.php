<?php
namespace Etask\Utils;

class View
{
    private static function getContentView($view)
    {
        $file = __DIR__ . '/../../resources/Views/' . $view . ".phtml";
        return file_exists($file) ? $file : null;
    }

    public static function render($view, $data = [])
    {
        $contentView  = self::getContentView($view);
        $header = __DIR__ . '/../../resources/Views/layout/header.phtml';
        $footer = __DIR__ . '/../../resources/Views/layout/footer.phtml';

        if ($contentView !== null && $contentView !== '') {
            extract($data);
            ob_start();
            // Include header
            include $header;

            // Include content view
            include $contentView;

            // Include footer
            include $footer;
            $content = ob_get_clean();

            return $content;
        } else {
            return 'A view não existe';
        }
    }

}