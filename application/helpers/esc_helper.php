<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * esc() helper untuk CodeIgniter 3
 * Meniru fungsi esc() dari CodeIgniter 4.
 * Melakukan HTML encoding untuk mencegah XSS.
 *
 * @param  mixed  $data
 * @param  string $context  (html, url, attr, css, js — saat ini hanya 'html')
 * @param  string $encoding
 * @return mixed
 */
if (!function_exists('esc')) {
    function esc($data, $context = 'html', $encoding = 'UTF-8') {
        if (is_array($data)) {
            foreach ($data as &$value) {
                $value = esc($value, $context, $encoding);
            }
            return $data;
        }

        if (is_null($data) || $data === '') {
            return $data;
        }

        switch (strtolower($context)) {
            case 'html':
            default:
                return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, $encoding);
            case 'attr':
                return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, $encoding);
            case 'url':
                return rawurlencode($data);
            case 'js':
                return json_encode($data, JSON_UNESCAPED_UNICODE);
            case 'css':
                return preg_replace('/[^a-zA-Z0-9\s\-_.,]/', '', $data);
        }
    }
}
