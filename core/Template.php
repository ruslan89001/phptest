<?php
namespace app\core;

class Template {
    private static array $blocks = [];
    private static string $cachePath = PROJECT_ROOT . '/cache/';
    private static string $templatePath = PROJECT_ROOT . '/views/';
    private static bool $cacheEnabled = false;

    public static function view(string $view, array $data = []): string {
        $cachedFile = self::cache($view);
        extract($data, EXTR_SKIP);
        ob_start();
        require $cachedFile;
        return ob_get_clean();
    }

    private static function cache(string $view): string {
        if (!file_exists(self::$cachePath)) {
            mkdir(self::$cachePath, 0744, true);
        }

        $cachedFile = self::$cachePath . str_replace(['/', '.php'], ['_', ''], $view) . '.php';

        if (!self::$cacheEnabled || !file_exists($cachedFile) ||
            filemtime(self::$templatePath . $view) > filemtime($cachedFile)) {

            $code = self::includeFiles($view);
            $code = self::compileCode($code);
            file_put_contents($cachedFile, '<?php class_exists(\'' . __CLASS__ . '\') or exit; ?>' . PHP_EOL . $code);
        }

        return $cachedFile;
    }

    private static function includeFiles(string $file): string {
        $filePath = self::$templatePath . $file;
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Template file not found: {$filePath}");
        }

        $code = file_get_contents($filePath);
        preg_match_all('/{% ?(extends|include) ?\'?(.*?)\'? ?%}/i', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $includedContent = self::includeFiles($match[2]);
            $code = str_replace($match[0], $includedContent, $code);
        }

        return $code;
    }

    private static function compileCode(string $code): string {
        $code = self::compileBlocks($code);
        $code = self::compileYields($code);
        $code = self::compileEscapedEchos($code);
        $code = self::compileEchos($code);
        return self::compilePHP($code);
    }

    private static function compilePHP(string $code): string {
        $code = preg_replace('/\{% if (.*?) %}/', '<?php if ($1): ?>', $code);
        $code = preg_replace('/\{% else %}/', '<?php else: ?>', $code);
        $code = preg_replace('/\{% endif %}/', '<?php endif; ?>', $code);

        $code = preg_replace('~\{%\s*(.+?)\s*%}~is', '<?php $1 ?>', $code);
        return $code;
    }
    private static function compileEchos(string $code): string {
        return preg_replace_callback(
            '~\{{\s*(.+?)\s*}}~is',
            function ($matches) {
                if (preg_match('/^\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $matches[1])) {
                    return '<?php echo htmlspecialchars('.$matches[1].', ENT_QUOTES) ?>';
                }
                return '<?php echo htmlspecialchars('.$matches[1].', ENT_QUOTES) ?>';
            },
            $code
        );
    }

    private static function compileEscapedEchos(string $code): string {
        return preg_replace('~\{{{\s*(.+?)\s*}}}~is', '<?php echo $1 ?>', $code);
    }

    private static function compileBlocks(string $code): string {
        preg_match_all('/{% ?block ?(.*?) ?%}(.*?){% ?endblock ?%}/is', $code, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $blockName = trim($match[1]);
            $blockContent = $match[2];

            if (!isset(self::$blocks[$blockName])) {
                self::$blocks[$blockName] = '';
            }

            if (!str_contains($blockContent, '@parent')) {
                self::$blocks[$blockName] = $blockContent;
            } else {
                self::$blocks[$blockName] = str_replace('@parent', self::$blocks[$blockName], $blockContent);
            }

            $code = str_replace($match[0], '', $code);
        }

        return $code;
    }

    private static function compileYields(string $code): string {
        foreach (self::$blocks as $block => $content) {
            $code = preg_replace('/{% ?yield ?' . preg_quote($block) . ' ?%}/', $content, $code);
        }
        return preg_replace('/{% ?yield ?(.*?) ?%}/i', '', $code);
    }

    public static function clearCache(): void {
        array_map('unlink', glob(self::$cachePath . '*'));
    }

    public static function setCacheEnabled(bool $enabled): void {
        self::$cacheEnabled = $enabled;
    }

}