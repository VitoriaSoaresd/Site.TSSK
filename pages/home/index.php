<?php

$page_title = "";
$artlist = '';

$sql = <<<SQL

SELECT aid, title, thumbnail, resume
FROM articles
WHERE
    astatus = 'online'
    AND adate <= NOW()   
ORDER BY adate DESC;

SQL;

$res = $conn->query($sql);

// Verifica se existem artigos:
if ($res->num_rows == 0) :

    // Se não existem avisa ao front-end:
    $artlist .= '<p>Oooops! Nenhum artigo por aqui...</p>';

else :

    // Se existem, loop que obtém cada artigo:
    while ($art = $res->fetch_assoc()) :

        $artlist .= <<<HTML
 
<div class="artbox" data-link="/?view/{$art['aid']}">
    <div class="img" style="background-image: url('{$art['thumbnail']}');"></div>
    <div>
        <h3>{$art['title']}</h3>
        {$art['resume']}
    </div>
</div>

HTML;

    endwhile;

endif;

$page_content = <<<HTML

<article>
    <h2>Artigos recentes</h2>
    {$artlist}
</article>

<aside>
    <h3>Complemento</h3>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit.</p>
</aside>

HTML;