<?php

namespace app\core;

class View {
    public string $title = '';

    public function renderView($view, $params = []): array|bool|string {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent): array|bool|string {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent(): bool|string {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        include_once Application::$ROOT_DIR.'/views/layouts/'.$layout.'.php';
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params): bool|string {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR.'/views/'.$view.'.php';
        return ob_get_clean();
    }
}