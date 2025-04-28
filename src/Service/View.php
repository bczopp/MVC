<?php
namespace Tornado\Service;

class View
{
    private string $path = __DIR__ . '/../../views';

    public function __construct() {}

    /**
     * @param string $template
     * @param array $vars
     * @param array $replacements
     * @return string
     */
    public function render(string $template, array $vars = [], array $replacements = []): string
    {
        $file = "{$this->path}/{$template}.php";
        if (!file_exists($file)) {
            throw new \RuntimeException("View $file not found");
        }

        $output = $this->replace($file, $replacements);

        return $this->run($vars, $output);
    }

    /**
     * @param string $file
     * @param array $replacements
     * @return string
     */
    private function replace(string $file, array $replacements): string
    {
        $output = file_get_contents($file);
        foreach ($replacements as $k => $v) {
            $output = str_replace("{{ {$k} }}", htmlspecialchars((string)$v), $output);
        }
        return $output;
    }

    /**
     * @param array $vars
     * @param string $output
     * @return string
     */
    private function run(array $vars, string $output): string
    {
        extract($vars);
        ob_start();
        // THIS MIGHT BE DANGEROUS IF NOT TAKEN CARE OF
        eval('?>' . $output);  // Execute the PHP code in the template
        return ob_get_clean();
    }
}
