<?php

function html_to_markdown(?string $html = '')
{
    if ( ! $html ) {
        return '';
    }

    $html = str_replace('<br>', "\n", $html);
    $html = str_replace('<br/>', "\n", $html);
    $html = str_replace('<br />', "\n", $html);
    $html = str_replace('<p>', "\n", $html);
    $html = str_replace('</p>', "\n", $html);
    $html = str_replace('<strong>', '**', $html);
    $html = str_replace('</strong>', '**', $html);
    $html = str_replace('<em>', '*', $html);
    $html = str_replace('</em>', '*', $html);
    $html = str_replace('<u>', '__', $html);
    $html = str_replace('</u>', '__', $html);
    $html = str_replace('<h1>', '# ', $html);
    $html = str_replace('</h1>', '', $html);
    $html = str_replace('<h2>', '## ', $html);
    $html = str_replace('</h2>', '', $html);
    $html = str_replace('<h3>', '### ', $html);
    $html = str_replace('</h3>', '', $html);
    $html = str_replace('<h4>', '#### ', $html);
    $html = str_replace('</h4>', '', $html);
    $html = str_replace('<h5>', '##### ', $html);
    $html = str_replace('</h5>', '', $html);
    $html = str_replace('<h6>', '###### ', $html);
    $html = str_replace('</h6>', '', $html);


    return $html;
}
