<?php
/**
 *
 */
class View
{

    /**
     * Buffer compiled templates
     */
    public $reuseCode = true;

    /**
     * Translations
     */
    public $I18N = array();

    /**
     * Class contructor
     */
    public function __construct($TplDir, $TplExt='tpl', $TmpDir=null) {
        $this->TplDir = $TplDir;
        $this->TplExt = $TplExt;
        $this->TmpDir = is_dir($TmpDir) ? $TmpDir : sys_get_temp_dir();
    }

    /**
     * Getter
     */
    public function get($name)
    {
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    /**
     * Getter
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * Setter
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Setter
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    /**
     * Return rendered HTML code
     */
    public function fetch($tpl)
    {
        // Compiled template file
        $cpl = $this->TmpDir . DIRECTORY_SEPARATOR . str_replace(DIRECTORY_SEPARATOR, '~', $tpl) . '.html';
        // Complete template file name
        $tpl = $this->TplDir . DIRECTORY_SEPARATOR . $tpl . '.' . $this->TplExt;

        if (!is_file($tpl)) {
            throw new \Exception('Missing template "'.$tpl.'"');
        }

        if (!$this->reuseCode || !file_exists($cpl) || filemtime($cpl) < filemtime($tpl)) {
            file_put_contents($cpl, $this->render(file_get_contents($tpl)));
        }

        ob_start();
        require $cpl;
        return ob_get_clean();
    }

    /**
     * Output rendered HTML code
     */
    public function output($tpl)
    {
        echo $this->fetch($tpl);
    }

    // -----------------------------------------------------------------------
    // PROTECTED
    // -----------------------------------------------------------------------

    /**
     *
     */
    protected $TplDir;

    /**
     *
     */
    protected $TplExt;

    /**
     *
     */
    protected $TmpDir;

    /**
     *
     */
    protected $data = array();

    /**
     *
     */
    protected function render($html)
    {
        // Remove comments
        $html = preg_replace('~<!--.*?-->~ms', '', $html);

        // Translations
        $html = preg_replace('~\{\{(.+?)\}\}~', $this->e('$this->_(\'$1\')'), $html);

        // Local variable output as is
        $html = preg_replace('~\{(\$_.+?)\}~', $this->e('$1'), $html);
        // View variable output
        $html = preg_replace('~\{\$(.+?)\}~', $this->e('$this->$1'), $html);
        // Complex outputs
        $html = preg_replace('~\{echo\s+(.+?)\}~i', $this->e('$1'), $html);

        // Blocks (if, foreach)
        $html = preg_replace('~\{(if|foreach)\s+(.+?)\}~i', $this->p('$1 ($2):'), $html);
        $html = preg_replace('~\{else\}~i', $this->p('else:'), $html);
        // Block endings (if, foreach)
        $html = preg_replace('~\{/(\w+)\}~', $this->p('end$1'), $html);

        // Render sub templates
        $html = preg_replace('~\{include\s+(.+?)\}~i', $this->p('$this->output($1);'), $html);

        // Remove empty lines (http://stackoverflow.com/a/709684)
        $html = preg_replace('~(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+~', "\n", $html);

        return trim($html);
    }

    // -----------------------------------------------------------------------
    // PRIVATE
    // -----------------------------------------------------------------------

    /**
     * Translate text
     */
    private function _($text)
    {
        return isset($this->I18N[$text]) ? $this->I18N[$text] : $text;
    }

    /**
     * Wrap PHP code
     */
    private function p($code)
    {
        return '<?php ' . $code . ' ?'.'>';
    }

    /**
     * Wrap PHP echo
     */
    private function e($code)
    {
        return $this->p('echo ' . $code);
    }

}
