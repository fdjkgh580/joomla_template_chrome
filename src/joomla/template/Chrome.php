<?php
namespace Jsnlib\Joomla\Template;

class Chrome
{
    // chrome 路徑，底下會有多個樣式 HTML
    protected static $chromePath;

    /**
     * 設定區塊的路徑
     * @param  string $chromePath 區塊的資料夾路徑
     * @return void
     */
    public static function dir(string $chromePath): void
    {
        if (!file_exists($chromePath))
        {
            throw new \Exception("路徑不存在：{$chromePath}");
        }

        $filepath = $chromePath . DIRECTORY_SEPARATOR . 'style';

        if (!file_exists($filepath))
        {
            throw new \Exception("請建立路徑：{$filepath}");
        }

        self::$chromePath = $filepath;
    }

    /**
     * 渲染並輸出
     * @param  string   $chromeFilename 區塊的檔案名稱
     * @param  callable $callback       取得模板的參數
     * @return bool     true
     */
    public static function render(string $chromeFilename, callable $callback): bool
    {
        echo self::put($chromeFilename, $callback);

        return true;
    }

    /**
     * 渲染並提取，不直接顯示
     * @param  string   $chromeFilename 區塊的檔案名稱
     * @param  callable $callback       取得模板的參數
     * @return string   渲染過後的 HTML
     */
    public static function get(string $chromeFilename, callable $callback): string
    {
        return self::put($chromeFilename, $callback);
    }

    /**
     * 透過 Twig 模板系統設置參數到區塊，並返回渲染後的結果
     * @param  string   $chromeFilename 區塊的檔案名稱
     * @param  callable $callback       取得模板的參數
     * @return string   渲染過後的 HTML
     */
    protected static function put(string $chromeFilename, callable $callback): string
    {
        $realFileName = self::$chromePath . DIRECTORY_SEPARATOR . $chromeFilename;

        if (!file_exists($realFileName))
        {
            throw new \Exception("模板樣式不存在：{$realFileName}");
        }

        $loader = new \Twig_Loader_Filesystem(self::$chromePath);

        $twig = new \Twig_Environment($loader);

        // 取得使用者要帶入的參數
        $inpuData = $callback($loader, $twig);

        $renderHtml = $twig->render($chromeFilename, $inpuData);

        return $renderHtml;
    }
}
