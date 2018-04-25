# joomla_template_chrome
讓製作模板區塊的部分，可以分離 PHP 與 HTML，可以更容易閱讀 HTML 與邏輯。以前台為範例，假設我們自訂模板名稱叫做 ````mynewtemplate````：

## 區塊PHP 
templates/mynewtemplate/html/modules.php
````php
require_once JPATH_BASE . '/vendor/autoload.php';

use \Jsnlib\Joomla\Template\Chrome;

// 設定區塊的路徑
Chrome::dir(__DIR__); 

function modChrome_lalaland($module, &$params, &$attribs)
{
    // 讓 Chrome 自動讀取 templates/mynewtemplate/html/style/lalaland.html
    // 帶入外部變數 $module
    Chrome::render('lalaland.html', function () use ($module)
    {
        // 在這裡可以做任何參數的處理，最後回傳參數提供渲染
        return ['module' => $module];
    });
}
````

## 區塊HTML
templates/mynewtemplate/html/style/lalaland.html
````php
<article>
    <header>
        <h1>{{ module.title }}</h1>
    </header>
    {{ module.content | raw }}
</article>
````
