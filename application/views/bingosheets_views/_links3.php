    <?php
    echo "<ul>";
    foreach($menu as $link_text=>$link_url)
    {
        if (isArray($link_text))
        {
            echo "<li><a href=$link_url>$link_text</a>";
            echo "<ul>";
        }
        else
        {
            echo "<li><a href=$link_url>$link_text</a></li>";
        }
    }
    echo "</ul>";
    ?>

