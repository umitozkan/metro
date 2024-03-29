<?php

class Router
{

    public static function parse_url()
    {
        $dirname = dirname($_SERVER['SCRIPT_NAME']);
        $dirname = $dirname !== '/' ? $dirname : null;
        $basename = basename($_SERVER['SCRIPT_NAME']);
        return str_replace([$dirname, $basename], null, $_SERVER['REQUEST_URI']);
    }

    public static function get($url, $callback)
    {
        $method = "GET";


        $method = explode('|', strtoupper($method));

        if (in_array($_SERVER['REQUEST_METHOD'], $method)) {

            $patterns = [
                '{url}' => '([0-9a-zA-Z]+)',
                '{id}' => '([0-9]+)'
            ];

            $url = str_replace(array_keys($patterns), array_values($patterns), $url);

            $request_uri = self::parse_url();

            if (preg_match('@^' . $url . '$@', $request_uri, $parameters)) {

                unset($parameters[0]);

                if (is_callable($callback)) {
                    call_user_func_array($callback, $parameters);
                } else {

                    $controller = explode('@', $callback);
                    $className = explode('/', $controller[0]);
                    $className = end($className);
                    $controllerFile = __DIR__ . '/controllers/' . strtolower($controller[0]) . '.php';

                    if (file_exists($controllerFile)) {
                        require $controllerFile;
                        call_user_func_array([new $className, $controller[1]], $parameters);
                    }

                }

            }

        }

    }

    public static function post($url, $callback)
    {
        $method = "POST";


        $method = explode('|', strtoupper($method));

        if (in_array($_SERVER['REQUEST_METHOD'], $method)) {

            $patterns = [
                '{url}' => '([0-9a-zA-Z]+)',
                '{id}' => '([0-9]+)'
            ];

            $url = str_replace(array_keys($patterns), array_values($patterns), $url);

            $request_uri = self::parse_url();

            if (preg_match('@^' . $url . '$@', $request_uri, $parameters)) {

                unset($parameters[0]);

                if (is_callable($callback)) {
                    call_user_func_array($callback, $parameters);
                } else {

                    $controller = explode('@', $callback);
                    $className = explode('/', $controller[0]);
                    $className = end($className);
                    $controllerFile = __DIR__ . '/controllers/' . strtolower($controller[0]) . '.php';

                    if (file_exists($controllerFile)) {
                        require $controllerFile;
                        call_user_func_array([new $className, $controller[1]], $parameters);
                    }

                }

            }

        }

    }
}